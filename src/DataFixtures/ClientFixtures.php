<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $client = new Client();
            $client->setPrenom('Prenom' . $i)
                   ->setNom('Nom' . $i)
                   ->setTelephone('77000000' . $i)
                   ->setAdresse('Adresse ' . $i) 
                   ->setCreateAt(new \DateTimeImmutable())
                   ->setUpdateAt(new \DateTimeImmutable())
                   ->setBlocked($i % 2 === 0);
            // if ($i % 2 === 0) {
            //     $user = new User();
            //     $user->setEmail('email' . $i . '@gamail.com')
            //          ->setPassword('password' . $i);
            //     $client->setUser($user);
            //     $manager->persist($user);
            // }
            $manager->persist($client);
        }
        $manager->flush();
    }
}
