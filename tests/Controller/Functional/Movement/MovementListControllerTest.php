<?php

namespace App\Tests\BankAccount\Controller;

use App\Tests\AbstractWebTestCase;
use App\Tests\PathConstant;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class MovementListControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    public function testDisplayAccountRead()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->loadFixtureFiles([
            dirname(__DIR__, 3).'/fixtures/bank_account.yaml',
            dirname(__DIR__, 3).'/fixtures/movements.yaml',
        ]);
        $this->assertDisplay(PathConstant::MOVEMENT_LIST, 'Compte: compte courant');
    }

    public function testUserNotConnected()
    {
        $this->request(PathConstant::MOVEMENT_LIST);
        $this->assertResponseRedirects(PathConstant::LOGIN);
    }
}
