<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setRef('REF' . str_pad($i, 3, '0', STR_PAD_LEFT))
                    ->setLibelle('Article ' . $i)
                    ->setQteStock(10 * $i)
                    ->setPrixUnitaire(5 * $i);
                    
            $manager->persist($article);
        }

        $manager->flush();
    }
}
