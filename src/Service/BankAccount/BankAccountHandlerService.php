<?php

declare(strict_types=1);

namespace App\Service\BankAccount;

use App\Form\BankAccountType;
use App\Service\AbstractHandler;
use Doctrine\ORM\EntityManagerInterface;

class BankAccountHandlerService extends AbstractHandler
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    protected function getFormType(): string
    {
        return BankAccountType::class;
    }

    protected function process(object $bankAccount): void
    {
        $this->em->persist($bankAccount);
        $this->em->flush();
    }
}
