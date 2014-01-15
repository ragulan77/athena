<?php

namespace Ath\ExerciseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\ExerciseBundle\Entity\ExerciseFile;

class ExerciseController extends Controller
{
    /*
      affiche la page index pour selectioner les critères des exo
    */
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

    /*
      affiche la page pour selectioner les critères des exo
    */
    public function initAction()
    {
      return $this->render('AthExerciseBundle:init:init.html.twig');
    }

    /*
      retourne la vue correspondant à l'exercice
    */
    public function getSubjectViewAction(ExerciseFile $exercise)
    {
      $exerciseServiceManager = $this->get('ath_exercise.manager');
      $templatePath = $exerciseServiceManager->getSubjectTemplate($exercise);
      return $this->render($templatePath);
    }

    /*
      retourne la vue correspondant à la création
      d'un exercice
    */
    public function getCreateViewAction($type)
    {
      $exerciseServiceManager = $this->get('ath_exercise.manager');
      $templatePath = $exerciseServiceManager->getCreateTemplate($type);
      return $this->render($templatePath);
    }

    /*
      retourne la page qui incluera une vue twig en fonction du type d'exercice
    */
    public function getBlankViewAction()
    {
      return $this->render('AthExerciseBundle:Default:blank.html.twig');
    }

    /*
      retourne la liste des exercices en fonction des critères donnés
    */
    public function getExercisesAction()
    {
      $repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('AthExerciseBundle:ExerciseFile');
      $exercises = $repository->findAll();

      $serializer = $this->get('serializer');
      return new Response($serializer->serialize($exercises, "json"));
    }

    /*
      retourne toutes les informations (questions, sujets, réponses, etc),
      concernant un exercice
    */
    public function getExerciseDataAction(ExerciseFile $exercise)
    {
      $exerciseServiceManager = $this->get('ath_exercise.manager');
      $exerciseService = $exerciseServiceManager->getRightExerciseService($exercise);
      $exerciseService = $this->get($exerciseService);

      $subject = $exerciseService->getSubject($exercise);
      $answers = $exerciseService->getListOfAnswers($exercise);
      $rightAnswers = $exerciseService->getListOfRightAnswers($exercise);
      $data = array('subject' => $subject, 'answers' => $answers, 'rightAnswers' => $rightAnswers);

      $serializer = $this->get('serializer');
      return new Response($serializer->serialize($data, "json"));
    }

    public function checkAnswersAction(ExerciseFile $exercise)
    {
      $request = $this->get('request');
      if ($request->getMethod() == 'POST') {
        $exerciseServiceManager = $this->get('ath_exercise.manager');
        $exerciseService = $exerciseServiceManager->getRightExerciseService($exercise);
        $exerciseService = $this->get($exerciseService);

        $answers_json  = $request->getContent();
        $serializer = $this->get('serializer');
        $answers = $serializer->deserialize($answers_json, 'array', 'json');
        $answers = json_decode($answers['answers'], true);

        if($exerciseService->areRightAnswers($exercise, $answers))
          return new Response("true");
        else
          return new Response("false");
      }

      return new Response("false");
    }

    public function setExerciseAction($type)
    {
      $exerciseServiceManager = $this->get('ath_exercise.manager');
      $exerciseService = $exerciseServiceManager->getRightExerciseService($type);
      $exerciseService = $this->get($exerciseService);

      $exercise = new ExerciseFile();
      $exerciseService->setContent($exercise, $this->get('request'));
    }
}
