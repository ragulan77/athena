<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\UserBundle\Entity\Classe;
use Symfony\Component\HttpFoundation\Request;
use Ath\UserBundle\Form\Type\RegistrationStudentFormType;
use Ath\UserBundle\Entity\Student;

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
	
    	$listeProfesseurs = $em->getRepository('AthUserBundle:Profesor')->getProfessorsByClasseId($classe->getId());
    	
    	$student = new Student();
    	$form = $this->createForm(new RegistrationStudentFormType('Ath\UserBundle\Entity\Student'), $student);
    	
    	return 
    	$this->render(
    			'AthUserBundle:Registration:classe.edit.html.twig',
    			array(
    					'listeEtudiants' =>$listeEtudiants, 
    					'classe' => $classe,
    					'listeMatieres' =>$listeMatieres,
    					'listeProfesseurs' =>$listeProfesseurs,
    					'form' => $form->createView()
    			)
    	);
    }
}
