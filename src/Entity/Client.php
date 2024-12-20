<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name: "clients")]
#[UniqueEntity('telephone', message: 'Ce numéro existe déjà')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 50)]
    #[Assert\NotBlank(
        message : 'Veuillez saisir un nom valable',
    )]
    private ?string $nom = null;

    #[ORM\Column(type: "string", length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(type: "string", length: 15)]
    private ?string $telephone = null;

    #[ORM\Column(type: "string", length: 60)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $create_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $update_at = null;

    #[ORM\Column]
    private ?bool $is_blocked = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'client', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\OneToMany(targetEntity: Dette::class, mappedBy: 'client', orphanRemoval: true)]
    private Collection $dettes;

    public function __construct() {
        $this->create_at = new \DateTimeImmutable();
        $this->update_at = new \DateTimeImmutable();
        $this->dettes = new ArrayCollection;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeImmutable $create_at): static
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeImmutable $update_at): static
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function isBlocked(): ?bool
    {
        return $this->is_blocked;
    }

    public function setBlocked(bool $is_blocked): static
    {
        $this->is_blocked = $is_blocked;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
