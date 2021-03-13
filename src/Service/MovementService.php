<?php

namespace App\Service;

use App\Entity\BankAccount;
use App\Repository\MovementRepository;

class MovementService
{
    protected MovementRepository $movementRepository;

    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    public function getMovementsByBankAccount(BankAccount $bankAccount): array
    {
        return $this->movementRepository->findByBankAccount(
            $bankAccount,
            [],
            ['date' => 'DESC']
        );
    }
}
