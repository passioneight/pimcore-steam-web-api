<?php

namespace Passioneight\PimcoreSteamWebApi\Service\Api;

use Passioneight\PimcoreSteamWebApi\Constant\SteamApiNamespace;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamUtilApi extends SteamWebApi
{
    /**
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getServerInfo(): ResponseInterface
    {
        $url = $this->createUrl(SteamApiNamespace::STEAM_WEB_API_UTIL, "GetServerInfo");
        return $this->get($url);
    }

    /**
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getSupportedAPIList(): ResponseInterface
    {
        $url = $this->createUrl(SteamApiNamespace::STEAM_WEB_API_UTIL, "GetSupportedAPIList");
        return $this->get($url, $this->addApiKey([]));
    }
}
