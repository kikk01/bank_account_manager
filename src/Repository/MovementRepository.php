<?php

namespace App\Repository;

use App\Entity\Movement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\BankAccount;

/**
 * @method Movement|null    find($id, $lockMode = null, $lockVersion = null)
 * @method Movement|null    findOneBy(array $criteria, array $orderBy = null)
 * @method Movement[]       findAll()
 * @method Movement[]       findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Movement[]|null  findByBankAccount(
 *      BankAccount $bankAccount,
 *      array $criteria,
 *      array $orderBy = null,
 *      $limit = null,
 *      $offset = null)
 */
class MovementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movement::class);
    }
}
