<?php

namespace Passioneight\PimcoreSteamWebApi\Service\Api;

use Passioneight\PimcoreSteamWebApi\Constant\SteamApiNamespace;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamUserApi extends SteamWebApi
{
    /**
     * @param string $steamId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getFriendList(string $steamId, array $options = []): ResponseInterface
    {
        $options['steamid'] = $steamId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER, "GetFriendList");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string ...$steamIds
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getPlayerBans(...$steamIds): ResponseInterface
    {
        $options['steamids'] = implode(",", $steamIds);
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER, "GetPlayerBans");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string ...$steamIds
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getPlayerSummaries(...$steamIds): ResponseInterface
    {
        $options['steamids'] = implode(",", $steamIds);
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER, "GetPlayerSummaries");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string $steamId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getUserGroupList(string $steamId, array $options = []): ResponseInterface
    {
        $options['steamid'] = $steamId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER, "GetUserGroupList");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string $vanityName
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function resolveVanityUrl(string $vanityName, array $options = []): ResponseInterface
    {
        $options['vanityurl'] = $vanityName;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER, "ResolveVanityURL");
        return $this->get($url, $this->addApiKey($apiOptions));
    }
}
