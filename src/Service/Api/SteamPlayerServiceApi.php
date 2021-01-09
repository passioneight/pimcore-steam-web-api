<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\SteamApiNamespace;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamPlayerServiceApi extends SteamWebApi
{
    /**
     * @param string $steamId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getRecentlyPlayedGames(string $steamId, array $options = []): ResponseInterface
    {
        $options['steamid'] =  $steamId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_PLAYER_SERVICE, "GetRecentlyPlayedGames");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string $steamId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getOwnedGames(string $steamId, array $options = []): ResponseInterface
    {
        $options['steamid'] =  $steamId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_PLAYER_SERVICE, "GetOwnedGames");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string $steamId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getSteamLevel(string $steamId, array $options = []): ResponseInterface
    {
        $options['steamid'] =  $steamId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_PLAYER_SERVICE, "GetSteamLevel");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string $steamId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getBadges(string $steamId, array $options = []): ResponseInterface
    {
        $options['steamid'] =  $steamId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_PLAYER_SERVICE, "GetBadges");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string $steamId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getCommunityBadgeProgress(string $steamId, array $options = []): ResponseInterface
    {
        $options['steamid'] =  $steamId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_PLAYER_SERVICE, "GetCommunityBadgeProgress");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string $steamId
     * @param string $appId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function isPlayingSharedGame(string $steamId, string $appId, array $options = []): ResponseInterface
    {
        $options['steamid'] =  $steamId;
        $options['appid_playing'] =  $appId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_PLAYER_SERVICE, "IsPlayingSharedGame");
        return $this->get($url, $this->addApiKey($apiOptions));
    }
}
