<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\{TextType, TextareaType, FileType};
use Symfony\Component\Validator\Constraints\{Image, File};

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $form = $builder
            ->add('title', TextType::class, array(
                'attr' => array('class' => 'form-control md-3')
            ))

            ->add('file', FileType::class, array(
                'required' => false,
                'data_class'=>null,
                


                'attr' => array('class' => 'form-control')
            ))

            ->getForm();
    }
}
