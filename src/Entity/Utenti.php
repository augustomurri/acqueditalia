<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UtentiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=UtentiRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Utenti implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Utenti::class, inversedBy="utenti", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, columnDefinition="INT NULL DEFAULT 0")
     */
    private $gestore;

    /**
     * @ORM\OneToOne(targetEntity=Utenti::class, mappedBy="gestore", cascade={"persist", "remove"})
     */
    private $utenti;

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
    private $apitoken;

    /**
     * @ORM\Column(type="float", options={"default": "0"})
     */
    private $credito = 0;

    /**
     * @ORM\Column(type="boolean", options={"default": "1"})
     */
    private $attivo = 1;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ultimo_login;

    /**
     * @ORM\OneToMany(targetEntity=Tessere::class, mappedBy="utente")
     */
    private $tessere;

    /**
     * @ORM\OneToMany(targetEntity=Transazioni::class, mappedBy="operatore")
     */
    private $transazioni;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\ManyToOne(targetEntity=Ruoli::class, inversedBy="utenti")
     * @ORM\JoinColumn(nullable=false, columnDefinition="INT NOT NULL DEFAULT 2")
     */
    private $ruolo;

    /**
     * @ORM\PrePersist
     * @param LifecycleEventArgs $event
     */
    public function onPrePersist(LifecycleEventArgs $event)
    {
        if (empty($this->ruolo)) {
            $this->ruolo = $event->getEntityManager()->getReference('App\Entity\Ruoli', 4);
        }

        if (empty($this->gestore)) {
            $this->gestore = $event->getEntityManager()->getReference('App\Entity\Utenti', 1);
        }
    }

    public function __construct()
    {
        $this->tessere = new ArrayCollection();
        $this->transazioni = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGestore(): self
    {
        return $this->gestore;
    }

    public function setGestore(self $gestore): self
    {
        $this->gestore = $gestore;

        return $this;
    }

    public function getUtenti(): ?self
    {
        return $this->utenti;
    }

    public function setUtenti(self $utenti): self
    {
        // set the owning side of the relation if necessary
        if ($utenti->getGestore() !== $this) {
            $utenti->setGestore($this);
        }

        $this->utenti = $utenti;

        return $this;
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
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return array('ROLE_USER');
        //return $this->ruolo->toArray();
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

}
