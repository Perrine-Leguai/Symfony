<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="homepage")
     */
    public function index(): Response
    {
        $prenoms= ["Lior"=>31, "Perrine"=> 28];
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'prenoms' => $prenoms,
        ]);
    }

    /**
     * Montre la b=page qui dit bonjour
     * @Route("/hello/{prenom}/{age}", name="helloPrenomAge", requirements={"age"="\d+"})
     * @Route("/hello", name="hello")
     * 
     * @return void
     */
    public function hello($prenom= "anonyme", $age="0"){
        return new Response("Bonjour " . $prenom . " tu as ". $age . " ans. ");
    }
}
