<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends ApplicationType
{

    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfig('Titre', 'Titre de votre annonce') )
            ->add('slug', TextType::class, $this->getConfig('Chaine URL', "Adresse web (facultatif). Ex: titre-de-l-annonce"))
            ->add('coverImage', UrlType::class, $this->getConfig("URL de l'image", "Saisissez l'adresse de l'image") )
            ->add('introduction', TextType::class, $this->getConfig("Introduction", 'Description rapide de l\'annonce'))
            ->add('content', TextareaType::class, $this->getConfig("Descripion complète", "Saisissez une description complète de votre logement. + de détails = + de clics"))
            ->add('chambres', IntegerType::class, $this->getConfig('Nombre de chambres', 'Saisissez le nombre de chambres disponibles'))
            ->add('prix', MoneyType :: class, $this->getConfig('Prix par nuit', 'Indiquez le prix que vous souhaitez par nuit'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}

// ->add("title")
//                     ->add("introduction")
//                     ->add('content')
//                     ->add('chambres')
//                     ->add('coverImage')
//                     ->add('prix')
//                     ->add('save', SubmitType::class, [
//                             'label'=> "+ Ajouter l'annonce",
//                             'attr' => [
//                                 'class' => 'btn btn-primary'
//                             ]
//                    ] ) si on utilise un formulaire form en twig
//                  ->getForm();  gère la validité, si il a été soumis ou non ...
