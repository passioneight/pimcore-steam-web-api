<?php

namespace Passioneight\PimcoreSteamWebApi\Service\Api;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\UrlUtility;
use Passioneight\PimcoreSteamWebApi\Constant\SteamApiNamespace;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamAppsApi extends SteamWebApi
{
    /**
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getAppList(): ResponseInterface
    {
        $endpoint = UrlUtility::join($this->bundleConfiguration->getBaseUrl(), SteamApiNamespace::STEAM_APPS, "GetAppList", $this->version);
        return $this->get($endpoint);
    }
}
