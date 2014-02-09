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
        $em = $this->getDoctrine()->getManager();
    	$listIdProfessor = $request->request->get('listProfesseur');

        $classe = $em->getRepository('AthUserBundle:Classe')->findOneById($request->request->get('classe'));

        if($listIdProfessor != null)
        {
            foreach ($listIdProfessor as $id){
                $professor = $em->getRepository('AthUserBundle:Professor')->findOneById($id);
        		//get all teaching
        		$teaching = $em->getRepository('AthCoursBundle:Teaching')->findOneBy(array('professor' => $professor, 'classe' => $classe));
                $professor->removeClasse($classe);

        		$em->remove($teaching);
                $em->persist($professor);
        		$em->flush();
        	}

        	$this->get('session')->getFlashBag()->add(
        			'noticeProfessor',
        			'Suppression réalisé avec succès !'
        	);
        }

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
