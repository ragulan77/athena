<?php

namespace Ath\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ath\NoteBundle\Form\Type\NoteFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Ath\NoteBundle\Entity\Note;

class NoteController extends Controller
{
	//pour student affiche les notes
    public function afficherAction()
    {
    	//récupérer l user connecté
    	$user = $this->getUser();

    	$securityContext = $this->container->get('security.context');
    	$em= $this->getDoctrine()->getManager();

    	$classe = $user->getClasse();
    	$disciplines = $em->getRepository('AthCoursBundle:Discipline')->getDisciplinesByClasseId($classe->getId());

    	foreach ($disciplines as $discipline){
    		$listeNotesPremierTrimestreParMatiere[$discipline->getName()] =
    			$em->getRepository('AthNoteBundle:Note')->findBy(
				array(
    				'student' => $user,
					'matiere' => $discipline,
					'trimestre' => '1'
    			)
    		);

    		$listeNotesDeuxiemeTrimestreParMatiere[$discipline->getName()] =
    		$em->getRepository('AthNoteBundle:Note')->findBy(
    				array(
    						'student' => $user,
    						'matiere' => $discipline,
    						'trimestre' => '2'
    				)
    		);

    		$listeNotesTroisiemeTrimestreParMatiere[$discipline->getName()] =
    		$em->getRepository('AthNoteBundle:Note')->findBy(
    				array(
    						'student' => $user,
    						'matiere' => $discipline,
    						'trimestre' => '3'
    				)
    		);
    	}

       return $this->render(
       		'AthNoteBundle:Note:show.html.twig',
       		array(
       			'disciplines' => $disciplines,
       			'listeNotesPremierTrimestreParMatiere' => $listeNotesPremierTrimestreParMatiere,
       			'listeNotesDeuxiemeTrimestreParMatiere' => $listeNotesDeuxiemeTrimestreParMatiere,
       			'listeNotesTroisiemeTrimestreParMatiere' => $listeNotesTroisiemeTrimestreParMatiere
       		)
    	);
    }

    //dashboard du prof pr choisir matiere,classe,eleve et trimestre
    public function dashboardAction()
    {
    	//récupérer l user connecté
    	$user = $this->getUser();

    	$securityContext = $this->container->get('security.context');
    	$em= $this->getDoctrine()->getManager();

    	if( $securityContext->isGranted('ROLE_PROFESSOR') ) {
    		$listeClasses = $user->getClasses();
    	}else{
    		$listeClasses = $em->getRepository('AthUserBundle:Classe')->findAll();
    	}

    	$listeTrimestre = array(
    		"1" => "1er",
    		"2" => "2ème",
    		"3" => "3ème"
    	);

    	return $this->render(
    			'AthNoteBundle:Note:dashboard.html.twig',
    			array(
    					"listeClasses" => $listeClasses,
    					"listeTrimestre" => $listeTrimestre
    			)
    	);
    }
    

    public function getMatiereByClasseIdAction($classeId){
    	$em= $this->getDoctrine()->getManager();

    	$classe = $em->getRepository('AthUserBundle:Classe')->findOneById($classeId);
        $level = $classe->getLevel();
        $disciplines = $level->getDisciplines();
    	$students = $em->getRepository('AthUserBundle:Student')->findBy(array( "classe" => $classe));

        $data = array('disciplines' => array(), 'students' => array());
    	for($i=0; $i < count($disciplines) ; $i++){
    		$data["disciplines"][$i] = array(
    				'id' => $disciplines[$i]->getId(),
    				'name' => $disciplines[$i]->getName()
    		);
    	}

    	for($i=0; $i < count($students) ; $i++){
    		$data["students"][$i] = array(
    				'id' => $students[$i]->getId(),
    				'firstname' => $students[$i]->getFirstname(),
    				'lastname' => $students[$i]->getLastname(),
    				'classe' => $students[$i]->getClasse()->getName()
    		);
    	}

    	return new JsonResponse($data);
    }

    //interface pour PROFESSOR/ADMINISTRATOR
    //interface affichant les notes d'un élève pour une matière donnée
	public function dashboardStudentAction($idMatiere,$idEtudiant)
	{
		$em= $this->getDoctrine()->getManager();
		$discipline = $em->getRepository('AthCoursBundle:Discipline')->find($idMatiere);
		$student = $em->getRepository('AthUserBundle:Student')->find($idEtudiant);
		//$listeNotes = $student->getNotes();
		$listeNotesPremierTrimestre = $em->getRepository('AthNoteBundle:Note')->findBy(
				array(
						'student' => $student,
						'matiere' => $discipline,
						'trimestre' => '1'
				)
		);

		$listeNotesDeuxiemeTrimestre = $em->getRepository('AthNoteBundle:Note')->findBy(
				array(
						'student' => $student,
						'trimestre' => '2'
				)
		);

		$listeNotesTroisiemeTrimestre = $em->getRepository('AthNoteBundle:Note')->findBy(
				array(
						'student' => $student,
						'trimestre' => '3'
				)
		);

		$note = new Note();
		$note->setStudent($student);
		$note->setMatiere($discipline);
		$note->setTrimestre("1");
		$formNotePremierTrimestre = $this->createForm(new NoteFormType('Ath\NoteBundle\Entity\Note'), $note);


		$note->setTrimestre("2");
		$formNoteDeuxiemeTrimestre = $this->createForm(new NoteFormType('Ath\NoteBundle\Entity\Note'), $note);

		$note->setTrimestre("3");
		$formNoteTroisiemeTrimestre = $this->createForm(new NoteFormType('Ath\NoteBundle\Entity\Note'), $note);

		return $this->render(
     			'AthNoteBundle:Note:resultSelection.html.twig',
     			array(
     					"student" => $student,
     					"discipline" => $discipline,
     					"listeNotesPremierTrimestre" => $listeNotesPremierTrimestre,
     					"listeNotesDeuxiemeTrimestre" => $listeNotesDeuxiemeTrimestre,
     					"listeNotesTroisiemeTrimestre" => $listeNotesTroisiemeTrimestre,
     					"formNotePremierTrimestre" => $formNotePremierTrimestre->createView(),
     					"formNoteDeuxiemeTrimestre" => $formNoteDeuxiemeTrimestre->createView(),
     					"formNoteTroisiemeTrimestre" => $formNoteTroisiemeTrimestre->createView()
     			)
     	);
	}

	public function ajouterAction(Request $request)
	{
		$newNote = new Note();
		$form = $this->createForm(new NoteFormType('Ath\NoteBundle\Entity\Note'),$newNote);

		$form->handleRequest($request);
		$em = $this->getDoctrine()->getManager();

		//si formulaire d'ajout de cours validé
		if ($form->isValid()) {
			$em->persist($newNote);
			$em->flush();
			
			$this->get('session')->getFlashBag()->add(
					'noticeNote'.$newNote->getTrimestre(),
					'Ajout de la note réalisé avec succès !'
			);

		}
		return new RedirectResponse($request->headers->get('referer'));
	}

	public function supprimerAction(Request $request,$id)
	{
		$em = $this->getDoctrine()->getManager();

		//get note by id pour supprimer
		$note = $em->getRepository('AthNoteBundle:Note')->findOneById($id);
		$em->remove($note);
		$em->flush();

		$this->get('session')->getFlashBag()->add(
				'noticeNote',
				'Suppression de la note réalisée avec succès !'
		);

		return new RedirectResponse($request->headers->get('referer'));
	}
}
