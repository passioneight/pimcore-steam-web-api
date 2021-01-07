<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Command;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject\SteamUserInterface;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\Steam\SteamProfileInfo;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamWebApiService;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\SteamResponseService;
use Pimcore\Console\AbstractCommand as PimcoreCommand;
use Pimcore\Model\DataObject\SteamProfile;

abstract class AbstractSteamCommand extends PimcoreCommand
{
    protected SteamWebApiService $steamWebApiService;

    /**
     * @required
     * @internal
     * @param SteamWebApiService $steamWebApiService
     */
    public function setSteamWebApiService(SteamWebApiService $steamWebApiService)
    {
        $this->steamWebApiService = $steamWebApiService;
    }
}
