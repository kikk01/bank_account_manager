<?php

namespace App\Tests\BankAccount\Controller;

use App\Tests\AbstractWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class BankAccountReadControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    const PATH = '/bank-account/1/read';

    public function testDisplayAccountRead()
    {
        $this->loadUserFixturesThenLogin();
        $this->loadFixtureFiles([dirname(__DIR__, 2).'/fixtures/bank_account.yaml']);
        $this->assertDisplay(self::PATH, 'Compte : ');
    }

    public function testUserNotConnected()
    {
        $this->createClientThenRequest(self::PATH);
        $this->assertResponseRedirects(self::LOGIN_PATH);
    }
}
