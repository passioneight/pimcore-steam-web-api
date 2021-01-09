<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Model;

use Pimcore\Model\DataObject\Concrete;
use Pimcore\Model\DataObject\Folder;
use Pimcore\Model\DataObject\SteamOwnedGame;
use Pimcore\Model\DataObject\SteamProfile;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SteamGameService extends AbstractSteamService
{
    /**
     * @param ResponseInterface $response
     * @param ResponseInterface $appListResponse
     * @param bool $save
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function update(ResponseInterface $response, ResponseInterface $appListResponse, bool $save = false)
    {
        $content = $this->getContent($response);
        $gameCount = $this->getGameCount($content);
        $games = $this->getGames($content);

        if(empty($games)) {
            return;
        }

        $appList = $this->getAppList($appListResponse->toArray());
        $apps = $this->getApps($appList);
        
        if(empty($apps)) {
            return;
        }
        
        foreach ($games as $game) {
            $appId = $this->getAppId($game);

            $steamOwnedGames = SteamOwnedGame::getByAppiId($appId);
            if($steamOwnedGames->getTotalCount() !== 1) {
                continue;
            }

            $steamOwnedGame = $this->populate($steamOwnedGames->current(), [
                "playtimeForever" => $this->getPlaytimeForever($player),
                "playtimeWindowsForever" => $this->getPlaytimeForever($player, "windows"),
                "playtimeMacForever" => $this->getPlaytimeForever($player, "mac"),
                "playtimeLinuxForever" => $this->getPlaytimeForever($player, "linux"),
            ]);

            if($save) {
                $steamOwnedGame->save(['versionNote' => 'Updated Steam Owned Game']);
            }
        }
    }

    /**
     * @inheritdoc
     *
     * We don't want to clear the "appId" - so we can always load the game's information (e.g., name).
     */
    protected function clear(Concrete $object, array $values): Concrete
    {
        if(array_key_exists("appId", $values)) {
            unset($values["appId"]);
        }

        return parent::clear($object, $values);
    }

    /**
     * @param array $content
     * @return array
     */
    protected function getGameCount(array $content): array
    {
        return $this->get($content,'game_count');
    }

    /**
     * @param array $content
     * @return array
     */
    protected function getGames(array $content): array
    {
        return $this->get($content,'games');
    }

    /**
     * @param array $player
     * @return string|null
     */
    protected function getAppId(array $player): ?string
    {
        return $this->get($player,'appid', null);
    }

    /**
     * @param array $content
     * @return string|null
     */
    protected function getAppList(array $content): array
    {
        return $this->get($content,'applist');
    }

    /**
     * @param array $content
     * @return string|null
     */
    protected function getApps(array $appList): array
    {
        return $this->get($appList,'apps');
    }

    /**
     * @param array $game
     * @return string|null
     */
    protected function getPlaytimeForever(array $game, ?string $os = null): ?string
    {
        return $this->get($player, join("_", ["playtime", $os, "forever"]));
    }

    /**
     * @inheritdoc
     */
    protected function getRelatedObjectClass(): string
    {
        return SteamOwnedGame::class;
    }

    /**
     * @inheritdoc
     */
    protected function getRelatedParentFolder(): Folder
    {
        return $this->getOrCreateParent($this->bundleConfiguration->getParentFolderForGames());
    }
}