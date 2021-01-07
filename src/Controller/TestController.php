<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Controller;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject\SteamUserInterface;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamWebApiService;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * @Route("/steam")
 */
class TestController extends FrontendController
{
    use TargetPathTrait;

    /**
     * @Route("/test")
     *
     * @param Request $request
     * @param SteamWebApiService $steamWebApiService
     */
    public function testAction(Request $request, SteamWebApiService $steamWebApiService)
    {
        $user = $this->getUser();
        $steamId = $user->getSteamProfile()->getSteamId();

//        $response = $steamWebApiService
//            ->useVersion(SteamWebApiService::VERSION_2)
//            ->getPlayerSummaries($steamId);
//
//        p_r($response->toArray());

//        $response = $steamWebApiService
//            ->useVersion(SteamWebApiService::VERSION_2)
//            ->getNewsForApp(440);
//
//        p_r($response->toArray());

//        $response = $steamWebApiService
//            ->getFriendList(76561198018470574);
//
//        p_r($response->toArray());

//        $response = $steamWebApiService
//            ->useVersion(SteamWebApiService::VERSION_2)
//            ->getGlobalAchievementPercentages(440);
//
//        p_r($response->toArray());
//
//        $response = $steamWebApiService
//            ->resetVersion()
//            ->getOwnedGames($steamId);
//
//        p_r($response->toArray());

//        $response = $steamWebApiService
//            ->resetVersion()
//            ->getRecentlyPlayedGames($steamId);
//
//        p_r($response->toArray());
//
//        $games = $response->toArray()['response']['games'] ?: [];
//        $appIds = array_map(function(array $game){
//            return $game["appid"];
//        }, $games);
//
//        $response = $steamWebApiService
//            ->useVersion(SteamWebApiService::VERSION_2)
//            ->getAppList();
//
//        p_r($response->getContent());
//
//        $apps = $response->toArray()['applist']['apps'];
//        $matchedApps = array_filter($apps, function(array $app) use($appIds) {
//            return in_array($app["appid"], $appIds);
//        });
//
//        p_r('You have the following games:');
//        p_r($matchedApps);

        exit;
    }
}
