<?php

namespace App\Tests\BankAccount\Controller;

use App\Tests\AbstractWebTestCase;

class BankAccountListControllerTest extends AbstractWebTestCase
{
    const PATH = '/bank-account/list';

    public function testDisplayAccountList()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->assertDisplay(self::PATH, 'Liste des comptes');
    }

    public function testUserNotConnected()
    {
        $this->request(self::PATH);
        $this->assertResponseRedirects(self::LOGIN_PATH);
    }

    public function testBankAccountReadRoute()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->loadFixtureFiles([dirname(__DIR__, 2).'/fixtures/bank_account.yaml']);
        $this->request(self::PATH);
        $this->client->clickLink('compte courant');
        $this->assertSelectorTextContains('h1', 'Compte: compte courant');
    }
}
