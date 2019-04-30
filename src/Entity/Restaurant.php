<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 * @UniqueEntity("name")
 */
class Restaurant  
{

    const EVALUATION = [
        0 => 'bad', 
        1 => 'not recommend',
        2 => 'acceptable',
        3 => 'recommend',
        4 => 'good',
        6 => 'perfect',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     * @@Assert\Regex("/^[0-9]{10}/")
     */
    private $telephone;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $close_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Range(min=1,max=1000000)
     */
    private $average_price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $transportation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $place;

    /**
     * @ORM\Column(type="integer")
     */
    private $evaluation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Option", inversedBy="properties")
     */
    private $options;

    public function __construct()
    {
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug() : string
    {
        return (new Slugify())->slugify($this->name);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->start_at;
    }

    public function setStartAt(\DateTimeInterface $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getCloseAt(): ?\DateTimeInterface
    {
        return $this->close_at;
    }

    public function setCloseAt(\DateTimeInterface $close_at): self
    {
        $this->close_at = $close_at;

        return $this;
    }

    public function getAveragePrice(): ?int
    {
        return $this->average_price;
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->average_price, 0, '', ' ');
    }

    public function setAveragePrice(?int $average_price): self
    {
        $this->average_price = $average_price;

        return $this;
    }

    public function getTransportation(): ?string
    {
        return $this->transportation;
    }

    public function setTransportation(?string $transportation): self
    {
        $this->transportation = $transportation;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(?int $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getEvaluation(): ?int
    {
        return $this->evaluation;
    }

    public function getEvaluationType() : string 
    {
        return self::Evaluation[$this->evaluation];
    }

    public function setEvaluation(int $evaluation): self
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addProperty($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
            $option->removeProperty($this);
        }

        return $this;
    }
}
