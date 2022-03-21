<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TessereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *               "path"="/tessere/"
 *          }
 *     },
 *     itemOperations={
 *          "get"={"path"="/tessere/{id}"}
 *      },
 * )
 * @ORM\Entity(repositoryClass=TessereRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Tessere
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
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

    public function __construct()
    {
        $this->erogazioni = new ArrayCollection();
    }

    public function getId(): ?Uuid
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
