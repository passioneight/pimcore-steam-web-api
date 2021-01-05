<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\UrlUtility;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\OpenIdMode;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\OpenIdParameter;
use Pimcore\Tool;

class SteamOpenId
{
    const PROVIDER_URL = 'https://steamcommunity.com/openid';

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
     * @param string $redirectUrl
     * @param array $parameters to override/extend the appended parameters
     * @return string
     */
    public function createOpenIdUrl(string $redirectUrl, array $parameters = []): string
    {
        $config = [
            // TODO: add these values as bundle configuration?
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
     * @return string
     */
    protected function getLoginUrl(): string
    {
        return UrlUtility::join($this->providerUrl, "login");
    }
}
