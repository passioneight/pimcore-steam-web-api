<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\UrlUtility;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\OpenIdParameter;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\SteamApiNamespace;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamWebApiService extends WebApiService
{
    // TODO: add this as configuration...
    const BASE_URL = "https://api.steampowered.com";

    private string $version;
    private string $defaultVersion;

    /**
     * SteamWebApiService constructor.
     * @param string $version
     */
    public function __construct(string $version = "v1")
    {
        $this->defaultVersion = $version;
        $this->version = $this->defaultVersion;
    }

    /**
     * Make the API use a specific version.
     * Attention: you need to call self#resetVersion to reset the version
     *
     * @param string $version
     * @return self
     */
    public function useVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @param string ...$steamIds
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getProfileInfo(...$steamIds): ResponseInterface
    {
        $options = [
            'query' => [
                'steamIds' => implode(",", $steamIds)
            ]
        ];

        $endpoint = UrlUtility::join(self::BASE_URL, SteamApiNamespace::STEAM_USER, "GetPlayerSummaries", $this->version);
        return $this->get($endpoint, $this->addApiKey($options));
    }

    /**
     * @return $this
     */
    protected function resetVersion(): self
    {
        $this->version = $this->getDefaultVersion();
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultVersion(): string
    {
        return $this->defaultVersion;
    }

    /**
     * @param array $options
     * @return array
     */
    protected function addApiKey(array $options)
    {
        $options = array_key_exists('query', $options) ? $options : ['query' => []];
        $options['query'] = array_merge($options['query'], ['key' => '4AF7701C5FD23453830F1079728B6C22']);  // TODO: load this key from config
        return $options;
    }
}
