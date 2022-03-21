<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComuniRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *              "path"="/comuni/"
 *          }
 *      },
 *     itemOperations={
 *          "get"={"path"="/comuni/{id}"}
 *      }
 * )
 * @ORM\Entity(repositoryClass=ComuniRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 * @Gedmo\Loggable
 */
class Comuni
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
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity=Stazioni::class, mappedBy="comune", orphanRemoval=true)
     */
    private $stazioni;

    /**
     * @ORM\OneToMany(targetEntity=Utenti::class, mappedBy="comune")
     */
    private $utenti;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $latitudine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $longitudine;

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
        $this->stazioni = new ArrayCollection();
        $this->utenti = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __toString()
    {
        return $this->getNome();
    }

    public function getId(): ?Uuid
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

    /**
     * @return Collection<int, Utenti>
     */
    public function getUtenti(): Collection
    {
        return $this->utenti;
    }

    public function addUtenti(Utenti $utenti): self
    {
        if (!$this->utenti->contains($utenti)) {
            $this->utenti[] = $utenti;
            $utenti->setComune($this);
        }

        return $this;
    }

    public function removeUtenti(Utenti $utenti): self
    {
        if ($this->utenti->removeElement($utenti)) {
            // set the owning side to null (unless already changed)
            if ($utenti->getComune() === $this) {
                $utenti->setComune(null);
            }
        }

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
