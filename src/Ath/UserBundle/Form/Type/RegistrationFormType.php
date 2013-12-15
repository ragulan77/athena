<?php

namespace Ath\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('username');
        $builder->add('firstname');
        $builder->add('lastname');
        $builder->add('birthdate');
        $builder->add('address');
        $builder->add('zipcode');
        $builder->add('city');
        $builder->add('phone');
    }

    public function getName()
    {
        return 'ath_user_registration';
    }
}
