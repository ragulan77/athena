<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ath\UserBundle\Entity\Professor;

class ManageProfessorController extends Controller
{
    public function deleteAction(Request $request)
    {
    	$listeIdProfessor = $request->request->all();
    	$professor = new Professor();
    	foreach ($listeIdProfessor as $id){
    		$em = $this->getDoctrine()->getManager();
    		//get all professor by classe
    		$professor = $em->getRepository('AthUserBundle:Professor')->findOneById($id);
    		$em->remove($professor);
    		$em->flush();
    	}

    	$this->get('session')->getFlashBag()->add(
    			'noticeProfessor',
    			'Suppression réalisé avec succès !'
    	);

    	return new RedirectResponse($request->headers->get('referer'));
    }

    public function addProfessorToClass(Classe $classe, Professor $professor, $discipline)
    {
        $em = $this->getDoctrine()->getManager();
        $discipline = $em->getRepository('AthCoursBundle:Discipline')->findOneByName($discipline);

        $teaching = new Teaching();
        $teaching->setClasse($classe);
        $teaching->setProfessor($professor);
        $teaching->setDiscipline($discipline);

        return new RedirectResponse($request->headers->get('referer'));
    }
}
