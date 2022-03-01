<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransazioniRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TransazioniRepository::class)
 */
class Transazioni
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utenti::class, inversedBy="transazioni")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operatore;

    /**
     * @ORM\Column(type="float")
     */
    private $quantita;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_ora;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperatore(): ?Utenti
    {
        return $this->operatore;
    }

    public function setOperatore(?Utenti $operatore): self
    {
        $this->operatore = $operatore;

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
