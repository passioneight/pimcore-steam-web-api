<?php

namespace Passioneight\PimcoreSteamWebApi\EventSubscribers;

use Passioneight\PimcoreSteamWebApi\Event\OpenId\AlreadyConnectedEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\AlreadyDisconnectedEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\ConnectedEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\CouldNotConnectEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\CouldNotDisconnectEvent;
use Passioneight\PimcoreSteamWebApi\Event\OpenId\DisconnectedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class SteamOpenIdSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ConnectedEvent::class => "onConnected",
            DisconnectedEvent::class => "onDisconnected",
            AlreadyConnectedEvent::class => "onAlreadyConnected",
            AlreadyDisconnectedEvent::class => "onAlreadyDisconnected",
            CouldNotConnectEvent::class => "onCouldNotConnect",
            CouldNotDisconnectEvent::class => "onCouldNotDisconnect",
        ];
    }

    abstract public function onConnected(ConnectedEvent $event);

    abstract public function onDisconnected(DisconnectedEvent $event);

    abstract public function onAlreadyConnected(AlreadyConnectedEvent $event);

    abstract public function onAlreadyDisconnected(AlreadyDisconnectedEvent $event);

    abstract public function onCouldNotConnect(CouldNotConnectEvent $event);

    abstract public function onCouldNotDisconnect(CouldNotDisconnectEvent $event);
}
