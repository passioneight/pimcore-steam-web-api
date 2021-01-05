<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Controller;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject\UserInterface;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\SteamOpenId;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\SteamWebApiService;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/open-id/steam")
 *
 * Class SteamOpenIdController
 * @package Passioneight\Bundle\PimcoreSteamWebApiBundle\Controller
 */
class SteamOpenIdController extends FrontendController
{
    /**
     * @Route("/connect")
     *
     * @param Request $request
     * @param SteamWebApiService $steamWebApiService
     * @param EventDispatcherInterface $eventDispatcher
     * @return RedirectResponse
     */
    public function connectAction(Request $request, SteamWebApiService $steamWebApiService, EventDispatcherInterface $eventDispatcher)
    {
        /** @var UserInterface $user */
        $user = $this->getUser();

        $steamId = $steamWebApiService->getSteamId($request);

        if(!empty($steamId)) {
            $user->setSteamId($steamId);
            $user->save(['versionNote' => 'Connected to Steam']);

            // TODO: start command to populate user with steam-data

            // TODO: dispatch event --> allows to e.g. show success message to user
        } else {
            // TODO: dispatch event --> allows to e.g. show error message to user
        }

        return new RedirectResponse('/');    // TODO: add bundle config to allow setting the redirect value here
    }

    public function disconnectAction()
    {
        // TODO: implement this to allow disconnected from steam again
    }
}
