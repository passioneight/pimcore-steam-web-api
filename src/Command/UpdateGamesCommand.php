<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Command;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Model\SteamGameService;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\SteamResponseService;
use Pimcore\Model\DataObject\SteamOwnedGame;
use Pimcore\Model\User;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;

class UpdateGamesCommand extends AbstractSteamCommand
{
    const USERS_PER_PAGE = 100;

    private SteamGameService $steamGameService;

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('passioneight:steam-web-api:update-games');
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = new User\Listing();
        $users->addConditionParam("steamProfile <> ''");
//        $users->addConditionParam("steamOwnedGames <> ''");

        $users->setLimit(self::USERS_PER_PAGE);

        if($users->getTotalCount() > 0) {
//            $appListResponse = $this->steamWebApiService
//                ->useVersion(SteamWebApiService::VERSION_2)
//                ->getAppList();

            for($page = 0; $page < $users->getTotalCount(); $page++) {
                $steamProfiles->setOffset($page);

                $steamId = $user->getSteamProfile()->getSteamId();
                $response = $this->steamWebApiService->getOwnedGames($steamId);

                if($response->getStatusCode() === Response::HTTP_OK) {
                    $this->steamOwnedGamesService->update($response, $appListResponse, true);
                }

                \Pimcore::collectGarbage();
            }
        }
    }

    /**
     * @param SteamProfile\Listing $steamProfiles
     * @return array
     */
    protected function mapToSteamIds(SteamProfile\Listing $steamProfiles): array
    {
        $steamIds = [];
        foreach ($steamProfiles as $steamProfile){
            $steamIds[] = $steamProfile->getSteamId();
        }

        return $steamIds;
    }

    /**
     * @required
     * @internal
     * @param SteamGameService $steamGameService
     */
    public function setSteamGameService(SteamGameService $steamGameService)
    {
        $this->steamOwnedGameService = $steamGameService;
    }
}
