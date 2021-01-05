<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Controller;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject\SteamUserInterface;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Authentication\SteamOpenId;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamWebApiService;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Security\FirewallService;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

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
        exit;
    }
}
