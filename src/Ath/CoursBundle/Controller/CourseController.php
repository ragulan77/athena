<?php

namespace Ath\CoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\CoursBundle\Entity\Course;
use Ath\CoursBundle\Entity\Discipline;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Ath;

class CourseController extends Controller
{
    
    //rajouter en parametre l id de la matiere
    public function ajouterAction(Request $request)
    {
    	//get discipline by id
    	$discipline= $this->getDoctrine()->getRepository('AthCoursBundle:Discipline')->find('1');
    	$newCourse = new Course();
    	$newCourse->setDiscipline($discipline);
    	
    	$form = $this->createFormBuilder($newCourse)
    	->add('name')
    	->add('file')
    	->getForm();
    	
    	$form->handleRequest($request);
    	$em = $this->getDoctrine()->getManager();
    	
    	//get all course by discipline pour downloader
    	$listeCours = $em->getRepository('AthCoursBundle:Course')->findByDiscipline($discipline);
    	
    	//si formulaire d'ajout de cours validé
    	if ($form->isValid()) {
    		$em->persist($newCourse);
    		$em->flush();
    		
    		$this->get('session')->getFlashBag()->add(
    				'notice',
    				'Ajout du cours réalisé avec succès !'
    		);
    		 
    		return $this->redirect(
    				$this->generateUrl(
    						'ath_cours_add',
    						array(
    								'listeCours' =>$listeCours, 
    								'form' => $form->createView()
    						)
    				)
    		);
    	}

    	return $this->render(
    			'AthCoursBundle:Cours:upload.html.twig',
    			array(
    					'listeCours' =>$listeCours, 
    					'form' => $form->createView()
    			)
    	);
    }
    
    public function supprimerAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	 
    	//get course by id pour supprimer
    	$course = $em->getRepository('AthCoursBundle:Course')->findOneById($id);
    	$em->remove($course);
    	$em->flush();
    	
    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'Suppression du cours réalisé avec succès !'
    	);
    	 
    	return $this->redirect($this->generateUrl('ath_cours_add'));
    }
}
