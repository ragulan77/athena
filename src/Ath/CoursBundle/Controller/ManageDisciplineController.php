<?php

namespace Ath\CoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ath\CoursBundle\Entity\Discipline;
use Ath\UserBundle\Form\Type\DisciplineFormType;

class ManageDisciplineController extends Controller
{
	public function addAction(Request $request)
	{
		$discipline = new Discipline();
		$form = $this->createForm(new DisciplineFormType('Ath\CoursBundle\Entity\Discipline'),$discipline);
		$form->handleRequest($request);
		
		if($form->isValid($request)){
			$em = $this->getDoctrine()->getManager();
			$em->persist($discipline);
			$em->flush();
			
			$this->get('session')->getFlashBag()->add(
					'noticeDiscipline',
					'Ajout réalisé avec succès !'
			);
			
		}
		
		return new RedirectResponse($request->headers->get('referer'));
	}
	
    public function deleteAction(Request $request)
    {
    	$listeIdDiscipline = $request->request->all();
    	
    	foreach ($listeIdDiscipline as $id){
    		$em = $this->getDoctrine()->getManager();
    		//get all discipline by classe
    		$discipline = $em->getRepository('AthCoursBundle:Discipline')->findOneById($id);
    		$em->remove($discipline);
    		$em->flush();
    	}
    	
    	$this->get('session')->getFlashBag()->add(
    			'noticeDiscipline',
    			'Suppression réalisé avec succès !'
    	);
    	
    	return new RedirectResponse($request->headers->get('referer'));
    }
}
