<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdministrationController extends Controller
{
    public function indexAction()
    {
      return $this->render('AthUserBundle:Administration:index.html.twig');
    }

    public function usersAction()
    {
      $types = array("professeur", "administrateur", "étudiant");
      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('AthUserBundle:Classe');
      $classes = $repository->findAll();

      $users = null;
      $request = $this->get('request');

      if ($request->getMethod() == 'POST') {
        $type = $request->request->get('type');
        $classe = $request->request->get('classe');

        if($type == "administrateur")
          $repository = $em->getRepository('AthUserBundle:Administrator');
        else if ($type == "professeur")
          $repository = $em->getRepository('AthUserBundle:Professor');
        else
          $repository = $em->getRepository('AthUserBundle:Student');

        $users = null;
        if($type == "étudiant")
          $users = $repository->findBy(array('classe' => $classe));
        else
          $users = $repository->findAll();
      }

      return $this->render('AthUserBundle:Administration:users.html.twig', array('types' => $types, 'classes' => $classes, 'users' => $users));
    }
}
