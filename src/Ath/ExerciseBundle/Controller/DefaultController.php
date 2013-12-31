<?php

namespace Ath\ExerciseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AthExerciseBundle:Default:index.html.twig', array('name' => $name));
    }
}
