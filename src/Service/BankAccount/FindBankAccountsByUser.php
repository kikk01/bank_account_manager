<?php

namespace App\Service\BankAccount;

use App\Repository\BankAccountRepository;
use Symfony\Component\Security\Core\Security;

class FindBankAccountsByUser
{
    private Security $security;

    private BankAccountRepository $bankAccountRepository;

    public function __construct(Security $security, BankAccountRepository $bankAccountRepository)
    {
        $this->security = $security;
        $this->bankAccountRepository = $bankAccountRepository;
    }

    public function findBankAccountsByUser(): array
    {
        /** @var User $user */
        $user = $this->security->getUser();

        return $this->bankAccountRepository->findByUser($user->getId());
    }
}
