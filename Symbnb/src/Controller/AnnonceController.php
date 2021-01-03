<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

    /**
     * Permet de créer une annonce - formulaire
     * @Route("/annonces/new", name="annonces_create")
     */
    public function createAnnonce(Request $request, EntityManagerInterface $manager) : Response{
        $ad=new Annonce();
        $image= new Image();

        $image->setUrl('http://placehold.it/300x200/')
            ->setCaption('titre 1');
        
        $ad->addImage($image);

        $form=$this->createForm(AnnonceType::class, $ad);
        $form->handleRequest($request);  //fait lien entre champ du formulaire et la variable $ad

        if($form->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $image){ //précise que les images appartiennent aux annonces
                $image->setAnnonce($ad);
                $manager->persist($image);
            }
            $user=$this->getUser();
            $ad->setAuthor($user);
            $manager->persist($ad);
            $manager->flush();

            //renvoie un flash d'avertissement pour dire que tout s'est bien passé
            $this->addFlash(
                'success', "Bravo, l'annonce <strong>Test</strong> a bien été enregistrée !"
            );
            
            //redirige une fois l'action réussie
            return $this->redirectToRoute('annonces_show', [
                'slug'  => $ad->getSlug()
            ]);
        }
        return $this->render("annonce/new.html.twig", [
            'formulaire' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher le formulaire de modif 
     *@Route("/annonces/{slug}/modification", name="annonces_modification")
     * @return Response
     */
    public function editAnnonce(Request $request, Annonce $ad, EntityManagerInterface $manager){
        $form=$this->createForm(AnnonceType::class, $ad);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $image){ //précise que les images appartiennent aux annonces
                $image->setAnnonce($ad);
                $manager->persist($image);
            }
            $manager->persist($ad);
            $manager->flush();

            //renvoie un flash d'avertissement pour dire que tout s'est bien passé
            $this->addFlash(
                'success', "Bravo, l'annonce <strong>{$ad->getTitle()}</strong>a bien été modifiée !"
            );
            
            //redirige une fois l'action réussie
            return $this->redirectToRoute('annonces_show', [
                'slug'  => $ad->getSlug()
            ]);
        }

        return $this->render('annonce/modif.html.twig', [
            'formulaire' =>$form->createView(),
            'ad' => $ad
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
