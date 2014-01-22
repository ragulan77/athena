<?php
namespace Ath\CoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Ath\CoursBundle\Entity\Discipline;

class DisciplineController extends Controller
{
   public function getDisciplinesAction()
   {
      $em = $this->getDoctrine()->getManager();
      $repo = $em->getRepository('AthCoursBundle:Discipline');
      $disciplines = $repo->findAll();
      $serializer = $this->get('serializer');

      return new Response($serializer->serialize($disciplines, "json"));
   }
}
