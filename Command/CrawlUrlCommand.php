<?php

namespace MediaMonks\CrawlerBundle\Command;

use MediaMonks\Crawler\Page;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlUrlCommand extends ContainerAwareCommand
{
    const ARGUMENT_URL = 'url';
    const OPTION_LIMIT = 'limit';

    protected function configure()
    {
        $this
            ->setName('mediamonks:crawler:crawl-url')
            ->setDescription('Crawl an url')
            ->addArgument(
                self::ARGUMENT_URL,
                InputArgument::REQUIRED,
                'Url of the site you want to crawl'
            )
            ->addOption(
                self::OPTION_LIMIT,
                null,
                InputOption::VALUE_OPTIONAL,
                'Limit number of pages to crawl'
            )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $crawler = $this->getContainer()->get('mediamonks_crawler.crawler');
        $crawler->setLimit((int)$input->getOption(self::OPTION_LIMIT));
        foreach ($crawler->crawl($input->getArgument('url')) as $page) {
            $this->handlePage($page);
        }
    }

    /**
     * @param Page $page
     */
    protected function handlePage(Page $page)
    {
        echo $page->getUrl() . PHP_EOL;
    }
}
