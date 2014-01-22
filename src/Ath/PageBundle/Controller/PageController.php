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
    		$disciplines = $em->getRepository('AthCoursBundle:Discipline')->getDisciplinesByClasseId($listeClasses->getId());
    		$listeMatieresParClasse = array(
    			$listeClasses->getName() => $disciplines
    		);
    	}elseif( $securityContext->isGranted('ROLE_PROFESSOR') ) {
    		$listeClasses = $user->getClasses();
    		$listeMatieresParClasse=array();
    		foreach ($listeClasses as $classe){
    			$disciplines = $em->getRepository('AthCoursBundle:Discipline')->getDisciplinesByClasseId($classe->getId());
    			$listeMatieresParClasse[$classe->getName()] = $disciplines;
    		}
    	}elseif( $securityContext->isGranted('ROLE_ADMINISTRATOR') ){
    		$listeClasses = $em->getRepository('AthUserBundle:Classe')->findAll();
    		$listeMatieresParClasse=array();
    		foreach ($listeClasses as $classe){
    			$disciplines = $em->getRepository('AthCoursBundle:Discipline')->getDisciplinesByClasseId($classe->getId());
    			$listeMatieresParClasse[$classe->getName()] = $disciplines;
    		}
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
