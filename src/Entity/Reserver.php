<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Reserver{
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */

    private $firstname;
    
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/[0-9]{10}/")
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10)
     */

    private $message;

    /**
     * @var time|null
     */
    private $time;

    /**
     * @var Restaurant|null
     */
    private $restaurant;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string|null $firstname
     * @return Reserver
     */
    public function setFirstname(?string $firstname): Reserver
    {
        $this->firstname = $firstname;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }
    /**
     * @param string|null $lastname
     * @return Reserver
     */
    public function setLastname(?string $lastname): Reserver
    {
        $this->lastname = $lastname;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    /**
     * @param string|null $phone
     * @return Reserver
     */
    public function setPhone(?string $phone): Reserver
    {
        $this->phone = $phone;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    /**
     * @param string|null $email
     * @return Reserver
     */
    public function setEmail(?string $email): Reserver
    {
        $this->email = $email;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
    /**
     * @param string|null $message
     * @return Reserver
     */
    public function setMessage(?string $message): Reserver
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return Restaurant|null
     */
    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    /**
     * @param Restaurant|null $restaurant
     * @return Restaurant
     */
    public function setRestaurant(?Restaurant $restaurant){
        $this->restaurant = $restaurant;
        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;
        
        return $this;
    }
}