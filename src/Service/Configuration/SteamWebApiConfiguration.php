<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Configuration;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\Configuration;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SteamWebApiConfiguration
{
    /** @var ParameterBagInterface $parameterBag */
    private $parameterBag;

    /**
     * GoogleRecaptchaConfiguration constructor.
     * @param ParameterBagInterface $parameterBag
     */
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->getConfig()[Configuration::API_KEY];
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->getConfig()[Configuration::BASE_URL];
    }

    /**
     * @return array
     */
    protected function getConfig(): array
    {
        return $this->parameterBag->get(Configuration::ROOT) ?: [];
    }
}
