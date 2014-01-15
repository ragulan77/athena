<?php
namespace Ath\ExerciseBundle\Exercises;

use Ath\ExerciseBundle\Entity\exercise as exercise;
use Ath\ExerciseBundle\Entity\ExerciseFile as ExerciseFile;
use Symfony\Component\HttpFoundation\Request;
use Ath\ExerciseBundle\Entity\ExerciseInterface;

class AthQcm implements ExerciseInterface
{
  /* affiche l'énoncé */
  public function getSubject(ExerciseFile $exerciseFile)
  {
    $content = $this->getContent($exerciseFile);
    return $content[0];
  }

  /* retourne un tableau de bonnes réponses */
  public function getListOfRightAnswers(ExerciseFile $exerciseFile)
  {
    $content = $this->getContent($exerciseFile);
    return end($content);
  }

  /* retourne un tableau de réponses possibles */
  public function getListOfAnswers(ExerciseFile $exerciseFile)
  {
    $content = $this->getContent($exerciseFile);
    $answers = array();
    $nbAnswers = intval($content[1]);
    for($i = 0; $i < $nbAnswers; $i++)
      array_push($answers, $content[$i+2]);

    return $answers;
  }

  /* vérifie si la ou les réponses données sont valides ou non */
  public function areRightAnswers(ExerciseFile $exerciseFile, array $answers)
  {
    $rightAnswers = $this->getListOfRightAnswers($exerciseFile);
    return $rightAnswers[0] == $answers[0];
  }

  /* initialise l'énoncé */
  public function setContent(ExerciseFile $exerciseFile, Request $request)
  {
    if($request->getMethod() == "POST")
    {
      $content = $request->getContent();
      print_r($content);
    }
  }

  /* retourne le contenu sous forme d'un tableau */
  public function getContent(ExerciseFile $exerciseFile)
  {
    return explode(self::DELIMITER, $exerciseFile->getContent());
  }
}
