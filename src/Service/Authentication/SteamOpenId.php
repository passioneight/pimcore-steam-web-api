<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Authentication;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\UrlUtility;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\OpenIdMode;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\OpenIdParameter;
use Pimcore\Tool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class SteamOpenId
{
    const PROVIDER_URL = 'https://steamcommunity.com/openid';

    private RouterInterface $router;
    private string $providerUrl;

    /**
     * SteamOpenId constructor.
     * @param string $providerUrl
     */
    public function __construct(string $providerUrl = self::PROVIDER_URL)
    {
        $this->providerUrl = $providerUrl;
    }

    /**
     * @return string
     */
    public function generateLinkSteamAccountUrl(): string
    {
        $redirectUrl = Tool::getHostUrl() . $this->router->generate('passioneight_pimcoresteamwebapi_authentication_openid');
        return $this->createOpenIdUrl($redirectUrl);
    }

    /**
     * @return string
     */
    public function generateUnlinkSteamAccountUrl(): string
    {
        return $this->router->generate('passioneight_pimcoresteamwebapi_authentication_revokeopenid');
    }

    /**
     * @param string $redirectUrl
     * @param array $parameters to override/extend the appended parameters
     * @return string
     */
    public function createOpenIdUrl(string $redirectUrl, array $parameters = []): string
    {
        $config = [
            OpenIdParameter::NAMESPACE => "http://specs.openid.net/auth/2.0",
            OpenIdParameter::SREG => "http://openid.net/extensions/sreg/1.1",
            OpenIdParameter::CLAIMED_ID => "http://specs.openid.net/auth/2.0/identifier_select",
            OpenIdParameter::IDENTITY => "http://specs.openid.net/auth/2.0/identifier_select",
            OpenIdParameter::MODE => OpenIdMode::CHECK_ID_SETUP,
            OpenIdParameter::REALMS => Tool::getHostUrl(),
            OpenIdParameter::RETURN_TO => $redirectUrl
        ];

        $query = http_build_query(array_merge($config, $parameters));

        return UrlUtility::appendToUrl($this->getLoginUrl(), $query);
    }

    /**
     * @todo: move this to a different service
     * @param Request $request
     * @return string|null
     */
    public function getSteamId(Request $request): ?string
    {
        return UrlUtility::getEndpointFromUrl($this->getIdentity($request));
    }

    /**
     * @param Request $request
     * @return string|null
     */
    public function getIdentity(Request $request): ?string
    {
        return $request->get($this->convertParameterToSymfonyFormat(OpenIdParameter::IDENTITY));
    }

    /**
     * @param string $parameter
     * @param string $openIdDelimiter
     * @param string $symfonyDelimiter
     * @return string
     */
    public function convertParameterToSymfonyFormat(string $parameter, string $openIdDelimiter = ".", string $symfonyDelimiter = "_"): string
    {
        return str_replace($openIdDelimiter, $symfonyDelimiter, $parameter);
    }

    /**
     * @return string
     */
    protected function getLoginUrl(): string
    {
        return UrlUtility::join($this->providerUrl, "login");
    }

    /**
     * @required
     * @internal
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }
}
