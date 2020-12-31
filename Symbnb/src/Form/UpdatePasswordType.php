<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UpdatePasswordType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPwd', PasswordType::class, $this->getConfig("Mot de passe actuel : ", "Veuillez saisir votre mot de passe actuel"))
            ->add('NewPwd', PasswordType::class, $this->getConfig("Nouveau mot de passe : ", "Veuillez saisir un nouveau mot de passe"))
            ->add('confirmPwd', PasswordType::class, $this->getConfig("Confirmation : ", "Veuillez resaisir votre nouveau mot de passe"))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
