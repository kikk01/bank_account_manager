<?php

namespace App\Service\Movement;

use App\Entity\BankAccount;
use App\Entity\Movement;
use DateTime;

class MovementInstanciateFromArrayService
{
    private const DATE = 1;

    private const CREDIT = 3;

    private const AMOUNT = 2;

    private bool $isCreditAndDebitOnTwoColumns;

    private int $descriptionKey = 3;

    public function __construct(bool $isCreditAndDebitOnTwoColumns = false)
    {
        $this->isCreditAndDebitOnTwoColumns = $isCreditAndDebitOnTwoColumns;

        if ($this->isCreditAndDebitOnTwoColumns) {
            $this->descriptionKey = 4;
        }
    }

    public function instanciate($movements, BankAccount $bankAccount): Movement
    {
        $amount = empty($movements[self::AMOUNT]) ? self::CREDIT : self::AMOUNT;

        $movement = (new Movement)
            ->setDate(DateTime::createFromFormat('j/m/Y', $movements[self::DATE]))
            ->setBankAccount($bankAccount)
            ->setAmount(floatval($movements[$amount]))
            ->setDescription($movements[$this->descriptionKey]);

        return $movement;
    }
}
