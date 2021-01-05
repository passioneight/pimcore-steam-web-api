<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Command;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\NamespaceUtility;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject\SteamUserInterface;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamWebApiService;
use Pimcore\Console\AbstractCommand as PimcoreCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Pimcore\Model\Listing\AbstractListing;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserProfileCommand extends PimcoreCommand
{
    const OPTION_UPDATE_PROFILE_PICTURE = "update-profile-picture";
    const OPTION_USER_IDS = "user-ids";
    const ARGUMENT_USER_CLASS = "user-class";

    private bool $updateProfilePicture;
    private array $userIds;
    private string $userClass;
    private SteamWebApiService $steamWebApiService;

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
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
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

        /** @var SteamUserInterface $user */
        foreach ($users as $user) {
            $this->dumpVerbose("[Steam Web API] Updating user {$user->getId()}");

            $steamId = $user->getSteamId();
            if (!empty($steamId)) {
                $response = $this->steamWebApiService->getProfileInfo($user->getSteamId());

                if($response->getStatusCode() === Response::HTTP_OK){
                    $profileInfo = $response->toArray();

                    $user->setSteamCommunityVisibilityState($profileInfo['response']['players']['player'][0]['communityvisibilitystate']);
                    $user->setSteamProfileState($profileInfo['response']['players']['player'][0]['profilestate']);
                    $user->setSteamUsername($profileInfo['response']['players']['player'][0]['personaname']);
                    $user->setSteamCommentPermission($profileInfo['response']['players'][0]['player']['commentpermission']);
                    $user->setSteamProfileUrl($profileInfo['response']['players']['player'][0]['profileurl']);
                    $user->setSteamAvatar($profileInfo['response']['players']['player'][0]['avatar']);
                    $user->setSteamAvatarMedium($profileInfo['response']['players']['player'][0]['avatarmedium']);
                    $user->setSteamAvatarFull($profileInfo['response']['players']['player'][0]['avatarfull']);
                    $user->setSteamAvatarHash($profileInfo['response']['players']['player'][0]['avatarhash']);
                    $user->setSteamLastLogOff($profileInfo['response']['players']['player'][0]['lastlogoff']);
                    $user->setSteamPersonaState($profileInfo['response']['players']['player'][0]['personastate']);
                    $user->setSteamPersonaStateFlags($profileInfo['response']['players']['player'][0]['personastateflags']);
                    $user->setSteamPrimaryClanId($profileInfo['response']['players']['player'][0]['primaryclanid']);
                    $user->setSteamAccountCreationTime($profileInfo['response']['players']['player'][0]['timecreated']);

                    $user->save(['versionNote' => 'Populated user with Steam-profile data']);
                } else {
                    // TODO: log error
                }
            }
        }
    }

    /**
     * @return AbstractListing
     */
    protected function loadUsers(): AbstractListing
    {
        /** @var AbstractListing $listingClass */
        $listingClass = $this->getListingClass();

        $users = new $listingClass();
        $users->addConditionParam("steamId <> ''");

        if (!empty($this->userIds)) {
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

    /**
     * @required
     * @internal
     * @param SteamWebApiService $steamWebApiService
     */
    public function setSteamWebApiService(SteamWebApiService $steamWebApiService)
    {
        $this->steamWebApiService = $steamWebApiService;
    }
}
