<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;
use App\Repository\ProduitRepository;



class CoucouController extends AbstractController
{
    /**
     * @Route("/index", name="coucou_coucou")
     */
    public function index(): Response{
        return $this->render('coucou/index.html.twig', [  //réponse http, ce que reçoit le html.twig
            'controller_name' => 'CoucouController',        //relation clef variable
        ]);
    }

    /**
     * @Route("/add", name="add_coucou" )
     */
    public function add(Request $requete, EntityManagerInterface $manager) {   //affichera le formulaire d'ajout
        dump($requete); //permet de faire le test sans le faire apparaitre sur la page --> dans le profiler                  
        if($requete->request->count()>0){
            $produit = new Produit();
            $produit->setNomProduit($requete->request->get('nomProduit'))
                    ->setPrix($requete->request->get('prix'))
                    ->setLargeur($requete->request->get('largeur'))
                    ->setProfondeur($requete->request->get('profondeur'))
                    ->setHauteur($requete->request->get('hauteur'));

            $manager->persist($produit); //garanti que ça tiendra sur la longueur
        }
        $manager->flush(); // pour les valider en base de données
        return $this->render('coucou/add.html.twig', [  //réponse http, ce que reçoit le html.twig
            'controller_name' => 'addController',        //relation clef variable
        ]);
    }

    /**
     * @Route("/update/{no}", name="update_coucou", requirements={"no":"\d+"})
     */
    public function update(int $no): Response{
        return $this->render('coucou/update.html.twig', [  //réponse http, ce que reçoit le html.twig
            'controller_name' => 'updateController',        //relation clef variable
        ]); 
    }

    /**
     * @Route("/delete", name="delete_coucou")
     */
    public function delete(): Response{
        return $this->render('coucou/delete.html.twig', [  //réponse http, ce que reçoit le html.twig
            'controller_name' => 'deleteController',        //relation clef variable
        ]); 
    }

    /**
     * @Route("/research", name="research_coucou")
     */
    public function research(ProduitRepository $repository) {
        
        // $repository= $this->getDoctrine()->getRepository(Produit::class);
        $produits=$repository->findAll();
        
        return $this->render('coucou/research.html.twig', [  //réponse http, ce que reçoit le html.twig
            'controller_name' => 'researchController',       //relation clef variable
            "produits" => $produits,      //peut déclarer produits ici à la place $produits, on mets le tableau directement après =>      
            
        ]); 
    }
}
