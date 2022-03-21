<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ErogazioniRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *               "path"="/erogazioni/"
 *          },
 *          "post"={
                "path"="/erogazioni/",
 *              "access_control"="is_granted('ROLE_ADMIN') || is_granted('ROLE_GESTORE')"
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "path"="/erogazioni/{id}"
 *          }
 *      },
 * )
 * @ORM\Entity(repositoryClass=ErogazioniRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Erogazioni
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
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

    /**
     * @ORM\ManyToOne(targetEntity=Stazioni::class, inversedBy="erogazioni")
     * @ORM\JoinColumn(nullable=false)
     */
    private $stazione;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;


    public function getId(): ?Uuid
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

    public function getStazione(): ?Stazioni
    {
        return $this->stazione;
    }

    public function setStazione(?Stazioni $stazione): self
    {
        $this->stazione = $stazione;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
