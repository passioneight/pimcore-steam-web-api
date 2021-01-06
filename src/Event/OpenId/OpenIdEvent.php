<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class OpenIdEvent extends Event
{
    const MESSAGE_CONNECTED = "openid.connected";
    const MESSAGE_ALREADY_CONNECTED = "openid.already-connected";

    const MESSAGE_DISCONNECTED = "openid.disconnected";
    const MESSAGE_ALREADY_DISCONNECTED = "openid.already-disconnected";

    private UserInterface $user;
    private string $translationKey;

    /**
     * OpenIdEvent constructor.
     * @param UserInterface $user
     * @param string $translationKey
     */
    public function __construct(UserInterface $user, string $translationKey)
    {
        $this->user = $user;
        $this->type = $translationKey;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getTranslationKey(): string
    {
        return $this->type;
    }
}
