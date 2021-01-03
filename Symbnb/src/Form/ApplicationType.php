<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType{
    /**
     * Permet d'avoir la configuration de basse d'un champ, sera utilisée dans la fonction builForm
     *
     * @param [string] $label
     * @param [string] $placeholder
     * @param [array] $options
     * @return array
     */
    protected function getConfig($label, $placeholder, $options=[]){
        return array_merge([
            'label' => $label,
            'attr'  => [
                'placeholder' => $placeholder
            ]
        ], $options);
    }
}


?>