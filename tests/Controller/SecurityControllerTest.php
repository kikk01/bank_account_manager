<?php

namespace App\Tests\Controller;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testDisplayLogin()
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Connection');
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function testLoginWithBadCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('valider')->form([
            'login' => ['email' => 'john@doe.fr', 'password' => 'fakepassword']
        ]);
    
        $client->submit($form);
        
        $this->assertResponseRedirects('/login');
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testSuccessfullLogin()
    {
        $client = static::createClient();
        $this->loadFixtureFiles([dirname(__DIR__) . '/fixtures/user.yaml']);
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('valider')->form([
            'login' => ['email' => 'used@test.fr', 'password' => '0000']
        ]);
        
        $client->submit($form);
        $this->assertResponseRedirects('/');
    }


}
