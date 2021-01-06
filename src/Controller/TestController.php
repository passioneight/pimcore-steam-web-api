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
        /** @var SteamUserInterface $user */
        $user = $this->getUser();

        $response = $steamWebApiService
            ->useVersion("v2")
            ->getProfileInfo($user->getSteamId());

        p_r($response->getContent());

        $response = $steamWebApiService
            ->resetVersion()
            ->getOwnedGames($user->getSteamId());

        $games = $response->toArray()['response']['games'] ?: [];
        $appIds = array_map(function(array $game){
            return $game["appid"];
        }, $games);

        $response = $steamWebApiService
            ->useVersion("v2")
            ->getAppList();

        $apps = $response->toArray()['applist']['apps'];
        $matchedApps = array_filter($apps, function(array $app) use($appIds) {
            return in_array($app["appid"], $appIds);
        });

        p_r('You have the following games:');
        p_r($matchedApps);

        exit;
    }
}
