<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ManageDisciplineController extends Controller
{
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
