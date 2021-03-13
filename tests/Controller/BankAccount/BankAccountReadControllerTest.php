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
        $this->loadUserFixturesThenLogin('user');
        $this->loadFixtureFiles([
            dirname(__DIR__, 2).'/fixtures/bank_account.yaml',
            dirname(__DIR__, 2).'/fixtures/movements.yaml',
        ]);
        $this->assertDisplay(self::PATH, 'Compte: compte courant');
    }

    public function testUserNotConnected()
    {
        $this->request(self::PATH);
        $this->assertResponseRedirects(self::LOGIN_PATH);
    }
}
