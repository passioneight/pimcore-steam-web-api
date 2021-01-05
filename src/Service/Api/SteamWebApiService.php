<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\OpenIdParameter;
use Symfony\Component\HttpFoundation\Request;

class SteamWebApiService
{
    /**
     * @param Request $request
     * @return string|null
     */
    public function getSteamId(Request $request): ?string
    {
        return $request->get(OpenIdParameter::IDENTITY);
    }
}
