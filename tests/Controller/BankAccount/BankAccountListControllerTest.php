<?php

namespace App\Tests\BankAccount\Controller;

use App\Tests\AbstractWebTestCase;

class BankAccountListControllerTest extends AbstractWebTestCase
{
    const PATH = '/bank-account/list';

    public function testDisplayAccountList()
    {
        $this->loadUserFixturesThenLogin();
        $this->assertDisplay(self::PATH, 'Liste des comptes');
    }

    public function testUserNotConnected()
    {
        $this->createClientThenRequest(self::PATH);
        $this->assertResponseRedirects(self::LOGIN_PATH);
    }
}
