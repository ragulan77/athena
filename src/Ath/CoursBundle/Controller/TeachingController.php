<?php

namespace Ath\CoursBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\UserBundle\Entity\Professor;
use Ath\CoursBundle\Entity\Discipline;

class TeachingController extends Controller
{
    public function addAction(Professor $professor, Discipline $discipline)
    {
        return $this->render('.html.twig');
    }

    public function remoteAction()
    {
        return $this->render('remove.html.twig');
    }
}
