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
      affiche la page finale score
    */
    public function scoreAction()
    {
        return $this->render('AthExerciseBundle:Default:score.html.twig');
    }

    /*
      affiche la page admin pour gérer les exo
    */
    public function adminAction()
    {
      $services = $this->get('ath_exercise.manager')->getListOfServices();
      $service_name = array();
      foreach ($services as $key => $value) {
        array_push($service_name, $key);
      }

      return $this->render('AthExerciseBundle:Default:admin.html.twig', array('services' => $service_name));
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
      $exerciseService = $exerciseServiceManager->getRightExerciseServiceByType($type);
      $exerciseService = $this->get($exerciseService);

      $req = $this->get('request');
      $exercise = new ExerciseFile();
      $exerciseService->setContent($exercise, $req);

      $em = $this->getDoctrine()->getManager();
      $chapter = $em->getRepository('AthExerciseBundle:Chapter')->find($req->request->get('chapter'));
      $level = $em->getRepository('AthExerciseBundle:Level')->find($req->request->get('level'));

      $exercise->setChapter($chapter);
      $exercise->setLevel($level);

      $em->persist($exercise);
      $em->flush();

      return $this->render('AthExerciseBundle:Default:created.html.twig');
    }
}
