<?php

namespace App\Tests\Controller;

use App\Entity\Movement;
use App\Tests\AbstractWebTestCase;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use App\Repository\MovementRepository;
use App\Tests\PathConstant;

class MovementCreateControllerTest extends AbstractWebTestCase
{
    use FixturesTrait;

    private ?MovementRepository $movementRepository = null;

    public function testDisplayAccountStatement()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->assertDisplay(PathConstant::MOVEMENT_CREATE, 'Importer un relevé de compte');
    }

    public function testSuccessfullSendAccountStatement()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->loadFixtureFiles([dirname(__DIR__, 3).'/fixtures/movements.yaml']);

        $crawler = $this->request(PathConstant::MOVEMENT_CREATE);
        $form = $crawler->selectButton('valider')->form([
            'movement_create' => [
                'accountStatement' => 'tests/fixtures/accountStatement.csv'
            ]
        ]);
        $this->submitThenRedirect($form, PathConstant::BANK_ACCOUNT_LIST);
    }

    public function testNotPersistExistingMovements()
    {
        $this->loadUserFixturesThenLogin('user');
        $this->loadFixtureFiles([dirname(__DIR__, 3).'/fixtures/movements.yaml']);
        $this->setMovementRepository();

        $this->verifyBddState();

        $crawler = $this->request(PathConstant::MOVEMENT_CREATE);
        $form = $crawler->selectButton('valider')->form([
            'movement_create' => [
                'accountStatement' => 'tests/fixtures/accountStatementDuplicate.csv'
            ]
        ]);
        $this->submitThenRedirect($form, PathConstant::BANK_ACCOUNT_LIST);

        $this->findMovementThenAssertEquals('movement exist', 1);
        $this->findMovementThenAssertEquals('new movement', 1);
    }

    private function setMovementRepository()
    {
        $this->movementRepository = self::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository(Movement::class);
    }

    private function verifyBddState()
    {
        $this->findMovementThenAssertEquals('movement exist', 1);
        $this->findMovementThenAssertEquals('new movement', 0);
    }

    private function findMovementThenAssertEquals(string $movementDescription, int $assertEquals)
    {
        $movements = $this->movementRepository->findBy(['description' => $movementDescription]);

        $this->assertEquals($assertEquals, count($movements));
    }
}
