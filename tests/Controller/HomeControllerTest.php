<?php

namespace App\Tests\Controller;

use App\Tests\AbstractWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;
    public function testDisplayHome()
    {
        $this->createClientThenRequest('/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Hello');
    }

    public function testNavWhenNotConnected()
    {
        $this->createClientThenRequest('/');
        $this->assertSelectorTextContains('ul.navbar-nav', 'Se connecter');
        $this->assertSelectorTextContains('ul.navbar-nav', 'S\'inscrire');
        $this->assertSelectorTextNotContains('ul.navbar-nav', 'Se déconnecter');
    }

    public function testLoginRoute()
    {
        $this->createClientThenRequest('/');
        $this->client->clickLink('Se connecter');
        $this->assertSelectorTextContains('h1', 'Connection');
    }

    public function testRegistrationRoute()
    {
        $this->createClientThenRequest('/');
        $this->client->clickLink('S\'inscrire');
        $this->assertSelectorTextContains('h1', 'S\'inscrire');
    }

    public function testNavWhenConnected()
    {
        $users = $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);
        $this->client->loginUser($users['user']);
        $this->createClientThenRequest('/');
        $this->assertSelectorTextContains('ul.navbar-nav', 'Se déconnecter');
        $this->assertSelectorTextNotContains('ul.navbar-nav', 'Se connecter');
        $this->assertSelectorTextNotContains('ul.navbar-nav', 'S\'inscrire');
    }
}
