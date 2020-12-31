<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Annonce;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;

    }

    public function load(ObjectManager $manager)
    {
        $faker= Factory::create('FR-fr');

        $users=[];
        $genres= ['male','female'];
        for($u=1; $u<=10; $u++){
            $user= new User();
            $genre=$faker->randomElement($genres);

            $pictureId= mt_rand(0,99).'.jpg';
            $picture= 'https://randomuser.me/api/portraits/' . ($genre== 'male' ? 'men/' : 'women/') . $pictureId;
            
            $user->setUsername($faker->shuffle('username'))
                ->setFirstName($faker->firstname($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(2)).'</p>')
                ->setPicture($picture)
                ->setPassword($this->passwordEncoder->encodePassword($user, $u.$u.$u.$u));
            $manager->persist($user);
            $users[]=$user;
        }
        $manager->flush();

        for($i=1;$i<=30;$i++){    
            $k=$i*3-1;
            $ad= new Annonce();
            $title=$faker->sentence(5);

            $user= $users[mt_rand(0, count($users)-1)];
            $ad ->setTitle($title)
                ->setPrix(mt_rand(40,250))
                ->setIntroduction($faker->paragraph(2))
                ->setContent('<p>' . join('</p><p>', $faker->paragraphs(5)).'</p>' )
                ->setCoverImage("https://picsum.photos/1000/350?random=$i")
                ->setChambres(mt_rand(1,5))
                ->setAuthor($user);
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
