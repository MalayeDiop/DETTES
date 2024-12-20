<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@gmail.com')
                 ->setPassword('password' . $i)
                 ->setBlocked($i % 3 === 0)
                 ->setCreateAt(new \DateTimeImmutable())
                 ->setUpdateAt(new \DateTimeImmutable());
            // $client = new Client();
            // $client->setPrenom('Prenom' . $i) // Prénom basé sur l'index
            //        ->setNom('Nom' . $i) // Nom basé sur l'index
            //        ->setTelephone('77000000' . $i) 
            //        ->setAdresse('Adresse ' . $i)
            //        ->setCreateAt(new \DateTimeImmutable())
            //        ->setUpdateAt(new \DateTimeImmutable())
            //        ->setBlocked($i % 2 === 0) // Blocké si divisible par 2
            //        ->setUser($user);
            $manager->persist($user);
            // $manager->persist($client);
        }
                $manager->flush();
    }
}
