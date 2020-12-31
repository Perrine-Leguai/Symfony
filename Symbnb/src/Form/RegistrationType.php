<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, $this->getConfig('Pseudo', 'Ex: Babach59'))
            ->add('password', PasswordType::class, $this->getConfig('Mot de passe', 'Saisir un mdp secret'))
            ->add('passwordConfirm', PasswordType ::class, $this->getConfig('Confirmation du mot de passe', 'Veuillez confirmer votre mot de passe'))
            ->add('firstName', TextType::class, $this->getConfig('Prénom', "Ex : Angèle"))
            ->add('lastName', TextType::class, $this->getConfig('Nom de famille', "Ex : Sappori"))
            ->add('email', EmailType::class, $this->getConfig('Email', "Ex : angele.59@gmail.com"))
            ->add('picture', UrlType::class, $this->getConfig('Avatar', 'Veillez saisir un url de votre image'))
            ->add('introduction', TextType::class, $this->getConfig('Introduction', 'Ex : Mon intro de zinzin...'))
            ->add('description', TextareaType::class, $this->getConfig('Description', 'Ex : La description en détail de mon logement ...'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
