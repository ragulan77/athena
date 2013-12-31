<?php
namespace Ath\ExerciseBundle\Exercises;

use Ath\ExerciseBundle\Entity\exercise as exercise;
use Ath\ExerciseBundle\Entity\ExerciseFile as ExerciseFile;
use Symfony\Component\Form\Form;

class AthQcm implements exercise
{
  /* affiche l'énoncé */
  public function getSubject(ExerciseFile $exerciseFile)
  {
    $content = getContent($exerciseFile);
    return $content[0];
  }

  /* retourne un tableau de bonnes réponses */
  public function getListOfRightAnswers(ExerciseFile $exerciseFile)
  {
    $content = getContent($exerciseFile);
    return array(end($content));
  }

  /* retourne un tableau de réponses possibles */
  public function getListOfAnswers(ExerciseFile $exerciseFile)
  {
    $content = getContent($exerciseFile);
    $answers = array();
    $nbAnswers = intval($content[1]);
    for($i = 0; $i < $nbAnswers; $i++)
      array_push($answers, $content[$i+2]);

    return $answers;
  }

  /* vérifie si la ou les réponses données sont valides ou non */
  public function areRightAnswers(ExerciseFile $exerciseFile, $answers)
  {
    $rightAnswers = getListOfRightAnswers($exerciseFile);
    return $rightAnswers[0] == $answers[0];
  }

  /* initialise l'énoncé */
  public function setContent(ExerciseFile $exerciseFile, Form $form)
  {

  }

  /* retourne le contenu sous forme d'un tableau */
  public function getContent(ExerciseFile $exerciseFile)
  {
    return explode(self::DELIMITER, $exerciseFile->getContent());
  }
}
