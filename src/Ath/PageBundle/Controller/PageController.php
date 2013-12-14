<?php

namespace Ath\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('AthPageBundle:Page:index.html.twig');
    }
}
