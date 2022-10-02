<?php

namespace Passioneight\PimcoreSteamWebApi\Event\OpenId;

class DisconnectedEvent extends OpenIdEvent
{
    /**
     * @return string
     */
    public function getTranslationKey(): string
    {
        return "openid.disconnected";
    }
}
