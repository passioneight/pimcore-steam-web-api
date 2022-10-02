<?php

namespace Passioneight\PimcoreSteamWebApi\Service\Configuration;

use Passioneight\Bundle\PimcoreUtilitiesBundle\Traits\BundleConfigurationAwareTrait;
use Passioneight\PimcoreSteamWebApi\Constant\Configuration;

class SteamWebApiConfiguration
{
    use BundleConfigurationAwareTrait;

    public function getApiKey(): string
    {
        return $this->getConfiguration()[Configuration::API_KEY];
    }

    public function getBaseUrl(): string
    {
        return $this->getConfiguration()[Configuration::BASE_URL];
    }
}
