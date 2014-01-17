<?php

namespace Ath\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType as BaseType;

class ClasseFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        // add your custom field
        $builder->add('name');
    }

    public function getName()
    {
        return 'ath_classe_registration';
    }
}
