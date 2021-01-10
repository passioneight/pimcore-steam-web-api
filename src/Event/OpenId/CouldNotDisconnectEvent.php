<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId;

class CouldNotDisconnectEvent extends OpenIdEvent
{
    /**
     * @return string
     */
    public function getTranslationKey(): string
    {
        return "openid.could-not-disconnect";
    }
}
