<?php

namespace App\Entity;

use App\Repository\DetailsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailsRepository::class)]
class Details
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Dette::class, inversedBy: 'details')]
    private ?string $dette = null;

    #[ORM\ManyToOne(targetEntity: Article::class)]
    private ?string $article = null;

    #[ORM\Column(type: 'integer')]
    private ?int $qte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getDette(): ?string
    {
        return $this->dette;
    }

    public function setDette(string $dette): static
    {
        $this->dette = $dette;

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

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): static
    {
        $this->qte = $qte;

        return $this;
    }
}
