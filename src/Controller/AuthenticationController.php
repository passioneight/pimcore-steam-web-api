<?php

namespace Passioneight\PimcoreSteamWebApi\Controller;

use Passioneight\PimcoreSteamWebApi\Event\OpenId\AlreadyConnectedEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\AlreadyDisconnectedEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\ConnectedEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\CouldNotConnectEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\CouldNotDisconnectEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\DisconnectedEvent;
use Passioneight\PimcoreSteamWebApi\Service\Authentication\SteamOpenId;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/steam")
 */
class AuthenticationController extends FrontendController
{
    /**
     * @Route("/open-id")
     *
     * @param Request $request
     * @param SteamOpenId $steamOpenId
     * @param EventDispatcherInterface $eventDispatcher
     * @return Response
     */
    public function openIdAction(Request $request, SteamOpenId $steamOpenId, EventDispatcherInterface $eventDispatcher)
    {
        $user = $this->getUser();

        if ($user->getSteamProfile()) {
            $event = new AlreadyConnectedEvent($user);
            $eventDispatcher->dispatch($event);
        } else {
            $steamId = $steamOpenId->getSteamId($request);

            if (!empty($steamId)) {
                $event = new ConnectedEvent($user, $steamId);
                $eventDispatcher->dispatch($event);
            } else {
                $event = new CouldNotConnectEvent($user);
                $eventDispatcher->dispatch($event);
            }
        }

        return $event->getResponse();
    }

    /**
     * @Route("/revoke-open-id")
     *
     * @param Request $request
     * @param EventDispatcherInterface $eventDispatcher
     * @return Response
     */
    public function revokeOpenIdAction(Request $request, EventDispatcherInterface $eventDispatcher)
    {
        $user = $this->getUser();
        $steamProfile = $user->getSteamProfile();

        if (empty($steamProfile)) {
            $event = new AlreadyDisconnectedEvent($user);
            $eventDispatcher->dispatch($event);
        } else {
            try {
                $steamProfile->delete();

                $event = new DisconnectedEvent($user);
                $eventDispatcher->dispatch($event);
            } catch (\Exception $e) {
                $event = new CouldNotDisconnectEvent($user);
                $eventDispatcher->dispatch($event);
            }
        }

        return $event->getResponse();
    }
}
