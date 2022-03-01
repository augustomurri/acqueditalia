<?php

namespace App\Entity;

use App\Repository\RuoliRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;

/**
 * @ORM\Entity(repositoryClass=RuoliRepository::class)
 */
class Ruoli extends Role
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
    private $nome;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $ruolo;

    /**
     * @ORM\OneToMany(targetEntity=Utenti::class, mappedBy="ruolo")
     */
    private $utenti;

    public function __construct()
    {
        $this->utenti = new ArrayCollection();
    }

    public function getId(): ?int
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
     * @see RoleInterface
     */
    public function getRole()
    {
        return $this->ruolo;
    }

    public function getRuolo(): ?string
    {
        return $this->ruolo;
    }

    public function setRuolo(string $ruolo): self
    {
        $this->ruolo = $ruolo;

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
            $utenti->setRuolo($this);
        }

        return $this;
    }

    public function removeUtenti(Utenti $utenti): self
    {
        if ($this->utenti->removeElement($utenti)) {
            // set the owning side to null (unless already changed)
            if ($utenti->getRuolo() === $this) {
                $utenti->setRuolo(null);
            }
        }

        return $this;
    }
}
