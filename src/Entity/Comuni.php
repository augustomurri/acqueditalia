<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComuniRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ComuniRepository::class)
 */
class Comuni
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity=Stazioni::class, mappedBy="comune")
     */
    private $stazioni;

    public function __construct()
    {
        $this->stazioni = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * @return Collection<int, Stazioni>
     */
    public function getStazioni(): Collection
    {
        return $this->stazioni;
    }

    public function addStazioni(Stazioni $stazioni): self
    {
        if (!$this->stazioni->contains($stazioni)) {
            $this->stazioni[] = $stazioni;
            $stazioni->setComune($this);
        }

        return $this;
    }

    public function removeStazioni(Stazioni $stazioni): self
    {
        if ($this->stazioni->removeElement($stazioni)) {
            // set the owning side to null (unless already changed)
            if ($stazioni->getComune() === $this) {
                $stazioni->setComune(null);
            }
        }

        return $this;
    }
}
