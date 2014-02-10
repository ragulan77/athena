<?php

namespace Ath\NoteBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType as BaseType;

class NoteFormType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        // add your custom field
        $builder->add('intitule');
        $builder->add('note');
        $builder->add('coefficient');
        $builder->add('matiere');
        $builder->add('trimestre','choice', array(
        										'choices' => array(
        														'1' => 'premier',
        														'2' => 'deuxieme',
        														'3' => 'troisieme'
        													),
        										'attr' => array(
    														'style' => 'display:none'
        													),
        										'label' => false
        									)
        );
        $builder->add(
        		'student',
        		null,
        		array(
        				'attr'=>array(
        						'style'=>'display:none;'
        				),
        				'label' => false
        		)
        );
        $builder->add(
        		'matiere',
        		null,
        		array(
        				'attr'=>array(
        						'style'=>'display:none;'
        				),
        				'label' => false
        		)
        );
    }

    public function getName()
    {
        return 'ath_note_registration';
    }
}
