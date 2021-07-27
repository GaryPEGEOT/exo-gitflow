<?php

namespace App\Entity;

use App\Repository\RacksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RacksRepository::class)
 */
class Racks
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     * min = 1,
     * max = 255,
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="racks")
     */
    private $help;

    public function __construct()
    {
        $this->help = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Products[]
     */
    public function getHelp(): Collection
    {
        return $this->help;
    }

    public function addHelp(Products $help): self
    {
        if (!$this->help->contains($help)) {
            $this->help[] = $help;
            $help->setRacks($this);
        }

        return $this;
    }

    public function removeHelp(Products $help): self
    {
        if ($this->help->removeElement($help)) {
            // set the owning side to null (unless already changed)
            if ($help->getRacks() === $this) {
                $help->setRacks(null);
            }
        }

        return $this;
    }
}
