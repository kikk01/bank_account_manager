<?php

namespace App\Tests\BankAccount\Controller;

use App\Tests\AbstractWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class BankAccountCreateControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    public function testDisplayAccountCreate()
    {
        $this->loadUserFixturesThenLogin();
        $this->assertDisplay('/bank-account/create', 'Nouveau compte');
    }

    public function testUserNotConnected()
    {
        $this->createClientThenRequest('/bank-account/create');
        $this->assertResponseRedirects('/login');
    }

    public function testSuccessfullBankAccountAdd()
    {
        $this->loadUserFixturesThenLogin();
        $crawler = $this->createClientThenRequest('/bank-account/create');
        $form = $crawler->selectButton('valider')->form([
            'bank_account' => [
                'name' => 'compte courant',
                'accountNumber' => '12345123456789012',
            ]
        ]);
        $this->submitThenRedirect($form, '/');
    }

    public function testInvalidBankAccountAdd()
    {
        $this->loadUserFixturesThenLogin();
        $crawler = $this->createClientThenRequest('/bank-account/create');
        $form = $crawler->selectButton('valider')->form([
            'bank_account' => [
                'name' => 'compte courant',
                'accountNumber' => '1',
            ]
        ]);
        $this->submitInvalidForm($form);
    }
}
