<?php

namespace Passioneight\PimcoreSteamWebApi\Service\Api;

use Passioneight\PimcoreSteamWebApi\Constant\SteamApiNamespace;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamNewsApi extends SteamWebApi
{
    /**
     * @param string $appId
     * @param array $options
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getNewsForApp(string $appId, array $options = []): ResponseInterface
    {
        $options['appid'] = $appId;
        $apiOptions['query'] = $options;

        $url = $this->createUrl(SteamApiNamespace::STEAM_NEWS, "GetNewsForApp");
        return $this->get($url, $apiOptions);
    }
}
