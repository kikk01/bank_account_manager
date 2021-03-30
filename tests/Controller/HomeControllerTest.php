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
        $this->request('/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Hello');
    }

    public function testNavWhenNotConnected()
    {
        $this->request('/');
        $this->assertSelectorTextContains('ul.navbar-nav', 'Se connecter');
        $this->assertSelectorTextContains('ul.navbar-nav', 'S\'inscrire');
        $this->assertSelectorTextNotContains('ul.navbar-nav', 'Se déconnecter');
        $this->assertSelectorTextNotContains('ul.navbar-nav', 'Mes comptes');
        $this->assertSelectorTextNotContains('ul.navbar-nav', 'Nouveau compte');
    }

    public function testLoginRoute()
    {
        $this->request('/');
        $this->client->clickLink('Se connecter');
        $this->assertSelectorTextContains('h1', 'Connection');
    }

    public function testRegistrationRoute()
    {
        $this->request('/');
        $this->client->clickLink('S\'inscrire');
        $this->assertSelectorTextContains('h1', 'S\'inscrire');
    }

    public function testNavWhenConnected()
    {
        $users = $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);
        $this->client->loginUser($users['user']);
        $this->request('/');
        $this->assertSelectorTextContains('ul.navbar-nav', 'Se déconnecter');
        $this->assertSelectorTextContains('ul.navbar-nav', 'Mes comptes');
        $this->assertSelectorTextContains('ul.navbar-nav', 'Nouveau compte');
        $this->assertSelectorTextNotContains('ul.navbar-nav', 'Se connecter');
        $this->assertSelectorTextNotContains('ul.navbar-nav', 'S\'inscrire');
    }

    public function testBankAccountListRoute()
    {
        $users = $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);
        $this->client->loginUser($users['user']);
        $this->request('/');
        $this->client->clickLink('Mes comptes');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Liste des comptes');
    }

    public function testBankAccountCreatetRoute()
    {
        $users = $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);
        $this->client->loginUser($users['user']);
        $this->request('/');
        $this->client->clickLink('Nouveau compte');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Nouveau compte');
    }

    public function testLogoutRoute()
    {
        $users = $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);
        $this->client->loginUser($users['user']);
        $this->request('/');
        $this->client->clickLink('Se déconnecter');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->client->followRedirect();
        $this->assertSelectorTextContains('h1', 'Hello');
    }
}
