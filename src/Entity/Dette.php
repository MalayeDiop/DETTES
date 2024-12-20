<?php

namespace App\Entity;

use App\Repository\DetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetteRepository::class)]
#[ORM\Table(name: "dettes")]
class Dette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column]
    private ?int $montant_verse = null;

    #[ORM\Column(nullable: true)]
    private ?int $montant_restant = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $create_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $update_at = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'dettes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?string $client = null;

    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'dettes')]
    #[ORM\JoinColumn(name: "details")]
    private ?string $article = null;

    #[ORM\OneToMany(mappedBy: 'dette', targetEntity: Details::class, cascade: ['persist'])]
    #[ORM\Column(length: 255)]
    private ?string $details = null;

    public function __construct() {
        $this->createat = new \DateTimeImmutable();
        $this->updateat = new \DateTimeImmutable();
        $this->articles = new ArrayCollection();
        $this->details = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMontantVerse(): ?int
    {
        return $this->montant_verse;
    }

    public function setMontantVerse(int $montant_verse): static
    {
        $this->montant_verse = $montant_verse;

        return $this;
    }

    public function getMontantRestant(): ?int
    {
        return $this->montant_restant;
    }

    public function setMontantRestant(?int $montant_restant): static
    {
        $this->montant_restant = $montant_restant;

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

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(string $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }
}
