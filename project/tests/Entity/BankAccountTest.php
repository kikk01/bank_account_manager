<?php

namespace App\Tests\Entity;

use App\Entity\BankAccount;
use App\Tests\AbstractKernelTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class BankAccountTest extends AbstractKernelTestCase
{
    use FixturesTrait; 

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidNumberOfCharAccount()
    {
        $this->assertHasErrors($this->getEntity()->setAccountNumber('azeaze'), 1);
        $this->assertHasErrors($this->getEntity()->setAccountNumber('azeazeazeazeazezae'), 1);
    }

    public function testInvalidUsedAccount()
    {
        $this->loadFixtureFiles([dirname(__DIR__) . '/fixtures/bank_account.yaml']);
        $this->assertHasErrors($this->getEntity()->setAccountNumber('12345123456789112'), 1);
    }

    public function testValidNullAccount()
    {
        $this->loadFixtureFiles([dirname(__DIR__) . '/fixtures/bank_account.yaml']);
        $this->assertHasErrors($this->getEntity()->setAccountNumber(null), 0);
    }

    public function testInvalidTooLongName()
    {
        $this->assertHasErrors(
            $this->getEntity()->setName('azeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeazeaze'),
            1
        );
    }

    public function testInvalidEmptyName()
    {
        $this->assertHasErrors($this->getEntity()->setName(''), 1);
    }

    public function testInvalidTooBigBalance()
    {
        $this->assertHasErrors($this->getEntity()->setBalance(100000000000), 1);
    }

    public function testInvalidTooSmallBalance()
    {
        $this->assertHasErrors($this->getEntity()->setBalance(-100000000000), 1);
    }

    public function testInvalideTooManyNumberAfterDecimalPointBalance()
    {
        $this->assertHasErrors($this->getEntity()->setBalance(100.00011), 1);
    }

    private function getEntity()
    {
        return (new BankAccount())
            ->setAccountNumber('11111111111111111')
            ->setName('compte perso')
            ->setBalance(100);
    }
}
