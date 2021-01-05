<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\Security;

use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\FirewallMapInterface;

class FirewallService
{
    /** @var FirewallMapInterface|FirewallMap $firewallMap */
    private FirewallMapInterface $firewallMap;

    /**
     * FirewallService constructor.
     * @param FirewallMapInterface $firewallMap
     */
    public function __construct(FirewallMapInterface $firewallMap)
    {
        $this->firewallMap = $firewallMap;
    }

    /**
     * @param Request $request
     * @return bool|string the name of the firewall, if any.
     */
    public function getFirewallNameForRequest(Request $request)
    {
        $config = $this->firewallMap->getFirewallConfig($request);
        return $config ? $config->getName() : "";
    }
}