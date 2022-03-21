<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UtentiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use LasseRafn\InitialAvatarGenerator\InitialAvatar;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get"={
 *               "path"="/utenti/"
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *              "path"="/utenti/{id}"
 *          },
 *          "put"={
 *              "path"="/utenti/{id}"
 *          }
 *      },
 * ))
 * @ORM\Entity(repositoryClass=UtentiRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=true)
 */
class Utenti implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utenti::class, inversedBy="utenti")
     */
    private $gestore;

    /**
     * @ORM\OneToMany(targetEntity=Utenti::class, mappedBy="gestore")
     */
    private $utenti;

    /**
     * @ORM\ManyToOne(targetEntity=Comuni::class, inversedBy="utenti")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $comune;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cognome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codice_fiscale;

    /**
     * @ORM\Column(type="float", options={"default": "0"})
     */
    private $credito = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apitoken;

    /**
     * @ORM\Column(type="boolean", options={"default": "1"})
     */
    private $attivo = 1;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ultimo_login;

    /**
     * @ORM\OneToMany(targetEntity=Tessere::class, mappedBy="utente", orphanRemoval=true)
     */
    private $tessere;

    /**
     * @ORM\OneToMany(targetEntity=Transazioni::class, mappedBy="operatore", orphanRemoval=true)
     */
    private $transazioni;

    /**
     * @ORM\OneToMany(targetEntity=Transazioni::class, mappedBy="utente", orphanRemoval=true)
     */
    private $accrediti;

    /**
     * @ORM\ManyToOne(targetEntity=Ruoli::class, inversedBy="utenti")
     * @ORM\JoinColumn(nullable=false, columnDefinition="INT NOT NULL DEFAULT 2")
     */
    private $ruolo;

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

    /**
     * @ORM\PrePersist
     * @param LifecycleEventArgs $event
     */
    public function onPrePersist(LifecycleEventArgs $event)
    {
        if (empty($this->ruolo)) {
            $this->ruolo = $event->getEntityManager()->getReference('App\Entity\Ruoli', 4);
        }
    }

    public function __construct()
    {
        $this->tessere = new ArrayCollection();
        $this->transazioni = new ArrayCollection();
        $this->accrediti = new ArrayCollection();
        $this->utenti = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNome()." ".$this->getCognome();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return [$this->ruolo->getRole()];
    }

    public function setRoles(array $roles): self
    {
        $this->ruolo = $roles;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getApitoken(): ?string
    {
        return $this->apitoken;
    }

    public function setApitoken(string $apitoken): self
    {
        $this->apitoken = $apitoken;

        return $this;
    }

    public function getCredito(): ?float
    {
        return $this->credito;
    }

    public function setCredito(float $credito): self
    {
        $this->credito = $credito;

        return $this;
    }

    public function getAttivo(): ?bool
    {
        return $this->attivo;
    }

    public function setAttivo(bool $attivo): self
    {
        $this->attivo = $attivo;

        return $this;
    }

    public function getUltimoLogin(): ?\DateTimeInterface
    {
        return $this->ultimo_login;
    }

    public function setUltimoLogin(?\DateTimeInterface $ultimo_login): self
    {
        $this->ultimo_login = $ultimo_login;

        return $this;
    }

    /**
     * @return Collection<int, Tessere>
     */
    public function getTessere(): Collection
    {
        return $this->tessere;
    }

    public function addTessere(Tessere $tessere): self
    {
        if (!$this->tessere->contains($tessere)) {
            $this->tessere[] = $tessere;
            $tessere->setUtente($this);
        }

        return $this;
    }

    public function removeTessere(Tessere $tessere): self
    {
        if ($this->tessere->removeElement($tessere)) {
            // set the owning side to null (unless already changed)
            if ($tessere->getUtente() === $this) {
                $tessere->setUtente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Transazioni>
     */
    public function getTransazioni(): Collection
    {
        return $this->transazioni;
    }

    public function addTransazioni(Transazioni $transazioni): self
    {
        if (!$this->transazioni->contains($transazioni)) {
            $this->transazioni[] = $transazioni;
            $transazioni->setOperatore($this);
        }

        return $this;
    }

    public function removeTransazioni(Transazioni $transazioni): self
    {
        if ($this->transazioni->removeElement($transazioni)) {
            // set the owning side to null (unless already changed)
            if ($transazioni->getOperatore() === $this) {
                $transazioni->setOperatore(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getRuolo(): ?Ruoli
    {
        return $this->ruolo;
    }

    public function setRuolo(?Ruoli $ruolo): self
    {
        $this->ruolo = $ruolo;

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

    public function setNome(?string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCognome(): ?string
    {
        return $this->cognome;
    }

    public function setCognome(?string $cognome): self
    {
        $this->cognome = $cognome;

        return $this;
    }

    public function getCodiceFiscale(): ?string
    {
        return $this->codice_fiscale;
    }

    public function setCodiceFiscale(string $codice_fiscale): self
    {
        $this->codice_fiscale = $codice_fiscale;

        return $this;
    }

    /**
     * @return Collection<int, Transazioni>
     */
    public function getAccrediti(): Collection
    {
        return $this->accrediti;
    }

    public function addAccrediti(Transazioni $accrediti): self
    {
        if (!$this->accrediti->contains($accrediti)) {
            $this->accrediti[] = $accrediti;
            $accrediti->setUtente($this);
        }

        return $this;
    }

    public function removeAccrediti(Transazioni $accrediti): self
    {
        if ($this->accrediti->removeElement($accrediti)) {
            // set the owning side to null (unless already changed)
            if ($accrediti->getUtente() === $this) {
                $accrediti->setUtente(null);
            }
        }

        return $this;
    }

    public function getGestore(): ?self
    {
        return $this->gestore;
    }

    public function setGestore(?self $gestore): self
    {
        $this->gestore = $gestore;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getUtenti(): Collection
    {
        return $this->utenti;
    }

    public function addUtenti(self $utenti): self
    {
        if (!$this->utenti->contains($utenti)) {
            $this->utenti[] = $utenti;
            $utenti->setGestore($this);
        }

        return $this;
    }

    public function removeUtenti(self $utenti): self
    {
        if ($this->utenti->removeElement($utenti)) {
            // set the owning side to null (unless already changed)
            if ($utenti->getGestore() === $this) {
                $utenti->setGestore(null);
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

    public function getAvatar() {

        $avatarGenerator = new InitialAvatar();
        $params['avatar'] = $avatarGenerator
            ->name($this->__toString())
            ->size(64)
            ->background('#232e3e')
            ->generate()
            ->stream('data-url', 80);

    }

}
