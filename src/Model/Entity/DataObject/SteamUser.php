<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject;

use Pimcore\Model\DataObject\Concrete;

class SteamUser extends Concrete implements SteamUserInterface
{
    private ?int $steamId;
    private ?int $steamUsername;
    private ?int $steamProfileState;
    private ?int $steamCommunityVisibilityState;
    private ?int $steamCommentPermission;
    private ?string $steamProfileUrl;
    private ?string $steamAvatar;
    private ?string $steamAvatarMedium;
    private ?string $steamAvatarFull;
    private ?string $steamAvatarHash;
    private ?string $steamPrimaryClanId;
    private ?int $steamLastLogOff;
    private ?int $steamPersonaState;
    private ?int $steamPersonaStateFlags;
    private ?int $steamAccountCreationTime;

    /**
     * @inheritdoc
     */
    public function getSteamId(): ?string
    {
        return $this->steamId;
    }

    /**
     * @inheritdoc
     */
    public function setSteamId(?string $steamId)
    {
        $this->steamId = $steamId;
    }

    /**
     * @inheritdoc
     */
    public function getSteamUsername(): ?string
    {
        return $this->steamUsername;
    }

    /**
     * @inheritdoc
     */
    public function setSteamUsername(?string $steamUserName)
    {
        $this->steamUsername = $steamUserName;
    }

    /**
     * @inheritdoc
     */
    public function getSteamProfileState(): ?int
    {
        return $this->steamProfileState;
    }

    /**
     * @inheritdoc
     */
    public function setSteamProfileState(?int $steamProfileState)
    {
        $this->steamProfileState = $steamProfileState;
    }

    /**
     * @inheritdoc
     */
    public function getSteamCommunityVisibilityState(): ?int
    {
        return $this->steamCommunityVisibilityState;
    }

    /**
     * @inheritdoc
     */
    public function setSteamCommunityVisibilityState(?int $steamCommunityVisibilityState)
    {
        $this->steamCommunityVisibilityState = $steamCommunityVisibilityState;
    }

    /**
     * @inheritdoc
     */
    public function getSteamCommentPermission(): ?int
    {
        return $this->steamCommentPermission;
    }

    /**
     * @inheritdoc
     */
    public function setSteamCommentPermission(?int $steamCommentPermission)
    {
        $this->steamCommentPermission = $steamCommentPermission;
    }

    /**
     * @inheritdoc
     */
    public function getSteamProfileUrl(): ?string
    {
        return $this->steamProfileUrl;
    }

    /**
     * @inheritdoc
     */
    public function setSteamProfileUrl(?string $steamProfileUrl)
    {
        $this->steamProfileUrl = $steamProfileUrl;
    }

    /**
     * @inheritdoc
     */
    public function getSteamAvatar(): ?string
    {
        return $this->steamAvatar;
    }

    /**
     * @inheritdoc
     */
    public function setSteamAvatar(?string $steamAvatar)
    {
        $this->steamAvatar = $steamAvatar;
    }

    /**
     * @inheritdoc
     */
    public function getSteamAvatarMedium(): ?string
    {
        return $this->steamAvatarMedium;
    }

    /**
     * @inheritdoc
     */
    public function setSteamAvatarMedium(?string $steamAvatarMedium)
    {
        $this->steamAvatarMedium = $steamAvatarMedium;
    }

    /**
     * @inheritdoc
     */
    public function getSteamAvatarFull(): ?string
    {
        return $this->steamAvatarFull;
    }

    /**
     * @inheritdoc
     */
    public function setSteamAvatarFull(?string $steamAvatarFull)
    {
        return $this->steamAvatarFull = $steamAvatarFull;
    }

    /**
     * @inheritdoc
     */
    public function getSteamAvatarHash(): ?string
    {
        return $this->steamAvatarHash;
    }

    /**
     * @inheritdoc
     */
    public function setSteamAvatarHash(?string $steamAvatarHash)
    {
        $this->steamAvatarHash = $steamAvatarHash;
    }

    /**
     * @inheritdoc
     */
    public function getSteamPrimaryClanId(): ?string
    {
        return $this->steamPrimaryClanId;
    }

    /**
     * @inheritdoc
     */
    public function setSteamPrimaryClanId(?string $steamPrimaryClanId)
    {
        $this->steamPrimaryClanId = $steamPrimaryClanId;
    }

    /**
     * @inheritdoc
     */
    public function getSteamLastLogOff(): ?int
    {
        return $this->steamLastLogOff;
    }

    /**
     * @inheritdoc
     */
    public function setSteamLastLogOff(?int $steamLastLogOff)
    {
        $this->steamLastLogOff = $steamLastLogOff;
    }

    /**
     * @inheritdoc
     */
    public function getSteamPersonaState(): ?int
    {
        return $this->steamPersonaState;
    }

    /**
     * @inheritdoc
     */
    public function setSteamPersonaState(?int $steamPersonState)
    {
        $this->steamPersonaState = $steamPersonState;
    }

    /**
     * @inheritdoc
     */
    public function getSteamPersonaStateFlags(): ?int
    {
        return $this->steamPersonaStateFlags;
    }

    /**
     * @inheritdoc
     */
    public function setSteamPersonaStateFlags(?int $steamPersonStateFlags)
    {
        $this->steamPersonaStateFlags = $steamPersonStateFlags;
    }

    /**
     * @inheritdoc
     */
    public function getSteamAccountCreationTime(): ?int
    {
        return $this->steamAccountCreationTime;
    }

    /**
     * @inheritdoc
     */
    public function setSteamAccountCreationTime(?int $steamAccountCreationTime)
    {
        $this->steamAccountCreationTime = $steamAccountCreationTime;
    }
}