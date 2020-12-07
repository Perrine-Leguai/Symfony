<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
//METHODE 2
// use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\NumberType;
// use Symfony\Component\Form\Extension\Core\Type\MoneyType;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;
use App\Form\ProduitType;
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
     * @Route("{no}/edit", name="edit_coucou", requirements={"no":"\d+"})
     */
    public function formulaire(Produit $produit=null, Request $request, EntityManagerInterface $manager) :Response {   //affichera le formulaire d'ajout  Request $requete, EntityManagerInterface $manager
        // dump($requete); //permet de faire le test sans le faire apparaitre sur la page --> dans le profiler    
        if(!$produit){
            $produit = new Produit();
        }
        
        
        $form= $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // $produit=$form->getData(); pas obligatoire car request les a deja
        
        //METHODE 2 
        //$form = $this->createFormBuilder($produit)
        //             ->add('nomProduit', TextType :: class, ['label'=> 'Nom du produit : ',
        //                                                     "attr" => [ 'placeholder' => 'blablba']])
        //             ->add('prix', MoneyType::class)
        //             ->add('largeur', NumberType::class)
        //             ->add('profondeur', NumberType ::class)
        //             ->add('hauteur',NumberType::class)
        //             ->add('save', SubmitType :: class, ['label'=> 'ajouter un produit'])
        //             ->getForm();
        //METHODE 1
        // if($requete->request->count()>0){
        //     $produit = new Produit();
        //     $produit->setNomProduit($requete->request->get('nomProduit'))
        //             ->setPrix($requete->request->get('prix'))
        //             ->setLargeur($requete->request->get('largeur'))
        //             ->setProfondeur($requete->request->get('profondeur'))
        //             ->setHauteur($requete->request->get('hauteur'));

        // $manager= $this->getDoctrine()->getManager();   revient au mm que mettre dans la fonction $manager
        $manager->persist($produit); //garanti que ça tiendra sur la longueur
        // }
        $manager->flush(); // pour les valider en base de données
        return $this->redirectToRoute('research_coucou', ['no' => $article->getId()]);
        }
        return $this->render('coucou/add.html.twig', [  //réponse http, ce que reçoit le html.twig
            'controller_name' => 'addController',        //relation clef variable
            // 'form'=> $form->createView(ProduitType::class, $produit), //voir la suite dans le twig
            'form' => $form->createView(),
            'editMode' => $produit->getId()!== null,  //booléen qui va permettre de gérer l'affichage du bouton en twig
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
