<?php

namespace Passioneight\PimcoreSteamWebApi\Event\OpenId;

class AlreadyDisconnectedEvent extends OpenIdEvent
{
    /**
     * @return string
     */
    public function getTranslationKey(): string
    {
        return "openid.already-disconnected";
    }
}
