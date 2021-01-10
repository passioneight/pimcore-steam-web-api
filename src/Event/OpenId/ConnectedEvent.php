<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId;

use Symfony\Component\Security\Core\User\UserInterface;

class ConnectedEvent extends OpenIdEvent
{
    private string $steamId;

    /**
     * ConnectedEvent constructor.
     * @param UserInterface $user
     * @param string $steamId
     */
    public function __construct(UserInterface $user, string $steamId)
    {
        parent::__construct($user);
        $this->steamId = $steamId;
    }

    /**
     * @return string
     */
    public function getSteamId(): string
    {
        return $this->steamId;
    }

    /**
     * @return string
     */
    public function getTranslationKey(): string
    {
        return "openid.connected";
    }
}