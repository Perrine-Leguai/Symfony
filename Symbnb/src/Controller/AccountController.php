<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\UpdatePasswordType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $this->addFlash('success', "Bienvenu.e ". $this->getUser()->getUsername() . ", on espère que vous trouverez votre bonheur !");
            return $this->render('home/index.html.twig');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        dump($error);
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * permet de se déconnecter
     * 
     * @Route("/logout", name="account_logout")
     */
    public function logout() : void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Permet d'afficher le formulaire d'inscription
     * @Route("/inscription", name="account_inscription")
     *
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) : Response{
        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash=$encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'succes', 
                'Vous êtes désormais inscrit.e sur le site. </br> Ne reste plus qu\'a trouver chaussure à votre pied'
            );
            return $this->redirectToRoute('app_login');
        }
        
        return $this->render('security/registration.html.twig',[
            'formInscription'   =>$form->createView()
        ]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de modifiacation de profil
     *
     * @Route("/account/profile", name="account_profile")
     * @return Response
     */
    public function profile(Request $request, EntityManagerInterface $manager ){
        $user= $this->getUser();
        $form=$this->createForm(AccountType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user); //pas nécessaire car user est déjà persisté dans la bdd
            $manager->flush();

            $this->addFlash(
                'success',
                'vos données sont bien à jour !'
            );

        }
        return $this->render('account/profile.html.twig', [
            'formulaireModification' => $form->createView()
        ]);
    }

    /**
         * @Route("account/updatePassword", name="account_updatePassword")
         *
         */
        public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager) : Response {
            $passwordUpdate= new PasswordUpdate();
            $user=$this->getUser(); //on a l'utilisateur
            $form= $this->createForm(UpdatePasswordType::class, $passwordUpdate);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                //1) vérif que le olp mdp = mdp enregistré en bdd
                if(!password_verify($passwordUpdate->getOldPwd(),$user->getPassword())){
                    //on peut utiliser un addFLash erreur avec retour sur la mm page
                    $form->get('oldPwd')->addError(new FormError("Le mdp n'est pas votre mdp actuel"));
                
                }else{ //2) enregistrer le nouveau mdp
                    $newPwd = $passwordUpdate->getNewPwd();
                    $hash= $encoder->encodePassword($user, $newPwd);

                    $user->setPassword($hash);

                    $manager->persist($user);
                    $manager->flush(); 

                    $this->addFlash(
                        'success',
                        'Votre mot de passe a bien été modifié !'
                    );

                    return $this->redirectToRoute('homepage');
                }
                //2) enregistrer le nouveau mdp
            }


            return $this->render('security/updatePassword.html.twig', [
                'modificationPwd'   =>$form->createView()
            ]);
        }
}
