<?php

namespace Ath\CoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\UserBundle\Entity\Professor;
use Ath\CoursBundle\Entity\Discipline;
use Ath\CoursBundle\Entity\Teaching;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TeachingController extends Controller
{
    public function addAction()
    {
        $request = $this->get('request');
        if( $request->getMethod() == "POST")
        {
          $prof_id = $request->request->get('professor');
          $disc_id = $request->request->get('discipline');
          $classe_id = $request->request->get('classe');

          $em = $this->getDoctrine()->getManager();
          $teaching = new Teaching();

          $classe = $em->getRepository('AthUserBundle:Classe')->findOneById($classe_id);
          $discipline = $em->getRepository('AthCoursBundle:Discipline')->findOneById($disc_id);
          $prof = $em->getRepository('AthUserBundle:Professor')->findOneById($prof_id);

          $prof->addClasse($classe);

          $teaching->setclasse($classe);
          $teaching->setDiscipline($discipline);
          $teaching->setProfessor($prof);
          $em->persist($teaching);
          $em->persist($prof);
          $em->flush();

          return new RedirectResponse($request->headers->get('referer'));
        }
    }

    public function removeAction()
    {
        return $this->render('remove.html.twig');
    }
}
