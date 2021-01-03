<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AnnonceType extends ApplicationType
{

    

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfig('Titre', 'Titre de votre annonce') )
            ->add('slug', TextType::class, $this->getConfig('Chaine URL', "Adresse web (facultatif). Ex: titre-de-l-annonce"), [
                'required'  => false
            ])
            ->add('coverImage', UrlType::class, $this->getConfig("URL de l'image", "Saisissez l'adresse de l'image") )
            ->add('introduction', TextType::class, $this->getConfig("Introduction", 'Description rapide de l\'annonce'))
            ->add('content', TextareaType::class, $this->getConfig("Descripion complète", "Saisissez une description complète de votre logement. + de détails = + de clics"))
            ->add('chambres', IntegerType::class, $this->getConfig('Nombre de chambres', 'Saisissez le nombre de chambres disponibles'))
            ->add('prix', MoneyType :: class, $this->getConfig('Prix par nuit', 'Indiquez le prix que vous souhaitez par nuit'))
            //champ de type collection pour la gestion des images
            ->add('images', CollectionType::class, [
                'entry_type' => ImageType::class,
                'allow_add' => true,     //dans cette collection, on peut ajouter de nouveaux éléments
                'allow_delete' =>true   //autorise la suppression d'image 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}

