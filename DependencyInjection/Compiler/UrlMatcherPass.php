<?php

namespace MediaMonks\CrawlerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class UrlMatcherPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('mediamonks_crawler.crawler');

        $this->processBlacklist($container, $definition);
        $this->processWhitelist($container, $definition);
    }

    /**
     * @param ContainerBuilder $container
     * @param Definition $definition
     */
    protected function processBlacklist(ContainerBuilder $container, Definition $definition)
    {
        $taggedServices = $container->findTaggedServiceIds('mediamonks_crawler.blacklist_url_matcher');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addBlacklistUrlMatcher', [new Reference($id)]);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param Definition $definition
     */
    protected function processWhitelist(ContainerBuilder $container, Definition $definition)
    {
        $taggedServices = $container->findTaggedServiceIds('mediamonks_crawler.whitelist_url_matcher');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addWhitelistUrlMatcher', [new Reference($id)]);
        }
    }
}
