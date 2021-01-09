<?php

namespace Passioneight\Bundle\PimcoreSteamWebApiBundle\DependencyInjection;

use Passioneight\Bundle\PimcoreSteamWebApiBundle\Constant\Configuration as Config;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(Config::ROOT);
        $rootNode = $treeBuilder->getRootNode();

        $this->addGeneralConfiguration($rootNode);
        $this->addOpenIdConfiguration($rootNode);
        $this->addDataObjectParentConfiguration($rootNode);

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

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function addOpenIdConfiguration(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode(Config::OPEN_ID)
                    ->children()
                        ->scalarNode(Config::LINK_ACCOUNT_REDIRECT)
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode(Config::UNLINK_ACCOUNT_REDIRECT)
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function addDataObjectParentConfiguration(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode(Config::PARENT_FOLDER)
                    ->children()
                        ->scalarNode(Config::PARENT_FOLDER_PROFILES)
                            ->defaultValue("/Steam/Profiles")
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode(Config::PARENT_FOLDER_GAMES)
                            ->defaultValue("/Steam/Games")
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode(Config::PARENT_FOLDER_ACHIEVEMENTS)
                            ->defaultValue("/Steam/Achievements")
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode(Config::PARENT_FOLDER_NEWS)
                            ->defaultValue("/Steam/News")
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode(Config::PARENT_FOLDER_BADGES)
                            ->defaultValue("/Steam/Badges")
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
