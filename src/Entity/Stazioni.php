<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StazioniRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=StazioniRepository::class)
 */
class Stazioni
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Comuni::class, inversedBy="stazioni")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comune;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComune(): ?Comuni
    {
        return $this->comune;
    }

    public function setComune(?Comuni $comune): self
    {
        $this->comune = $comune;

        return $this;
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
}
