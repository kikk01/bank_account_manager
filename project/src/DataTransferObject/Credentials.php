<?php

namespace App\DataTransferObject;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Credentials
 * @package App\DataTransferObject
 */
class Credentials
{

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private ?string $email = null;

    /**
     * @var string|null
     * @Assert\NotBlank
     */
    private ?string $password = null;

    public function __construct(?string $email = null)
    {
        $this->email = $email;
    }

        /**
     * Get the value of email
     *
     * @return  string|null
     */ 
    public function getEmail() : ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string|null  $email
     *
     * @return  self
     */ 
    public function setEmail($email) : self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string|null
     */ 
    public function getPassword() : ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string|null  $password
     *
     * @return  self
     */ 
    public function setPassword($password) : self
    {
        $this->password = $password;

        return $this;
    }
}