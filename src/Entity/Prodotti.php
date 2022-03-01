<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProdottiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProdottiRepository::class)
 */
class Prodotti
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
     * @ORM\Column(type="float")
     */
    private $prezzo_unitario;

    /**
     * @ORM\OneToMany(targetEntity=Erogazioni::class, mappedBy="prodotto")
     */
    private $erogazioni;

    public function __construct()
    {
        $this->erogazioni = new ArrayCollection();
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

    public function getPrezzoUnitario(): ?float
    {
        return $this->prezzo_unitario;
    }

    public function setPrezzoUnitario(float $prezzo_unitario): self
    {
        $this->prezzo_unitario = $prezzo_unitario;

        return $this;
    }

    /**
     * @return Collection<int, Erogazioni>
     */
    public function getErogazioni(): Collection
    {
        return $this->erogazioni;
    }

    public function addErogazioni(Erogazioni $erogazioni): self
    {
        if (!$this->erogazioni->contains($erogazioni)) {
            $this->erogazioni[] = $erogazioni;
            $erogazioni->setProdotto($this);
        }

        return $this;
    }

    public function removeErogazioni(Erogazioni $erogazioni): self
    {
        if ($this->erogazioni->removeElement($erogazioni)) {
            // set the owning side to null (unless already changed)
            if ($erogazioni->getProdotto() === $this) {
                $erogazioni->setProdotto(null);
            }
        }

        return $this;
    }
}
