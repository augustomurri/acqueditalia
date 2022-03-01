<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TessereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TessereRepository::class)
 */
class Tessere
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
    private $codice_tessera;

    /**
     * @ORM\ManyToOne(targetEntity=Utenti::class, inversedBy="tessere")
     */
    private $utente;

    /**
     * @ORM\Column(type="boolean")
     */
    private $attiva;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $data_attivazione;

    /**
     * @ORM\OneToMany(targetEntity=Erogazioni::class, mappedBy="tessera")
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

    public function getCodiceTessera(): ?string
    {
        return $this->codice_tessera;
    }

    public function setCodiceTessera(string $codice_tessera): self
    {
        $this->codice_tessera = $codice_tessera;

        return $this;
    }

    public function getUtente(): ?Utenti
    {
        return $this->utente;
    }

    public function setUtente(?Utenti $utente): self
    {
        $this->utente = $utente;

        return $this;
    }

    public function getAttiva(): ?bool
    {
        return $this->attiva;
    }

    public function setAttiva(bool $attiva): self
    {
        $this->attiva = $attiva;

        return $this;
    }

    public function getDataAttivazione(): ?\DateTimeInterface
    {
        return $this->data_attivazione;
    }

    public function setDataAttivazione(?\DateTimeInterface $data_attivazione): self
    {
        $this->data_attivazione = $data_attivazione;

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
            $erogazioni->setTessera($this);
        }

        return $this;
    }

    public function removeErogazioni(Erogazioni $erogazioni): self
    {
        if ($this->erogazioni->removeElement($erogazioni)) {
            // set the owning side to null (unless already changed)
            if ($erogazioni->getTessera() === $this) {
                $erogazioni->setTessera(null);
            }
        }

        return $this;
    }
}
