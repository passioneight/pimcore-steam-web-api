<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Controller;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Event\OpenId\OpenIdEvent;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Model\Entity\DataObject\SteamUserInterface;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Security\FirewallService;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Authentication\SteamOpenId;
use Passioneight\Bundle\PimcoreSteamWebApiBundle\Service\Model\SteamProfileService;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\SteamProfile;
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
    public function openIdAction(Request $request, FirewallService $firewallService, SteamOpenId $steamOpenId, EventDispatcherInterface $eventDispatcher, SteamProfileService $steamProfileService)
    {
        $user = $this->getUser();

        $targetPath = $this->getTargetPath($request->getSession(), $firewallService->getFirewallNameForRequest($request));
        $targetPath = $targetPath ?: "/";   // TODO: add bundle config to allow setting the redirect value here

        if($user->getSteamProfile()) {
            $eventDispatcher->dispatch(new OpenIdEvent($user, OpenIdEvent::MESSAGE_ALREADY_CONNECTED));
            return new RedirectResponse($targetPath);
        }

        $steamId = $steamOpenId->getSteamId($request);

        if(!empty($steamId)) {
            $steamProfile = $steamProfileService->createForUser($user, ['steamId' => $steamId]);
            $steamProfile->save(['versionNote' => 'Steam account was linked']);

            $user->setSteamProfile($steamProfile);
            $user->save(['versionNote' => 'Steam account was linked']);

            $eventDispatcher->dispatch(new OpenIdEvent($user, OpenIdEvent::MESSAGE_CONNECTED));
        }

        return new RedirectResponse($targetPath);
    }

    /**
     * @Route("/revoke-open-id")
     *
     * @param Request $request
     * @param FirewallService $firewallService
     * @param EventDispatcherInterface $eventDispatcher
     * @return RedirectResponse
     */
    public function revokeOpenIdAction(Request $request, FirewallService $firewallService, EventDispatcherInterface $eventDispatcher)
    {
        $user = $this->getUser();

        $targetPath = $this->getTargetPath($request->getSession(), $firewallService->getFirewallNameForRequest($request));
        $targetPath = $targetPath ?: "/";   // TODO: add bundle config to allow setting the redirect value here

        if(empty($user->getSteamProfile())) {
            $eventDispatcher->dispatch(new OpenIdEvent($user, OpenIdEvent::MESSAGE_ALREADY_DISCONNECTED));
            return new RedirectResponse($targetPath);
        }

        $user->getSteamProfile()->delete(['versionNote' => 'Steam account was unlinked']);

        $eventDispatcher->dispatch(new OpenIdEvent($user, OpenIdEvent::MESSAGE_DISCONNECTED));

        return new RedirectResponse($targetPath);
    }
}
