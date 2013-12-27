<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ManageStudentController extends Controller
{
    public function deleteAction(Request $request)
    {
    	$listeIdEtudiants = $request->request->all();
    	
    	foreach ($listeIdEtudiants as $id){
    		$em = $this->getDoctrine()->getManager();
    		//get all student by classe
    		$etudiant = $em->getRepository('AthUserBundle:Student')->findOneById($id);
    		$em->remove($etudiant);
    		$em->flush();
    	}
    	
    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'Suppression réalisé avec succès !'
    	);
    	
    	return new RedirectResponse($request->headers->get('referer'));
    }
}
