<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Produit;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=1; $i <=10; $i++){
                $produit = new Produit();
                $produit->setNomProduit("Produit $i")
                        ->setPrix($i*5)
                        ->setLargeur(15+ (5*$i))
                        ->setProfondeur(15+ (5*$i))
                        ->setHauteur(15+ (5*$i));
                $manager->persist($produit);        

        }
        $manager->flush();    //ne rentre dans la bdd que si on met flush
    }
}
