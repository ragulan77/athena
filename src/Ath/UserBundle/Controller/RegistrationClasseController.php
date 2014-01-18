<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\UserBundle\Entity\Classe;
use Symfony\Component\HttpFoundation\Request;
use Ath\UserBundle\Form\Type\RegistrationStudentFormType;
use Ath\UserBundle\Form\Type\RegistrationProfessorFormType;
use Ath\UserBundle\Form\Type\DisciplineFormType;
use Ath\UserBundle\Entity\Student;
use Ath\CoursBundle\Entity\Discipline;
use Ath\UserBundle\Entity\Professor;

class RegistrationClasseController extends Controller
{
    public function registerAction(Request $request)
    {
    	$newClasse = new Classe();
    	
    	$form = $this->createFormBuilder($newClasse)
    	->add('name')
    	->getForm();
    	 
    	$form->handleRequest($request);
    	$em = $this->getDoctrine()->getManager();
    	 
    	//get all course by discipline pour downloader
    	$listeClasse = $em->getRepository('AthUserBundle:Classe')->findAll();
    	 
    	//si formulaire d'ajout de cours validé
    	if ($form->isValid()) {
    		$em->persist($newClasse);
    		$em->flush();
    	
    		$this->get('session')->getFlashBag()->add(
    				'notice',
    				'Création de la classe réalisée avec succès !'
    		);
    		 
    		return $this->redirect($this->generateUrl('ath_classe_add',array('listeClasse' =>$listeClasse, 'form' => $form->createView())));
    	}
    	 
    	return $this->render('AthUserBundle:Registration:classe.form.html.twig',array('listeClasse' =>$listeClasse, 'form' => $form->createView()));
    }
    
    public function deleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	//get classe by id pour supprimer
    	$classe = $em->getRepository('AthUserBundle:Classe')->findOneById($id);
    	$em->remove($classe);
    	$em->flush();
    	 
    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'Suppression de la classe réalisé avec succès !'
    	);
    	
    	return $this->redirect($this->generateUrl('ath_classe_add'));
    }
    
    public function editAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	
    	//get classe by id pour rechercher les matieres et les eleves
    	$classe = $em->getRepository('AthUserBundle:Classe')->findOneById($id);
    	
    	//get all student by classe
    	$listeEtudiants = $em->getRepository('AthUserBundle:Student')->findBy(array( "classe" => $classe));
    	
    	//get all discipline by classe
    	$listeMatieres = $em->getRepository('AthCoursBundle:Discipline')->getDisciplinesByClasseId($classe->getId());
	
    	$listeProfesseurs = $em->getRepository('AthUserBundle:Professor')->getProfessorsByClasseId($classe->getId());
    	
    	$student = new Student();
    	$student->setClasse($classe);
    	$formStudent = $this->createForm(new RegistrationStudentFormType('Ath\UserBundle\Entity\Student'), $student);
    	
    	$discipline = new Discipline();
    	$discipline->addClasse($classe);
    	$formDiscipline = $this->createForm(new DisciplineFormType('Ath\CoursBundle\Entity\Discipline'), $discipline);
    	
    	$professor = new Professor();
    	$professor->addClasse($classe);
    	$formProfessor = $this->createForm(new RegistrationProfessorFormType('Ath\UserBundle\Entity\Professor'), $professor);
    	
    	
    	
    	return 
    	$this->render(
    			'AthUserBundle:Registration:classe.edit.html.twig',
    			array(
    					'listeEtudiants' =>$listeEtudiants, 
    					'classe' => $classe,
    					'listeMatieres' =>$listeMatieres,
    					'listeProfesseurs' =>$listeProfesseurs,
    					'formStudent' => $formStudent->createView(),
    					'formProfessor' => $formProfessor->createView(),
    					'formDiscipline' => $formDiscipline->createView()
    			)
    	);
    }
}
