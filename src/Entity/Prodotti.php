<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProdottiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *               "path"="/prodotti/"
 *          }
 *     },
 *     itemOperations={
 *          "get"={"path"="/prodotti/{id}"}
 *      },
 * )
 * @ORM\Entity(repositoryClass=ProdottiRepository::class)
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Prodotti
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
     * @ORM\Column(type="float")
     */
    private $prezzo_unitario;

    /**
     * @ORM\OneToMany(targetEntity=Erogazioni::class, mappedBy="prodotto", orphanRemoval=true)
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
     *
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
