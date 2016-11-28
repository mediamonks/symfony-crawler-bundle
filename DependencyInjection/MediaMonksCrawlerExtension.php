<?php

namespace MediaMonks\CrawlerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MediaMonksCrawlerExtension extends Extension implements ExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->loadCrawler($container, $config);
        $this->loadClientPrerender($container, $config);
        $this->loadClientPrerenderIo($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param array $config
     */
    protected function loadCrawler(ContainerBuilder $container, array $config)
    {
        if (!$container->has($config['client'])) {
            $config['client'] = 'mediamonks_crawler.client.'.$config['client'];
        }

        $container->getDefinition('mediamonks_crawler.crawler')
            ->replaceArgument(0, new Reference($config['client']))
            ->addMethodCall('setLimit', [$config['limit']])
            ->addMethodCall('setStopOnError', [$config['stop_on_error']])
            ->addMethodCall('setExceptionOnError', [$config['exception_on_error']]);
    }

    /**
     * @param ContainerBuilder $container
     * @param array $config
     */
    protected function loadClientPrerender(ContainerBuilder $container, array $config)
    {
        $container->getDefinition('mediamonks_crawler.client.prerender')
            ->replaceArgument(0, $config['prerender']['url']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array $config
     */
    protected function loadClientPrerenderIo(ContainerBuilder $container, array $config)
    {
        $container->getDefinition('mediamonks_crawler.client.prerender_io')
            ->replaceArgument(0, $config['prerender_io']['token']);
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'mediamonks_crawler';
    }
}
