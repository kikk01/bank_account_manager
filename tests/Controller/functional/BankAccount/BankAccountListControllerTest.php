<?php

namespace App\Tests\BankAccount\Controller;

use App\Tests\AbstractWebTestCase;
use App\Tests\PathConstant;

class BankAccountListControllerTest extends AbstractWebTestCase
{
    public function testDisplayAccountList()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->assertDisplay(PathConstant::BANK_ACCOUNT_LIST, 'Liste des comptes');
    }

    public function testUserNotConnected()
    {
        $this->request(PathConstant::BANK_ACCOUNT_LIST);
        $this->assertResponseRedirects(PathConstant::LOGIN);
    }

    public function testBankAccountReadRoute()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->loadFixtureFiles([dirname(__DIR__, 3).'/fixtures/bank_account.yaml']);
        $this->request(PathConstant::BANK_ACCOUNT_LIST);
        $this->client->clickLink('compte courant');
        $this->assertSelectorTextContains('h1', 'Compte: compte courant');
    }
}
