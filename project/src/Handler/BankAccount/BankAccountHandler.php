<?php

namespace App\Handler\BankAccount;

use App\Form\BankAccountType;
use App\Handler\AbstractHandler;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\Security\Core\Security;

class BankAccountHandler extends AbstractHandler
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function getFormType(): string
    {
        return BankAccountType::class;
    }

    protected function process(?object $bankAccount): void
    {
        if ($this->em->getUnitOfWork()->getEntityState($bankAccount) === UnitOfWork::STATE_NEW) {
            $bankAccount->setUser($this->security->getUser());
            $this->em->persist($bankAccount);
        }

        $this->em->flush();
    }
}
