<?php

namespace Ath\CoursBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType as BaseType;

class LevelFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        // add your custom field
        $builder->add('name');
        $builder->add('disciplines', 'entity', array(
                      'class' => 'AthCoursBundle:Discipline',
                      'property' => 'name',
                      'multiple' => true
                      )
        );
    }

    public function getName()
    {
        return 'ath_cours_level_form_type';
    }
}
