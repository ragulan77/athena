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
		$form = $this->createForm(new DisciplineFormType('Ath\UserBundle\Entity\Discipline'),$discipline);
		$form->handleRequest($request);
		
		if($form->isValid($request)){
			//$em = $this->getDoctrine()->getManager();
			//$em->persist($discipline);
			//$em->flush();
			
			$this->get('session')->getFlashBag()->add(
					'notice',
					'Ajout réalisé '.$discipline->getName().' avec succès !'
			);
			
			//return new RedirectResponse($request->headers->get('referer'));
			$n = $discipline->getClasses();
			
			return
			$this->render(
					'AthUserBundle:Registration:test.edit.html.twig',
					array(
							'liste' =>$n
					)
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
    		$discipline = $em->getRepository('AthUserBundle:Discipline')->findOneById($id);
    		$em->remove($discipline);
    		$em->flush();
    	}
    	
    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'Suppression réalisé avec succès !'
    	);
    	
    	return new RedirectResponse($request->headers->get('referer'));
    }
}
