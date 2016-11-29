<?php

namespace MediaMonks\CrawlerBundle\Tests\Command;

use MediaMonks\CrawlerBundle\Command\CrawlUrlCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CrawlUrlCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new CrawlUrlCommand());

        $command = $application->find('mediamonks:crawler:crawl-url');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
                'command'  => $command->getName(),
                'url' => 'http://non-existing-hostname',
                '--limit' => 1
            ]
        );

        $output = $commandTester->getDisplay();
        $this->assertEmpty($output);
    }
}
