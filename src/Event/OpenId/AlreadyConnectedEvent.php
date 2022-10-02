<?php

namespace Passioneight\PimcoreSteamWebApi\Event\OpenId;

class AlreadyConnectedEvent extends OpenIdEvent
{
    /**
     * @return string
     */
    public function getTranslationKey(): string
    {
        return "openid.already-connected";
    }
}
