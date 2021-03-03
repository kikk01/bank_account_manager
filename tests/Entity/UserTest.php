<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Tests\AbstractKernelTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class UserTest extends AbstractKernelTestCase
{
    use FixturesTrait;

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidMail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('azezae'), 1);
        $this->assertHasErrors($this->getEntity()->setEmail('test@test..test'), 1);
    }

    public function testInvalidBlankEmail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail(''), 1);
    }

    public function testInvalidUsedEmail()
    {
        $this->loadFixtureFiles([dirname(__DIR__) . '/fixtures/user.yaml']);
        $this->assertHasErrors($this->getEntity()->setEmail('used@test.fr'), 1);
    }

    private function getEntity(): User
    {
        return (new User())
            ->setEmail('new@test.fr')
            ->setPassword('0000');
    }
}
