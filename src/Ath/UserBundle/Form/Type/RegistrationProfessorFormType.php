<?php

namespace Ath\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Ath\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationProfessorFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('matieres');
    }

    public function getName()
    {
        return 'fos_professor_registration_form';
    }
}
