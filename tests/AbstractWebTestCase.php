<?php

namespace App\Tests;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;

abstract class AbstractWebTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = self::createClient();
    }

    protected function createClientThenRequest(string $path, ?string $method = 'GET'): Crawler
    {
        return $this->client->request($method, $path);
    }

    protected function submitThenRedirect(Form $form, string $path)
    {
        $this->client->submit($form);
        $this->assertResponseRedirects($path);
        $this->client->followRedirect();
    }
}
