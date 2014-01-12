<?php

namespace Ath\ExerciseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\ExerciseBundle\Entity\ExerciseFile;

class ExerciseController extends Controller
{
    public function indexAction()
    {
      /*$repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('AthExerciseBundle:ExerciseFile');

      $exercise = $repository->find(2);
      $serializer = $this->get('serializer');
      var_dump($serializer->serialize($exercise, "json"));
      $exerciseServiceManager = $this->get('ath_exercise.manager');
      $exerciseService = $exerciseServiceManager->getRightExerciseService($exercise);

      $exerciseService = $this->get($exerciseService);
      $subject = $exerciseService->getSubject($exercise);
      $answers = array(0);
      $test = $this->getSubjectAction($exercise); */

      return $this->render('AthExerciseBundle:Default:index.html.twig');
    }

    public function getSubjectAction(ExerciseFile $exercise)
    {
      $exerciseServiceManager = $this->get('ath_exercise.manager');
      $templatePath = $exerciseServiceManager->getSubjectTemplate($exercise);
      return $this->render($templatePath);
    }

    public function exercisesAction()
    {
      $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('AthExerciseBundle:ExerciseFile');
      $exercises = $repository->findAll();

      $serializer = $this->get('serializer');
      return new Response($serializer->serialize($exercises, "json"));
    }

    public function initAction()
    {
      return $this->render('AthExerciseBundle:init:init.html.twig');
    }
}
