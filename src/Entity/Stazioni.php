<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StazioniRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *               "path"="/stazioni/"
 *          }
 *     },
 *     itemOperations={
 *          "get"={"path"="/stazioni/{id}"}
 *      },
 * )
 * @ORM\Entity(repositoryClass=StazioniRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Stazioni
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utenti::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $gestore;

    /**
     * @ORM\ManyToOne(targetEntity=Comuni::class, inversedBy="stazioni")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comune;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitudine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitudine;

    /**
     * @ORM\OneToMany(targetEntity=Erogazioni::class, mappedBy="stazione", orphanRemoval=true)
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

    public function getGestore(): ?Utenti
    {
        return $this->gestore;
    }

    public function setGestore(?Utenti $gestore): self
    {
        $this->gestore = $gestore;

        return $this;
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

    public function getLatitudine(): ?string
    {
        return $this->latitudine;
    }

    public function setLatitudine(string $latitudine): self
    {
        $this->latitudine = $latitudine;

        return $this;
    }

    public function getLongitudine(): ?string
    {
        return $this->longitudine;
    }

    public function setLongitudine(string $longitudine): self
    {
        $this->longitudine = $longitudine;

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
            $erogazioni->setStazione($this);
        }

        return $this;
    }

    public function removeErogazioni(Erogazioni $erogazioni): self
    {
        if ($this->erogazioni->removeElement($erogazioni)) {
            // set the owning side to null (unless already changed)
            if ($erogazioni->getStazione() === $this) {
                $erogazioni->setStazione(null);
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
