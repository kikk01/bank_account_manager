<?php

namespace App\Service\Movement;

use App\Entity\Movement;
use App\Entity\BankAccount;
use App\Repository\MovementRepository;
use Doctrine\ORM\EntityManagerInterface;

class MovementCreateService
{
    private MovementRepository $movementRepository;

    private EntityManagerInterface $em;

    public function __construct(MovementRepository $movementRepository, EntityManagerInterface $em)
    {
        $this->movementRepository = $movementRepository;
        $this->em = $em;
    }

    public function create(BankAccount $bankAccount, array $movementsList): void
    {
        $movementInstanciateFromArrayService =
            new MovementInstanciateFromArrayService(count($movementsList[0]) === 6);

        foreach($movementsList as $movements) {
            $movement = (object) $movementInstanciateFromArrayService->instanciate($movements, $bankAccount);

            if (!$this->isMovementExist($movement)) {
                $this->em->persist($movement);
            }
        }
    }

    private function isMovementExist(Movement $movement): bool
    {
        $movementFromBdd = $this->movementRepository->findOneBy([
            'date' => $movement->getDate(),
            'description' => $movement->getDescription(),
            'bankAccount' => $movement->getBankAccount()
        ]);

        return (bool) $movementFromBdd instanceof Movement;
    }
}
