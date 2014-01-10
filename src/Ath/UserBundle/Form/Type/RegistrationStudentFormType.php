<?php

namespace Ath\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Ath\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationStudentFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('classe');
    }

    public function getName()
    {
        return 'fos_student_registration';
    }
}
