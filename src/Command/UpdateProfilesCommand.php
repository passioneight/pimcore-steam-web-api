<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Command;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject\SteamUserInterface;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\Steam\SteamProfileInfo;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamWebApiService;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Model\SteamProfileService;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\SteamResponseService;
use Pimcore\Model\DataObject\SteamProfile;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;

class UpdateProfilesCommand extends AbstractSteamCommand
{
    const MAX_STEAM_IDS_PER_REQUEST = 100;

    private SteamProfileService $steamProfileService;

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('passioneight:steam-web-api:update-profiles');
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $steamProfiles = new SteamProfile\Listing();
        $steamProfiles->setLimit(self::MAX_STEAM_IDS_PER_REQUEST);

        for($page = 0; $page < $steamProfiles->getTotalCount(); $page++) {
            $steamProfiles->setOffset($page);

            $steamIds = $this->mapToSteamIds($steamProfiles);
            $response = $this->steamWebApiService
                ->useVersion(SteamWebApiService::VERSION_2)
                ->getPlayerSummaries(...$steamIds);

            if($response->getStatusCode() === Response::HTTP_OK) {
                $this->steamProfileService->update($response, true);
            }

            \Pimcore::collectGarbage();
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
     * @param SteamProfileService $steamProfileService
     */
    public function setSteamProfileService(SteamProfileService $steamProfileService)
    {
        $this->steamProfileService = $steamProfileService;
    }
}
