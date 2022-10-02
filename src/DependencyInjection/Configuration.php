<?php

namespace Passioneight\PimcoreSteamWebApi\DependencyInjection;

use Passioneight\PimcoreSteamWebApi\Constant\Configuration as Config;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(Config::ROOT);
        $rootNode = $treeBuilder->getRootNode();

        $this->addGeneralConfiguration($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function addGeneralConfiguration(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->scalarNode(Config::API_KEY)
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode(Config::BASE_URL)
                    ->defaultValue("https://api.steampowered.com")
                    ->cannotBeEmpty()
                ->end()
            ->end();
    }
}
