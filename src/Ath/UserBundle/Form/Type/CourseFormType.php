<?php

namespace Ath\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType as BaseType;

class CourseFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        // add your custom field
        $builder->add('name');
       // $builder->add('discipline');//a cacher
        $builder->add(
        		'discipline',
        		null,
        		array( 
        				'attr'=>array(
        						'style'=>'display:none;'
        				),
        				'label' => false
        		) 
        );
        $builder->add('file');
    }

    public function getName()
    {
        return 'ath_course_registration';
    }
}
