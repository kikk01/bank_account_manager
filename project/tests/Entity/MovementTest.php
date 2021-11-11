<?php

namespace App\Tests\Entity;

use App\Entity\Movement;
use App\Tests\AbstractKernelTestCase;
use DateTime;

class MovementTest extends AbstractKernelTestCase
{
    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setAmount(100), 0);
    }

    public function testInvalidTooBigAmount()
    {
        $this->assertHasErrors($this->getEntity()->setAmount(100000000000), 1);
    }

    public function testInvalidTooSmallAmount()
    {
        $this->assertHasErrors($this->getEntity()->setAmount(-100000000000), 1);
    }

    public function testInvalidZeroAmount()
    {
        $this->assertHasErrors($this->getEntity()->setAmount(0), 1);
    }

    public function testInvalideTooManyNumberAfterDecimalPointAmount()
    {
        $this->assertHasErrors($this->getEntity()->setAmount(-100.00011), 1);
    }

    private function getEntity()
    {
        return (new Movement())
            ->setDescription('libellé de l\'opération')
            ->setDate(new DateTime());
    }
}
