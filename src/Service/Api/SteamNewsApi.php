<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\SteamApiNamespace;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamNewsApi extends SteamWebApi
{
    /**
     * @param string $steamId
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
