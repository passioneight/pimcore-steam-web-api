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
     * @return string
     */
    public function getOpenIdLinkAccountRedirect(): string
    {
        return $this->getOpenIdConfig()[Configuration::LINK_ACCOUNT_REDIRECT];
    }

    /**
     * @return string
     */
    public function getOpenIdUnlinkAccountRedirect(): string
    {
        return $this->getOpenIdConfig()[Configuration::UNLINK_ACCOUNT_REDIRECT];
    }

    /**
     * @return string
     */
    public function getOpenIdConfig(): array
    {
        return $this->getConfig()[Configuration::OPEN_ID];
    }

    /**
     * @return array
     */
    public function getParentFolderForProfiles(): string
    {
        return $this->getParentFolderConfig()[Configuration::PARENT_FOLDER_PROFILES];
    }

    /**
     * @return array
     */
    public function getParentFolderForGames(): string
    {
        return $this->getParentFolderConfig()[Configuration::PARENT_FOLDER_GAMES];
    }

    /**
     * @return array
     */
    public function getParentFolderForAchievements(): string
    {
        return $this->getParentFolderConfig()[Configuration::PARENT_FOLDER_ACHIEVEMENTS];
    }

    /**
     * @return array
     */
    public function getParentFolderForNews(): string
    {
        return $this->getParentFolderConfig()[Configuration::PARENT_FOLDER_NEWS];
    }

    /**
     * @return array
     */
    public function getParentFolderForBadges(): string
    {
        return $this->getParentFolderConfig()[Configuration::PARENT_FOLDER_BADGES];
    }

    /**
     * @return array
     */
    public function getParentFolderConfig(): array
    {
        return $this->getConfig()[Configuration::PARENT_FOLDER];
    }

    /**
     * @return array
     */
    protected function getConfig(): array
    {
        return $this->parameterBag->get(Configuration::ROOT) ?: [];
    }
}
