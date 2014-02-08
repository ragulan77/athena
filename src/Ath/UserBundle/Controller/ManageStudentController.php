<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ath\UserBundle\Entity\Classe;

class ManageStudentController extends Controller
{
    public function deleteAction(Request $request)
    {
    	$listeIdEtudiants = $request->request->all();

    	foreach ($listeIdEtudiants as $id){
    		$em = $this->getDoctrine()->getManager();
    		//get all student by classe
    		$etudiant = $em->getRepository('AthUserBundle:Student')->findOneById($id);
            $etudiant->setClasse(null);
    		$em->persist($etudiant);
            $em->flush();
    	}

        if($listeIdEtudiants != null){
        	$this->get('session')->getFlashBag()->add(
        			'notice',
        			'Etudiants enlevés de la classe avec succès !'
        	);
        }

    	return new RedirectResponse($request->headers->get('referer'));
    }

    /*
        ajouter une liste d'étudiants (via leur ID) à une classe
    */
    public function addStudentsInClassAction(Classe $classe)
    {
        $request = $this->get('request');
        $students_ids = $request->request->get('students_ids');
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AthUserBundle:Student');

        foreach ($students_ids as $id) {
            $student = $repo->findOneById($id);
            if($student != null){
                $student->setClasse($classe);
                $em->persist($student);
            }
        }
        $em->flush();

        return new RedirectResponse($request->headers->get('referer'));
    }
}
