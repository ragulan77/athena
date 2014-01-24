<?php

namespace Ath\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('AthPageBundle:Page:index.html.twig');
    }

    //verifier s il existe des restrictions pour verifier si l user est bien logger avant de l appeler
    public function menuAction()
    {
    	//récupérer l user connecté
    	$user = $this->getUser();

    	$securityContext = $this->container->get('security.context');
    	$em= $this->getDoctrine()->getManager();
        $listeClasses = null;
        $listeMatieresParClasse=null;

    	//récupérer ses classes et ses matières
    	if( $securityContext->isGranted('ROLE_STUDENT') ){
    		$listeClasses = $user->getClasse(); //classe unique
    	}elseif( $securityContext->isGranted('ROLE_PROFESSOR') ) {
    		$listeClasses = $user->getClasses();
    	}elseif( $securityContext->isGranted('ROLE_ADMINISTRATOR') ){
    		$listeClasses = $em->getRepository('AthUserBundle:Classe')->findAll();
    	}

    	return $this->render(
    			'AthPageBundle:Page:menu.html.twig',
    			array(
    					"listeMatieresParClasse" => $listeMatieresParClasse,
    					"listeClasses" => $listeClasses
    			)
    	);
    }
}
