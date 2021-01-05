<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Controller;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject\SteamUserInterface;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Authentication\SteamOpenId;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Api\SteamWebApiService;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Security\FirewallService;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/steam")
 */
class AuthenticationController extends FrontendController
{
    use TargetPathTrait;
    
    /**
     * @Route("/open-id")
     *
     * @param Request $request
     * @param FirewallService $firewallService
     * @param SteamOpenId $steamOpenId
     * @param EventDispatcherInterface $eventDispatcher
     * @return RedirectResponse
     */
    public function openIdAction(Request $request, FirewallService $firewallService, SteamOpenId $steamOpenId, EventDispatcherInterface $eventDispatcher)
    {
        /** @var SteamUserInterface $user */
        $user = $this->getUser();

        $targetPath = $this->getTargetPath($request->getSession(), $firewallService->getFirewallNameForRequest($request));
        $targetPath = $targetPath ?: "/";   // TODO: add bundle config to allow setting the redirect value here

        if(!empty($user->getSteamId())) {
            // TODO: dispatch event --> allows to e.g. show already connected message
            print_r("already set");
            return new RedirectResponse($targetPath);
        }


        $steamId = $steamOpenId->getSteamId($request);

        if(!empty($steamId)) {
            $user->setSteamId($steamId);
            $user->save(['versionNote' => 'Connected to Steam']);

            // TODO: start command to populate user with steam-data

            // TODO: dispatch event --> allows to e.g. show success message to user
        } else {
            // TODO: dispatch event --> allows to e.g. show error message to user
        }

        return new RedirectResponse($targetPath);
    }

    /**
     * @Route("/revoke-open-id")
     *
     * @param Request $request
     * @param FirewallService $firewallService
     * @return RedirectResponse
     */
    public function revokeOpenIdAction(Request $request, FirewallService $firewallService)
    {
        /** @var SteamUserInterface $user */
        $user = $this->getUser();

        $targetPath = $this->getTargetPath($request->getSession(), $firewallService->getFirewallNameForRequest($request));
        $targetPath = $targetPath ?: "/";   // TODO: add bundle config to allow setting the redirect value here

        if(empty($user->getSteamId())) {
            // TODO: dispatch event --> allows to e.g. show was not connected message
            print_r("already disconnected");
            return new RedirectResponse($targetPath);
        }

        $user->setSteamId(null);
        $user->save(['versionNote' => 'Disconnected from Steam']);

        // TODO: dispatch event --> allows to e.g. show successfully disconnected message

        return new RedirectResponse($targetPath);
    }
}
