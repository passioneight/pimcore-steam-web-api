<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject;

interface SteamUserInterface
{
    /**
     * @return string|null
     */
    public function getSteamId(): ?string;

    /**
     * @param string|null $steamId
     */
    public function setSteamId(?string $steamId);

    /**
     * @return string|null
     */
    public function getSteamUsername(): ?string;

    /**
     * @param string|null $steamUserName
     */
    public function setSteamUsername(?string $steamUserName);

    /**
     * @return int|null
     */
    public function getSteamProfileState(): ?int;

    /**
     * @param int|null $steamProfileState
     */
    public function setSteamProfileState(?int $steamProfileState);

    /**
     * @return int|null
     */
    public function getSteamCommunityVisibilityState(): ?int;

    /**
     * @param int|null $steamCommunityVisibilityState
     */
    public function setSteamCommunityVisibilityState(?int $steamCommunityVisibilityState);

    /**
     * @return int|null
     */
    public function getSteamCommentPermission(): ?int;

    /**
     * @param int|null $steamCommentPermission
     */
    public function setSteamCommentPermission(?int $steamCommentPermission);

    /**
     * @return string|null
     */
    public function getSteamProfileUrl(): ?string;

    /**
     * @param string|null $steamProfileUrl
     */
    public function setSteamProfileUrl(?string $steamProfileUrl);

    /**
     * @return string|null
     */
    public function getSteamAvatar(): ?string;

    /**
     * @param string|null $steamAvatar
     */
    public function setSteamAvatar(?string $steamAvatar);

    /**
     * @return string|null
     */
    public function getSteamAvatarMedium(): ?string;

    /**
     * @param string|null $steamAvatarMedium
     */
    public function setSteamAvatarMedium(?string $steamAvatarMedium);

    /**
     * @return string|null
     */
    public function getSteamAvatarFull(): ?string;

    /**
     * @param string|null $steamAvatarFull
     */
    public function setSteamAvatarFull(?string $steamAvatarFull);

    /**
     * @return string|null
     */
    public function getSteamAvatarHash(): ?string;

    /**
     * @param string|null $steamAvatarHash
     */
    public function setSteamAvatarHash(?string $steamAvatarHash);

    /**
     * @return string|null
     */
    public function getSteamPrimaryClanId(): ?string;

    /**
     * @param string|null $steamPrimaryClanId
     */
    public function setSteamPrimaryClanId(?string $steamPrimaryClanId);

    /**
     * @return int|null
     */
    public function getSteamLastLogOff(): ?int;

    /**
     * @param int|null $steamLastLogOff
     */
    public function setSteamLastLogOff(?int $steamLastLogOff);

    /**
     * @return int|null
     */
    public function getSteamPersonaState(): ?int;

    /**
     * @param int|null $steamPersonState
     */
    public function setSteamPersonaState(?int $steamPersonState);

    /**
     * @return int|null
     */
    public function getSteamPersonaStateFlags(): ?int;

    /**
     * @param int|null $steamPersonStateFlags
     */
    public function setSteamPersonaStateFlags(?int $steamPersonStateFlags);

    /**
     * @return int|null
     */
    public function getSteamAccountCreationTime(): ?int;

    /**
     * @param int|null $steamAccountCreationTime
     */
    public function setSteamAccountCreationTime(?int $steamAccountCreationTime);
}
