<?php

namespace MediaMonks\CrawlerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class UrlMatcherPass extends AbstractPass
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $this->addMethodCallToCrawler($container, 'mediamonks_crawler.blacklist_url_matcher', 'addBlacklistUrlMatcher');
        $this->addMethodCallToCrawler($container, 'mediamonks_crawler.whitelist_url_matcher', 'addWhitelistUrlMatcher');
    }
}
