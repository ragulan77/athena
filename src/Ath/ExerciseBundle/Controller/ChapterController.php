<?php
namespace Ath\ExerciseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Ath\ExerciseBundle\Entity\Chapter;

class ChapterController extends Controller
{
   public function getChaptersAction()
   {
      $em = $this->getDoctrine()->getManager();
      $repo = $em->getRepository('AthExerciseBundle:Chapter');
      $chapters = $repo->findAll();
      $serializer = $this->get('serializer');

      return new Response($serializer->serialize($chapters, "json"));
   }
}
