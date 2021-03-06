<?php

namespace App\Entity;

use App\Repository\MovementRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MovementRepository::class)
 */
class Movement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=true)
     * @Assert\Regex("/^-?\d{1,10}(\.\d{1,4})?$/")
     */
    private ?float $amount;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTime $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="BankAccount")
     * Assert\Valid
     */
    private BankAccount $bankAccount;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $desciption): self
    {
        $this->description = $desciption;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of bankAccount
     */ 
    public function getBankAccount(): BankAccount
    {
        return $this->bankAccount;
    }

    /**
     * Set the value of bankAccount
     *
     * @return  self
     */ 
    public function setBankAccount($bankAccount): self
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }
}
