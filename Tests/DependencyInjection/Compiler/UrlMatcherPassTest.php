<?php

namespace MediaMonks\RestApiBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use MediaMonks\CrawlerBundle\DependencyInjection\Compiler\UrlMatcherPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class UrlMatcherPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new UrlMatcherPass());
    }

    public function test_if_blacklist_tagged_services_are_compiled()
    {
        $collectingService = new Definition();
        $this->setDefinition('mediamonks_crawler.crawler', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('mediamonks_crawler.blacklist_url_matcher');
        $this->setDefinition('collected_service', $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'mediamonks_crawler.crawler',
            'addBlacklistUrlMatcher',
            [
                new Reference('collected_service'),
            ]
        );
    }

    public function test_if_whitelist_tagged_services_are_compiled()
    {
        $collectingService = new Definition();
        $this->setDefinition('mediamonks_crawler.crawler', $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('mediamonks_crawler.whitelist_url_matcher');
        $this->setDefinition('collected_service', $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            'mediamonks_crawler.crawler',
            'addWhitelistUrlMatcher',
            [
                new Reference('collected_service'),
            ]
        );
    }
}
