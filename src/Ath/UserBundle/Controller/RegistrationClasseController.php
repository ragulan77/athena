<?php

namespace Ath\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\UserBundle\Entity\Classe;
use Symfony\Component\HttpFoundation\Request;
use Ath\UserBundle\Form\Type\RegistrationStudentFormType;
use Ath\UserBundle\Form\Type\RegistrationProfessorFormType;
use Ath\CoursBundle\Form\Type\DisciplineFormType;
use Ath\UserBundle\Entity\Student;
use Ath\CoursBundle\Entity\Discipline;
use Ath\UserBundle\Entity\Professor;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Ath\UserBundle\Form\Type\ClasseFormType;

class RegistrationClasseController extends Controller
{
	public function afficherAction(Request $request)
	{
		$newClasse = new Classe();

		$form = $this->createForm(new ClasseFormType('Ath\UserBundle\Entity\Classe'),$newClasse);

		$em = $this->getDoctrine()->getManager();

		//get all course by discipline pour downloader
		$listeClasse = $em->getRepository('AthUserBundle:Classe')->findAll();

		return $this->render(
				'AthUserBundle:Registration:classe.form.html.twig',
				array(
						'listeClasse' =>$listeClasse,
						'form' => $form->createView()
				)
		);
	}

    public function registerAction(Request $request)
    {
    	$newClasse = new Classe();
    	$form = $this->createForm(new ClasseFormType('Ath\UserBundle\Entity\Classe'),$newClasse);

    	$form->handleRequest($request);
     	$em = $this->getDoctrine()->getManager();

    	//si formulaire d'ajout de cours validé
    	if ($form->isValid()) {
    		$em->persist($newClasse);
    		$em->flush();

    		$this->get('session')->getFlashBag()->add(
    				'notice',
    				'Création de la classe réalisée avec succès !'
    		);

    	}
    	return new RedirectResponse($request->headers->get('referer'));
    }

    public function deleteAction($id)
    {
    	$em = $this->getDoctrine()->getManager();

    	//get classe by id pour supprimer
    	$classe = $em->getRepository('AthUserBundle:Classe')->findOneById($id);
    	$em->remove($classe);
    	$em->flush();

    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'Suppression de la classe réalisé avec succès !'
    	);

    	return $this->redirect($this->generateUrl('ath_classe_add'));
    }

    public function editAction(Classe $classe)
    {
    	$em = $this->getDoctrine()->getManager();

    	//get all student without class
    	$listeStudentsWithoutClass= $em->getRepository('AthUserBundle:Student')->findBy(array( "classe" => null));

        $listStudentsWithCLass = $em->getRepository('AthUserBundle:Student')->findBy(array( "classe" => $classe));

    	//get all discipline by level
    	$listeMatieres = $classe->getLevel()->getDisciplines();

    	$listOfTeaching = $em->getRepository('AthCoursBundle:Teaching')->findBy(array("classe" => $classe));

        $professorsWithoutClass = $em->getRepository('AthUserBundle:Professor')->getProfessorsWithoutClass($classe);

    	$discipline = new Discipline();

    	$formDiscipline = $this->createForm(new DisciplineFormType('Ath\CoursBundle\Entity\Discipline'), $discipline);


    	return
    	$this->render(
    			'AthUserBundle:Registration:classe.edit.html.twig',
    			array(
                        'listeStudentsWithoutClass' =>$listeStudentsWithoutClass,
    					'listStudentsWithCLass' =>$listStudentsWithCLass,
    					'classe' => $classe,
    					'listeMatieres' =>$listeMatieres,
    					'listOfTeaching' =>$listOfTeaching,
                        'professorsWithoutClass' => $professorsWithoutClass
    			)
    	);
    }
}
