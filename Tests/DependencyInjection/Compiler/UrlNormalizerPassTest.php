<?php

namespace MediaMonks\RestApiBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use MediaMonks\CrawlerBundle\DependencyInjection\Compiler\UrlNormalizerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class UrlNormalizerPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new UrlNormalizerPass());
    }

    public function test_if_normalizer_tagged_services_are_compiled()
    {
        $collectingService = new Definition();
        $this->setDefinition('mediamonks_crawler.crawler', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('mediamonks_crawler.url_normalizer');
        $this->setDefinition('collected_service', $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'mediamonks_crawler.crawler',
            'addUrlNormalizer',
            [
                new Reference('collected_service'),
            ]
        );
    }
}
