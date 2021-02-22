<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends KernelTestCase
{
    use FixturesTrait;

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidMail()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('azezae'), 1);
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

    private function assertHasErrors(User $user, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get(ValidatorInterface::class)->validate($user);

        $messages = [];

        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        $this->assertCount($number, $errors, implode(',', $messages));
    }

    private function getEntity(): User
    {
        return (new User())
            ->setEmail('new@test.fr')
            ->setPassword('0000');
    }
}
