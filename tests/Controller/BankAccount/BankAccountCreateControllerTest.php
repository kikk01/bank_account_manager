<?php

namespace App\Tests\BankAccount\Controller;

use App\Tests\AbstractWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class BankAccountCreateControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    public function testDisplayAccountCreate()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->assertDisplay('/bank-account/create', 'Nouveau compte');
    }

    public function testUserNotConnected()
    {
        $this->request('/bank-account/create');
        $this->assertResponseRedirects('/login');
    }

    public function testSuccessfullBankAccountAdd()
    {
        $this->loadUserFixturesThenLogin('user');
        $crawler = $this->request('/bank-account/create');
        $form = $crawler->selectButton('valider')->form([
            'bank_account' => [
                'name' => 'compte courant',
                'accountNumber' => '12345123456789012',
            ]
        ]);
        $this->submitThenRedirect($form, BankAccountListControllerTest::PATH);
    }

    public function testInvalidBankAccountAdd()
    {
        $this->loadUserFixturesThenLogin('user');
        $crawler = $this->request('/bank-account/create');
        $form = $crawler->selectButton('valider')->form([
            'bank_account' => [
                'name' => 'compte courant',
                'accountNumber' => '1',
            ]
        ]);
        $this->submitInvalidForm($form);
    }
}
