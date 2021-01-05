<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Command;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\NamespaceUtility;
use Pimcore\Console\AbstractCommand as PimcoreCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pimcore\Model\Listing\AbstractListing;

class UpdateUserProfileCommand extends PimcoreCommand
{
    const OPTION_UPDATE_PROFILE_PICTURE = "update-profile-picture";
    const OPTION_USER_IDS = "user-ids";
    const ARGUMENT_USER_CLASS = "user-class";

    private bool $updateProfilePicture;
    private array $userIds;
    private string $userClass;

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->setName('passioneight:steam-web-api:update-user-profile')
            ->addArgument(
                self::ARGUMENT_USER_CLASS,
                InputOption::VALUE_REQUIRED,
                "The class that is used for the user objects"
            )
            ->addOption(
                self::OPTION_UPDATE_PROFILE_PICTURE,
                null,
                InputOption::VALUE_NONE,
                "If this option is used, the profile picture of the user is updated too"
            )
            ->addOption(
                self::OPTION_USER_IDS,
                null,
                InputOption::VALUE_REQUIRED|InputOption::VALUE_IS_ARRAY,
                "Only users with the given IDs will be updated"
            );
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->userClass = (string)$input->getArgument(self::ARGUMENT_USER_CLASS);

        $this->updateProfilePicture = (bool)$input->getOption(self::OPTION_UPDATE_PROFILE_PICTURE);
        $this->userIds = (array)$input->getOption(self::OPTION_USER_IDS);

        $users = $this->loadUsers();

        foreach ($users as $user) {
            $this->dumpVerbose("[Steam Web API] Updating user {$user->getId()}");


            $steamId = $user->getSteamId();
            if(!empty($steamId)) {
    //            $client = new Client($steamApiKey);
    //            $steamUser = new ISteamUser($client);
    //
    //            $response = $steamUser->GetPlayerSummariesV2($steamId);
    //
    //            p_r($response);

                // TODO: actually implement API
                // TODO: actually fetch data from API

//            $user->save(['versionNote' => 'Populated user with Steam-profile data']);
            }
        }
    }

    /**
     * @return AbstractListing
     */
    protected function loadUsers(): AbstractListing
    {
        /** @var AbstractListing $users */
        $users = new ($this->getListingClass());
        $users->addConditionParam("steamId <> ''");

        if(!empty($this->userIds)) {
            $users->addConditionParam("o_id IN (" . implode($this->userIds) . ")");
        }

        return $users;
    }

    /**
     * @return string
     */
    protected function getListingClass(): string
    {
        return NamespaceUtility::join($this->userClass, "Listing");
    }
}
