<?php

namespace MediaMonks\CrawlerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class UrlNormalizerPass extends AbstractPass
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->addMethodCallToCrawler($container, 'mediamonks_crawler.url_normalizer', 'addUrlNormalizer');
    }
}
