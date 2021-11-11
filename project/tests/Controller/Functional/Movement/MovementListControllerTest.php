<?php

namespace App\Tests\BankAccount\Controller;

use App\Entity\User;
use App\Tests\AbstractWebTestCase;
use App\Tests\PathConstant;
use Doctrine\Persistence\ManagerRegistry;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Component\HttpFoundation\Response;

class MovementListControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    public function testDisplayAccountRead()
    {
        $fixtures = $this->loadFixtureFiles([
            dirname(__DIR__, 3).'/fixtures/user.yaml',
            dirname(__DIR__, 3).'/fixtures/bank_account.yaml',
            dirname(__DIR__, 3).'/fixtures/movements.yaml'
        ]);

        $this->client->loginUser($fixtures['user']);

        $this->assertDisplay(PathConstant::MOVEMENT_LIST, 'Compte: compte courant');
    }

    public function testUserNotConnected()
    {
        $this->request(PathConstant::MOVEMENT_LIST);
        $this->assertResponseRedirects(PathConstant::LOGIN);
    }

    public function testAccessDenied()
    {
        $user = (new User)->setPassword('00000000')->setEmail('testaccountreaddenied@test.fr');
        /** @var ObjectManager $objectManager */
        $objectManager = self::$container->get(ManagerRegistry::class)->getManager();
        $objectManager->persist($user);
        $objectManager->flush();

        $this->client->loginUser($user);
        $this->request(PathConstant::MOVEMENT_LIST);
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);

        $objectManager->remove($user);
        $objectManager->flush();
    }
}
