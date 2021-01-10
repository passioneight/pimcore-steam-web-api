<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\EventSubscribers;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\AlreadyConnectedEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\AlreadyDisconnectedEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\ConnectedEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\CouldNotConnectEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\CouldNotDisconnectEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\DisconnectedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class SteamOpenIdSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
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

    /**
     * @param ConnectedEvent $event
     */
    abstract public function onConnected(ConnectedEvent $event);

    /**
     * @param DisconnectedEvent $event
     */
    abstract public function onDisconnected(DisconnectedEvent $event);

    /**
     * @param AlreadyConnectedEvent $event
     */
    abstract public function onAlreadyConnected(AlreadyConnectedEvent $event);

    /**
     * @param AlreadyDisconnectedEvent $event
     */
    abstract public function onAlreadyDisconnected(AlreadyDisconnectedEvent $event);

    /**
     * @param CouldNotConnectEvent $event
     */
    abstract public function onCouldNotConnect(CouldNotConnectEvent $event);

    /**
     * @param CouldNotDisconnectEvent $event
     */
    abstract public function onCouldNotDisconnect(CouldNotDisconnectEvent $event);
}
