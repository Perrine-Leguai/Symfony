<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Image;
use App\Entity\Annonce;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('FR-fr');
        
        for($i=1;$i<=30;$i++){    
            $k=$i*3-1;
            $ad= new Annonce();
            $title=$faker->sentence(5);
            $ad ->setTitle($title)
                ->setPrix(mt_rand(40,250))
                ->setIntroduction($faker->paragraph(2))
                ->setContent('<p>' . join('</p><p>', $faker->paragraphs(5)).'</p>' )
                ->setCoverImage("https://picsum.photos/1000/350?random=$i")
                ->setChambres(mt_rand(1,5));
            $manager->persist($ad);

            for($j=1; $j<=mt_rand(2,5); $j++){
                $image= new Image();
                $image->setUrl("https://picsum.photos/1000/350?random=$k")
                    ->setCaption($faker->sentence())
                    ->setAnnonce($ad);
                $manager->persist($image);
            }
        }
        $manager->flush();
    }
}
