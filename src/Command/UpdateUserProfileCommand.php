<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Command;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\Steam\SteamProfileInfo;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamWebApiService;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Model\SteamProfileService;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\SteamResponseService;
use Pimcore\Console\AbstractCommand as PimcoreCommand;
use Pimcore\Model\DataObject\SteamProfile;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserProfileCommand extends PimcoreCommand
{
    const MAX_STEAM_IDS_PER_REQUEST = 100;

    private SteamWebApiService $steamWebApiService;
    private SteamProfileService $steamProfileService;

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('passioneight:steam-web-api:update-user-profile');
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
                ->getProfileInfo(...$steamIds);

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
     * @param SteamWebApiService $steamWebApiService
     */
    public function setSteamWebApiService(SteamWebApiService $steamWebApiService)
    {
        $this->steamWebApiService = $steamWebApiService;
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
