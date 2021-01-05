<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject;

interface UserInterface
{
    /**
     * @return string|null
     */
    public function getSteamId(): ?string;

    /**
     * @param string $steamId
     */
    public function setSteamId(string $steamId);
}
