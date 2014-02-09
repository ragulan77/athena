<?php
namespace Ath\ExerciseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Ath\CoursBundle\Entity\Level;

class LevelController extends Controller
{
   public function getLevelsAction()
   {
      $em = $this->getDoctrine()->getManager();
      $repo = $em->getRepository('AthCoursBundle:Level');
      $levels = $repo->findAll();
      $serializer = $this->get('serializer');

      return new Response($serializer->serialize($levels, "json"));
   }
}
