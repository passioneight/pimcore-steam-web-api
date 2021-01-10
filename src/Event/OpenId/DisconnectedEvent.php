<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId;

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
