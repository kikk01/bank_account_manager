<?php

namespace App\DataFixtures;

use App\Entity\BankAccount as EntityBankAccount;
use App\Entity\Category;
use App\Entity\Movement;
use App\Entity\User;
use BankAccount;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $userWithoutCategories = (new User)->setEmail('userwithoutcategories@test.fr');
        $userWithoutCategories->setPassword($this->passwordHasher->hashPassword($userWithoutCategories, '00000000'));
        $bankAccount = (new EntityBankAccount)->setName('personnal account')->setUser($userWithoutCategories);
        $movement = (new Movement)->setAmount(100)->setDate(new DateTime())->setDescription('test')->setBankAccount($bankAccount);
        $manager->persist($movement);

        $user = (new User)->setEmail('test@test.fr');
        $user->setPassword($this->passwordHasher->hashPassword($user, '00000000'));
        $category = (New Category)->setName('category new')->setUser($user);
        $bankAccount = (new EntityBankAccount)->setName('personnal account')->setUser($user);
        $movement = (new Movement)
            ->setAmount(100)
            ->setDate(new DateTime())
            ->setDescription('test')
            ->setBankAccount($bankAccount);
        $manager->persist($movement);
        $manager->persist($category);

        $manager->flush();
    }
}
