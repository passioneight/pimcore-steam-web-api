<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Model;

use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\SteamProfile;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamProfileService extends AbstractSteamService
{
    /**
     * @param ResponseInterface $response
     * @param bool $save
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function update(ResponseInterface $response, bool $save = false)
    {
        $content = $this->getContent($response);
        $players = $this->getPlayers($content);

        foreach ($players as $player) {
            $steamId = $this->getSteamId($player);
            $steamProfiles = SteamProfile::getBySteamId($steamId);
            
            if($steamProfiles->getTotalCount() !== 1) {
                continue;
            }
            
            $steamProfile = $this->populate($steamProfiles->current(), $player);

            if($save) {
                $steamProfile->save(['versionNote' => 'Updated Steam profile']);
            }
        }
    }

    /**
     * @param Concrete $user
     * @param bool $published
     * @param array $steamProfileValues
     * @return SteamProfile
     */
    public function createForUser(Concrete $user, array $steamProfileValues, bool $published = true): SteamProfile
    {
        $steamProfile = $this->populate(new SteamProfile(), $steamProfileValues);
        $steamProfile->setParent($user);
        $steamProfile->setKey($steamProfile->getSteamId());
        $steamProfile->setPublished($published);
        
        return $steamProfile;
    }

    /**
     * @param array $content
     * @return array
     */
    protected function getPlayers(array $content): array
    {
        return $this->get($content,'players');
    }

    /**
     * @param array $player
     * @return string|null
     */
    protected function getSteamId(array $player): ?string
    {
        return $this->get($player,'steamid');
    }
}