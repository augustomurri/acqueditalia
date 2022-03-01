<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ErogazioniRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=ErogazioniRepository::class)
 */
class Erogazioni
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tessere::class, inversedBy="erogazioni")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tessera;

    /**
     * @ORM\ManyToOne(targetEntity=Prodotti::class, inversedBy="erogazioni")
     * @ORM\JoinColumn(nullable=false)
     */
    private $prodotto;

    /**
     * @ORM\Column(type="float")
     */
    private $quantita;

    /**
     * @ORM\Column(type="float")
     */
    private $costo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_ora;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTessera(): ?Tessere
    {
        return $this->tessera;
    }

    public function setTessera(?Tessere $tessera): self
    {
        $this->tessera = $tessera;

        return $this;
    }

    public function getProdotto(): ?Prodotti
    {
        return $this->prodotto;
    }

    public function setProdotto(?Prodotti $prodotto): self
    {
        $this->prodotto = $prodotto;

        return $this;
    }

    public function getQuantita(): ?float
    {
        return $this->quantita;
    }

    public function setQuantita(float $quantita): self
    {
        $this->quantita = $quantita;

        return $this;
    }

    public function getCosto(): ?float
    {
        return $this->costo;
    }

    public function setCosto(float $costo): self
    {
        $this->costo = $costo;

        return $this;
    }

    public function getDataOra(): ?\DateTimeInterface
    {
        return $this->data_ora;
    }

    public function setDataOra(\DateTimeInterface $data_ora): self
    {
        $this->data_ora = $data_ora;

        return $this;
    }
}
