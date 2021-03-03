<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractKernelTestCase extends KernelTestCase
{
    public function assertHasErrors(object $entity, int $number)
    {
        self::bootKernel();
        
        $errors = self::$container->get(ValidatorInterface::class)->validate($entity);

        $messages = [];

        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        $this->assertCount($number, $errors, implode(',', $messages));
    }
}
