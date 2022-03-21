<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransazioniRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *               "path"="/transazioni/"
 *          },
 *          "post"={
                "path"="/transazioni/",
 *              "access_control"="is_granted('ROLE_ADMIN') || is_granted('ROLE_GESTORE')"
 *          }
 *     },
 *     itemOperations={
 *          "get"={"path"="/transazioni/{id}"}
 *      },
 * )
 * @ORM\Entity(repositoryClass=TransazioniRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Transazioni
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utenti::class, inversedBy="transazioni")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operatore;

    /**
     * @ORM\ManyToOne(targetEntity=Utenti::class, inversedBy="accrediti")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utente;


    /**
     * @ORM\Column(type="float")
     */
    private $quantita;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

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

    public function getUtente(): ?Utenti
    {
        return $this->utente;
    }

    public function setUtente(?Utenti $utente): self
    {
        $this->utente = $utente;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
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
