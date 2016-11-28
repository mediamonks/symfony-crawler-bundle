<?php

namespace MediaMonks\CrawlerBundle;

use MediaMonks\CrawlerBundle\DependencyInjection\Compiler\UrlMatcherPass;
use MediaMonks\CrawlerBundle\DependencyInjection\Compiler\UrlNormalizerPass;
use MediaMonks\CrawlerBundle\DependencyInjection\MediaMonksCrawlerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Robert Slootjes <robert@mediamonks.com>
 */
class MediaMonksCrawlerBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new UrlMatcherPass());
        $container->addCompilerPass(new UrlNormalizerPass());
    }

    /**
     * @inheritdoc
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new MediaMonksCrawlerExtension();
        }

        return $this->extension;
    }
}
