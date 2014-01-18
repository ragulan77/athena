<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ManageProfessorController extends Controller
{
    public function deleteAction(Request $request)
    {
    	$listeIdProfessor = $request->request->all();
    	
    	foreach ($listeIdProfessor as $id){
    		$em = $this->getDoctrine()->getManager();
    		//get all professor by classe
    		$professor = $em->getRepository('AthUserBundle:Professor')->findOneById($id);
    		$em->remove($professor);
    		$em->flush();
    	}
    	
    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'Suppression réalisé avec succès !'
    	);
    	
    	return new RedirectResponse($request->headers->get('referer'));
    }
}
