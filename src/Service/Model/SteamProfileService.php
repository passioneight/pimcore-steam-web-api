<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Model;

use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\Folder;
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

        $fieldDefinitionNames = $this->getFieldDefinitionNames();

        foreach ($players as $player) {
            $steamId = $this->getSteamId($player);
            $steamProfiles = SteamProfile::getBySteamId($steamId);

            if($steamProfiles->getTotalCount() !== 1) {
                continue;
            }

            $steamProfile = $steamProfiles->current();

            $this->clear($steamProfile, $fieldDefinitionNames);
            $this->populate($steamProfile, $player);

            if($save) {
                $steamProfile->save(['versionNote' => 'Updated Steam profile']);
            }
        }
    }

    /**
     * @inheritdoc
     *
     * We don't want to clear the "steamId" - just in case the API stops returning the value. Thus, we avoid losing
     * the link to the user's Steam profile.
     */
    protected function clear(Concrete $object, array $values): Concrete
    {
        if(array_key_exists("steamId", $values)) {
            unset($values["steamId"]);
        }

        return parent::clear($object, $values);
    }

    /**
     * @param Concrete $user
     * @param bool $published
     * @param array $steamProfileValues
     * @return SteamProfile
     */
    public function createForUser(Concrete $user, array $steamProfileValues, bool $published = true): SteamProfile
    {
        $class = $this->getRelatedObjectClass();
        $steamProfile = $this->populate(new $class(), $steamProfileValues);
        $steamProfile->setParent($this->getRelatedParentFolder());
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
     * @inheritdoc
     */
    protected function getRelatedObjectClass(): string
    {
        return SteamProfile::class;
    }

    /**
     * @inheritdoc
     */
    protected function getRelatedParentFolder(): Folder
    {
        return $this->getOrCreateParent($this->bundleConfiguration->getParentFolderForProfiles());
    }
}
