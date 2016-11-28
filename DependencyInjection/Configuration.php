<?php

namespace MediaMonks\CrawlerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mediamonks_crawler');

        $this->addClient($rootNode);
        $this->addConfig($rootNode);
        $this->addPrerender($rootNode);
        $this->addPrerenderIo($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addClient(ArrayNodeDefinition $node)
    {
        $node->children()
            ->scalarNode('client')
            ->defaultValue('goutte')
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addConfig(ArrayNodeDefinition $node)
    {
        $node->children()
            ->scalarNode('limit')
            ->defaultValue(0)
            ->end()
            ->booleanNode('stop_on_error')
            ->defaultFalse()
            ->end()
            ->booleanNode('exception_on_error')
            ->defaultFalse()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addPrerender(ArrayNodeDefinition $node)
    {
        $node->children()
            ->arrayNode('prerender')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('url')
            ->defaultNull()
            ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addPrerenderIo(ArrayNodeDefinition $node)
    {
        $node->children()
            ->arrayNode('prerender_io')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('token')
            ->defaultNull()
            ->end()
            ->end();
    }
}
