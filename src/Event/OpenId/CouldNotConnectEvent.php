<?php

namespace Passioneight\PimcoreSteamWebApi\Event\OpenId;

class CouldNotConnectEvent extends OpenIdEvent
{
    /**
     * @return string
     */
    public function getTranslationKey(): string
    {
        return "openid.could-not-connect";
    }
}
