<?php
namespace AppBundle\Form;

use AppBundle\Entity\OrdersAllInOne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use AppBundle\Form\OrdersAllInOneType;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('delivery',ChoiceType::class,array(
            'label' => ' ',
            'choices'  => array(
                'Not yet sent' => 'Not yet sent',
                'Send' => 'Sent',
                'Decline' => 'Declined',
            ),
        ))
            ->add('save',SubmitType::class,array(
                'label' => 'Create',
                'attr' => array('style' => 'width: 100px')
            ))
        ;

        $builder->add('category', OrdersAllInOne::class);
    }

}

