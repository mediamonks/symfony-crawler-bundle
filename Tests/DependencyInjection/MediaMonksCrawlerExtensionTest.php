<?php

namespace MediaMonks\RestApiBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use MediaMonks\CrawlerBundle\DependencyInjection\MediaMonksCrawlerExtension;

class MediaMonksCrawlerExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return [
            new MediaMonksCrawlerExtension()
        ];
    }

    public function testAfterLoadingTheCorrectParametersAreLoaded()
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('mediamonks_crawler.crawler.class');
        $this->assertContainerBuilderHasParameter('mediamonks_crawler.client.goutte.class');
        $this->assertContainerBuilderHasParameter('mediamonks_crawler.client.prerender.class');
        $this->assertContainerBuilderHasParameter('mediamonks_crawler.client.prerender_io.class');
    }

    public function testAfterLoadingTheCorrectServicesAreLoaded()
    {
        $this->load();
        $this->assertContainerBuilderHasService('mediamonks_crawler.crawler');
        $this->assertContainerBuilderHasService('mediamonks_crawler.client.goutte');
        $this->assertContainerBuilderHasService('mediamonks_crawler.client.prerender');
        $this->assertContainerBuilderHasService('mediamonks_crawler.client.prerender_io');
    }
}