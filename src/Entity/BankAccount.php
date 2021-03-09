<?php

namespace App\Entity;

use App\Repository\BankAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BankAccountRepository::class)
 * @UniqueEntity("accountNumber", ignoreNull=true)
 */
class BankAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=17, nullable=true)
     * @Assert\Length(min=17, max=17)
     */
    private ?string $accountNumber;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(max=50)
     * @Assert\NotBlank
     */
    private ?string $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4)
     * @Assert\Regex("/^-?\d{1,10}(\.\d{1,4})?$/")
     */
    private ?float $balance = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(?string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(?float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }
}
