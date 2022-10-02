<?php

namespace Passioneight\PimcoreSteamWebApi\Service\Api;

use Passioneight\PimcoreSteamWebApi\Constant\SteamApiNamespace;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamUserStatsApi extends SteamWebApi
{
    /**
     * @param string $gameId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getGlobalAchievementPercentagesForApp(string $gameId, array $options = []): ResponseInterface
    {
        $options['gameid'] = $gameId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER_STATS, "GetGlobalAchievementPercentagesForApp");
        return $this->get($url, $apiOptions);
    }

    /**
     * @param string $appId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getNumberOfCurrentPlayers(string $appId, array $options = []): ResponseInterface
    {
        $options['appid'] = $appId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER_STATS, "GetNumberOfCurrentPlayers");
        return $this->get($url, $apiOptions);
    }

    /**
     * @param string $steamId
     * @param string $appId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getPlayerAchievements(string $steamId, string $appId, array $options = []): ResponseInterface
    {
        $options['steamid'] = $steamId;
        $options['appid'] = $appId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER_STATS, "GetPlayerAchievements");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string $appId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getSchemaForGame(string $appId, array $options = []): ResponseInterface
    {
        $options['appid'] = $appId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER_STATS, "GetSchemaForGame");
        return $this->get($url, $this->addApiKey($apiOptions));
    }

    /**
     * @param string $steamId
     * @param string $appId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getUserStatsForGame(string $steamId, string $appId, array $options = []): ResponseInterface
    {
        $options['steamid'] = $steamId;
        $options['appid'] = $appId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_USER_STATS, "GetUserStatsForGame");
        return $this->get($url, $this->addApiKey($apiOptions));
    }
}
