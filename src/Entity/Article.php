<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'articles')]
#[UniqueEntity('libelle', message: 'Cet article existe déjà')]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string',length: 20)]
    private ?string $ref = null;

    #[ORM\Column(type: 'string',length: 50)]
    private ?string $libelle = null;

    #[ORM\Column(type: 'integer')]
    private ?int $qte_stock = null;

    #[ORM\Column(type: 'integer')]
    private ?int $prix_unitaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): static
    {
        $this->ref = $ref;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getQteStock(): ?int
    {
        return $this->qte_stock;
    }

    public function setQteStock(int $qte_stock): static
    {
        $this->qte_stock = $qte_stock;

        return $this;
    }

    public function getPrixUnitaire(): ?int
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(int $prix_unitaire): static
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }
}
