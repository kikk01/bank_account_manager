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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $userWithoutCategories = (new User)->setEmail('userwithoutcategories@test.fr');
        $userWithoutCategories->setPassword($this->passwordEncoder->encodePassword($userWithoutCategories, '00000000'));
        $bankAccount = (new EntityBankAccount)->setName('personnal account')->setUser($userWithoutCategories);
        $movement = (new Movement)->setAmount(100)->setDate(new DateTime())->setDescription('test')->setBankAccount($bankAccount);
        $manager->persist($movement);

        $user = (new User)->setEmail('test@test.fr');
        $user->setPassword($this->passwordEncoder->encodePassword($user, '00000000'));
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
