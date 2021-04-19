<?php

namespace App\Tests\BankAccount\Controller;

use App\Tests\AbstractWebTestCase;
use App\Tests\PathConstant;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class BankAccountCreateControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    public function testDisplayAccountCreate()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->assertDisplay(PathConstant::BANK_ACCOUNT_CREATE, 'Nouveau compte');
    }

    public function testUserNotConnected()
    {
        $this->request(PathConstant::BANK_ACCOUNT_CREATE);
        $this->assertResponseRedirects(PathConstant::LOGIN);
    }

    public function testSuccessfullBankAccountAdd()
    {
        $this->loadUserFixturesThenLogin('user');
        $crawler = $this->request(PathConstant::BANK_ACCOUNT_CREATE);
        $form = $crawler->selectButton('valider')->form([
            'bank_account' => [
                'name' => 'compte courant',
                'accountNumber' => '12345123456789012',
            ]
        ]);
        $this->submitThenRedirect($form, PathConstant::BANK_ACCOUNT_LIST);
    }

    public function testInvalidBankAccountAdd()
    {
        $this->loadUserFixturesThenLogin('user');
        $crawler = $this->request(PathConstant::BANK_ACCOUNT_CREATE);
        $form = $crawler->selectButton('valider')->form([
            'bank_account' => [
                'name' => 'compte courant',
                'accountNumber' => '1',
            ]
        ]);
        $this->submitInvalidForm($form);
    }
}
