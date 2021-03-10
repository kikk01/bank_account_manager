<?php

namespace App\Tests;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractWebTestCase extends WebTestCase
{
    use FixturesTrait;

    const LOGIN_PATH = '/login';

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

    protected function loadUserFixturesThenLogin(): void
    {
        $users = $this->loadFixtureFiles([__DIR__.'/fixtures/user.yaml']);
        $this->client->loginUser($users['user']);
    }

    protected function assertDisplay($path, $textContain): void
    {
        $this->createClientThenRequest($path);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', $textContain);
    }

    protected function submitThenRedirect(Form $form, string $path): void
    {
        $this->client->submit($form);
        $this->assertResponseRedirects($path);
        $this->client->followRedirect();
    }

    protected function submitInvalidForm($form): void
    {
        $this->client->submit($form);
        $this->assertSelectorExists('.form-error-message');
    }
}
