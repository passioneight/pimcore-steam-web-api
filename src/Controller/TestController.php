<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Controller;

use AppBundle\Model\Entity\User;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject\SteamUserInterface;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamAppsApi;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamPlayerServiceApi;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamUserApi;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamUserStatsApi;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamUtilApi;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamWebApi;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/steam/test")
 */
class TestController extends FrontendController
{
    /**
     * @Route("/user")
     *
     * @param SteamUserApi $steamUserApi
     */
    public function testUserAction(SteamUserApi $steamUserApi)
    {
        $user = User::getById(16);
        $steamId = $user->getSteamProfile()->getSteamId();

        echo "SteamID: $steamId";

        $response = $steamUserApi
            ->getFriendList($steamId, ["relationship" => "friend"]);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching friends results in status code: " . $response->getStatusCode());
        }

        $response = $steamUserApi
            ->getPlayerBans($steamId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching player bans results in status code: " . $response->getStatusCode());
        }

        $response = $steamUserApi
            ->useVersion(SteamWebApi::VERSION_2)
            ->getPlayerSummaries($steamId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching player summaries results in status code: " . $response->getStatusCode());
        }

        $response = $steamUserApi
            ->resetVersion()
            ->getUserGroupList('76561199041764790');

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching user group list resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamUserApi
            ->resolveVanityUrl('zuro92');

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching steam id from vanity url resulted in status code: " . $response->getStatusCode());
        }

        exit;
    }

    /**
     * @Route("/user-stats")
     *
     * @param SteamUserStatsApi $steamUserStatsApi
     */
    public function testUserStatsAction(SteamUserStatsApi $steamUserStatsApi)
    {
        $user = User::getById(16);
        $steamId = $user->getSteamProfile()->getSteamId();
        $gameId = 440;

        echo "SteamID: $steamId";

        $response = $steamUserStatsApi
            ->useVersion(SteamWebApi::VERSION_2)
            ->getGlobalAchievementPercentagesForApp($gameId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching global achievement percentages resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamUserStatsApi
            ->resetVersion()
            ->getNumberOfCurrentPlayers($gameId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching number of current players resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamUserStatsApi
            ->resetVersion()
            ->getPlayerAchievements($steamId, $gameId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching player achievements resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamUserStatsApi
            ->useVersion(SteamWebApi::VERSION_2)
            ->getSchemaForGame($gameId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching player achievements resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamUserStatsApi
            ->useVersion(SteamWebApi::VERSION_2)
            ->getUserStatsForGame($steamId, $gameId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching player achievements resulted in status code: " . $response->getStatusCode());
        }

        exit;
    }

    /**
     * @Route("/apps")
     *
     * @param SteamAppsApi $steamAppsApi
     */
    public function testAppsAction(SteamAppsApi $steamAppsApi)
    {
        $user = User::getById(16);
        $steamId = $user->getSteamProfile()->getSteamId();

        echo "SteamID: $steamId";

        $response = $steamAppsApi
            ->getAppList();

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching app list resulted in status code: " . $response->getStatusCode());
        }

        exit;
    }

    /**
     * @Route("/util")
     *
     * @param SteamUtilApi $steamUtilApi
     */
    public function testUtilAction(SteamUtilApi $steamUtilApi)
    {
        $user = User::getById(16);
        $steamId = $user->getSteamProfile()->getSteamId();

        echo "SteamID: $steamId";

        $response = $steamUtilApi
            ->getServerInfo();

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching server info resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamUtilApi
            ->getSupportedAPIList();

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching server info resulted in status code: " . $response->getStatusCode());
        }

        exit;
    }

    /**
     * @Route("/player-service")
     *
     * @param SteamPlayerServiceApi $steamPlayerServiceApi
     */
    public function testPlayerServiceAction(SteamPlayerServiceApi $steamPlayerServiceApi)
    {
        $user = User::getById(16);
        $steamId = $user->getSteamProfile()->getSteamId();

        echo "SteamID: $steamId";

        $response = $steamPlayerServiceApi
            ->getRecentlyPlayedGames($steamId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching recently played games resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamPlayerServiceApi
            ->getOwnedGames($steamId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching owned played games resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamPlayerServiceApi
            ->getSteamLevel($steamId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching steam level resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamPlayerServiceApi
            ->getBadges($steamId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching badges resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamPlayerServiceApi
            ->getCommunityBadgeProgress($steamId);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching community badge progress resulted in status code: " . $response->getStatusCode());
        }

        $response = $steamPlayerServiceApi
            ->isPlayingSharedGame($steamId, 440);

        if($response->getStatusCode() === Response::HTTP_OK) {
            p_r($response->toArray());
        } else {
            p_r("Fetching is playing shared game resulted in status code: " . $response->getStatusCode());
        }

        exit;
    }
}
