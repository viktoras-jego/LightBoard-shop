<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkateboardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,array('attr' => ['readonly' => true],))

            ->add('category',ChoiceType::class, array(
                'label' => 'Category',
                'choices' => array(
                    'Pennyboard' => 'Pennyboard',
                    'Skateboard' => 'Skateboard',
                    'Longboard' => 'Longboard',
                )
            ))
            ->add('price',MoneyType::class, array(
                'label' => ' ',
            ))
            ->add('description',TextareaType::class,array(
                'label' => 'Description',
                'attr' => array('style' => 'width: 100px;',
                    'style' => 'height: 75px'
                ),
                'required'    => false,
            ))

            ->add('save',SubmitType::class,array(
                'label' => 'Create',
                'attr' => array('style' => 'width: 100px')
            ))

            ->getForm()
        ;

    }


}
