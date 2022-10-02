<?php

namespace Passioneight\PimcoreSteamWebApi\DependencyInjection;

use Passioneight\Bundle\PhpUtilitiesBundle\Service\Utility\MethodUtility;
use Passioneight\PimcoreSteamWebApi\Service\Configuration\SteamWebApiConfiguration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class PimcoreSteamWebApiExtension extends ConfigurableExtension
{
    /**
     * @inheritDoc
     * @throws \Exception
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('config.yaml');

        $this->populateContainer($mergedConfig, $container);
    }

    /**
     * Populates the container in order to access the configuration later on, if needed.
     * @param array $config
     * @param ContainerBuilder $container
     */
    public function populateContainer(array $config, ContainerBuilder $container)
    {
        $serviceDefinition = $container->getDefinition(SteamWebApiConfiguration::class);
        $serviceDefinition->addMethodCall(MethodUtility::createSetter("configuration"), [$config]);
    }
}
