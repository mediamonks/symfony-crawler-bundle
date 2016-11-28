<?php

namespace MediaMonks\CrawlerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

abstract class AbstractPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @param string $tag
     * @param string $methodName
     */
    protected function addMethodCallToCrawler(ContainerBuilder $container, $tag, $methodName)
    {
        $definition = $container->findDefinition('mediamonks_crawler.crawler');

        $taggedServices = $container->findTaggedServiceIds($tag);
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall($methodName, [new Reference($id)]);
        }
    }
}
