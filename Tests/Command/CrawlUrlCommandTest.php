<?php

namespace MediaMonks\CrawlerBundle\Tests\Command;

use MediaMonks\Crawler\Crawler;
use MediaMonks\Crawler\Exception\RequestException;
use MediaMonks\CrawlerBundle\Command\CrawlUrlCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use Mockery as m;

class CrawlUrlCommandTest extends KernelTestCase
{
    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var CrawlUrlCommand
     */
    private $command;

    /**
     * @var CommandTester
     */
    private $commandTester;

    protected function setUp()
    {
        parent::setUp();

        self::bootKernel();

        $application = new Application(self::$kernel);
        $application->add(new CrawlUrlCommand());

        $this->crawler = self::$kernel->getContainer()->get('mediamonks_crawler.crawler');
        $this->crawler->setClient($this->getDummyClient());

        $this->command = $application->find('mediamonks:crawler:crawl-url');
        $this->commandTester = new CommandTester($this->command);
    }

    public function test_execute()
    {
        $this->commandTester->execute(
            [
                'command'  => $this->command->getName(),
                'url' => 'http://my-test/'
            ]
        );

        $output = $this->commandTester->getDisplay();

        $this->assertContains('page_1.html', $output);
        $this->assertContains('page_2.html', $output);
        $this->assertContains('page_3.html', $output);
        $this->assertContains('page_4.html', $output);
    }

    public function test_execute_limit()
    {
        $this->commandTester->execute(
            [
                'command'  => $this->command->getName(),
                'url' => 'http://my-test/',
                '--limit' => 1
            ]
        );

        $output = $this->commandTester->getDisplay();

        $this->assertNotContains('page_1.html', $output);
        $this->assertNotContains('page_2.html', $output);
        $this->assertNotContains('page_3.html', $output);
        $this->assertNotContains('page_4.html', $output);
    }

    public function test_execute_stop_on_error()
    {
        $this->crawler->setClient($this->getDummyClient(true));

        $this->commandTester->execute(
            [
                'command'  => $this->command->getName(),
                'url' => 'http://my-test/',
                '--stop-on-error' => true
            ]
        );

        $output = $this->commandTester->getDisplay();

        $this->assertNotContains('page_1.html', $output);
        $this->assertNotContains('page_2.html', $output);
        $this->assertNotContains('page_3.html', $output);
        $this->assertNotContains('page_4.html', $output);
    }

    public function test_execute_does_not_stop_on_error()
    {
        $this->crawler->setClient($this->getDummyClient(true));

        $this->commandTester->execute(
            [
                'command'  => $this->command->getName(),
                'url' => 'http://my-test/'
            ]
        );

        $output = $this->commandTester->getDisplay();

        $this->assertContains('page_1.html', $output);
        $this->assertContains('page_2.html', $output);
        $this->assertNotContains('page_3.html', $output);
        $this->assertContains('page_4.html', $output);
    }

    public function test_execute_exception_on_error()
    {
        $this->setExpectedException(RequestException::class);

        $this->crawler->setClient($this->getDummyClient(true));

        $this->commandTester->execute(
            [
                'command'  => $this->command->getName(),
                'url' => 'http://my-test/',
                '--exception-on-error' => true
            ]
        );

        $output = $this->commandTester->getDisplay();

        $this->assertNotContains('page_1.html', $output);
        $this->assertNotContains('page_2.html', $output);
        $this->assertNotContains('page_3.html', $output);
        $this->assertNotContains('page_4.html', $output);
    }

    /**
     * @return m\MockInterface
     */
    protected function getDummyClient($error = false)
    {
        $client = m::mock(Client::class);

        $i = 0;
        $client->shouldReceive('request')->andReturnUsing(
            function () use (&$i, $error) {
                $i++;
                switch ($i) {
                    case 1:
                        $html = '<html><body><a href="/page_1.html">Page 1</a><a href="/page_2.html">Page 2</a></body></html>';
                        break;
                    case 2:
                        if ($error) {
                            throw new \Exception('Something is broken!');
                        }
                        $html = '<html><body><a href="/page_3.html">Page 3</a><a href="http://external/">External</a></body></html>';
                        break;
                    case 3:
                        $html = '<html><body><a href="/page_4.html">Page 4</a><a href="mailto:foo@bar.com">Invalid</a></body></html>';
                        break;
                    default:
                        $html = '<html><body><a href="/page_1.html">Page 1</a><a href="http://external/">External</a></body></html>';
                        break;
                }

                return new DomCrawler($html, 'http://my-test');
            }
        );

        return $client;
    }
}
