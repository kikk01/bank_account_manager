<?php

namespace App\Tests\Controller;

use App\Tests\AbstractWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\HttpFoundation\Response;

class BankAccountControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    public function testDisplayAccountCreate()
    {
        $this->login();
        $this->createClientThenRequest('/bank-account/create');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1', 'Nouveau compte');
    }

    public function testUserNotConnected()
    {
        $this->createClientThenRequest('/bank-account/create');
        $this->assertResponseRedirects('/login');
    }

    public function testSuccessfullBankAccountAdd()
    {
        $this->login();
        $crawler = $this->createClientThenRequest('/bank-account/create');
        $form = $crawler->selectButton('valider')->form([
            'bank_account' => [
                'name' => 'compte courant',
                'accountNumber' => '12345123456789012',
            ]
        ]);
        $this->submitThenRedirect($form, '/');
    }

    private function login(): void
    {
        $users = $this->loadFixtureFiles([dirname(__DIR__).'/fixtures/user.yaml']);
        $this->client->loginUser($users['user']);
    }

}
