<?php

namespace Ath\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType as BaseType;

class DisciplineFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        // add your custom field
        $builder->add('name');
        $builder->add('classes');
    }

    public function getName()
    {
        return 'ath_discipline_registration';
    }
}
