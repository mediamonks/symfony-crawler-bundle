<?php

namespace MediaMonks\RestApiBundle\Tests;

use MediaMonks\CrawlerBundle\MediaMonksCrawlerBundle;

class MediaMonksCrawlerBundleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetContainerExtension()
    {
        $bundle = new MediaMonksCrawlerBundle();
        $this->assertInstanceOf(
            '\MediaMonks\CrawlerBundle\DependencyInjection\MediaMonksCrawlerExtension',
            $bundle->getContainerExtension()
        );
    }
}
