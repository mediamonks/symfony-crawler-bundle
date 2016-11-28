<?php

namespace MediaMonks\CrawlerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class UrlNormalizerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->findDefinition('mediamonks_crawler.crawler');

        $taggedServices = $container->findTaggedServiceIds('mediamonks_crawler.url_normalizer');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addUrlNormalizer', [new Reference($id)]);
        }
    }
}
