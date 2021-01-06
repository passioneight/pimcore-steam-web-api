<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\SteamProfile;

use Passioneight\Bundle\PhpUtilitiesBundle\Constant\Constant;

class PersonState extends Constant
{
    const OFFLINE = 0;
    const ONLINE = 1;
    const BUSY = 2;
    const AWAY = 3;
    const SNOOZE = 4;
    const LOOKING_TO_TRADE = 5;
    const LOOKING_TO_PLAY = 6;
}