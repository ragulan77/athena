<?php

namespace Ath\ExerciseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\ExerciseBundle\Entity\ExerciseFile;

class ExerciseController extends Controller
{
    public function indexAction()
    {
      $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('AthExerciseBundle:ExerciseFile');

      $exercise = $repository->find(1);

      $exerciseServiceManager = $this->get('ath_exercise.manager');
      $exerciseService = $exerciseServiceManager->getRightExerciseService($exercise);

      $exerciseService = $this->get($exerciseService);
      $subject = $exerciseService->getSubject($exercise);
      $answers = array(0);
      $test = $this->getSubjectAction($exercise);
      var_dump($test);
      return $this->render('AthExerciseBundle:Default:index.html.twig');
    }

    public function getSubjectAction(ExerciseFile $exercise)
    {
      $exerciseServiceManager = $this->get('ath_exercise.manager');
      $templatePath = $exerciseServiceManager->getSubjectTemplate($exercise);
      return $this->render($templatePath);
    }
}
