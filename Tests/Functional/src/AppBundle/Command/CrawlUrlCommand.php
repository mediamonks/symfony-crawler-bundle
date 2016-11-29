<?php

namespace AppBundle\Command;

use MediaMonks\Crawler\Page;
use MediaMonks\CrawlerBundle\Command\CrawlUrlCommand as BaseCrawlUrlCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CrawlUrlCommand extends BaseCrawlUrlCommand
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        parent::execute($input, $output);
    }

    /**
     * @param Page $page
     */
    protected function handlePage(Page $page)
    {
        $this->output->writeln((string)$page->getUrl());
    }
}
