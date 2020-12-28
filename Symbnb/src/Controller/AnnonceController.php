<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonces", name="annonces_index") //liste des annonces
     */
    public function index(AnnonceRepository $repo): Response
    {
        $annonces= $repo->findAll();
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    //symfony comprend directement que le $ad demandé dans show est l'annonce qui a le slug passé en url
    //paramconverter
    /**
     * Permet d'afficher une seule annonce
     * @Route("/annonces/{slug}", name="annonces_show")
     */
    public function show(Annonce $ad ) : Response { //AnnonceRepository $repo
        // $ad= $repo->findOneBySlug($slug); //récup de l'annonce qui correspond au slug
        return $this->render('annonce/show.html.twig',[
            'ad' => $ad,
        ]);
    }
}
