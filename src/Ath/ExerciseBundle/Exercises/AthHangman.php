<?php
namespace Ath\ExerciseBundle\Exercises;

use Ath\ExerciseBundle\Entity\exercise as exercise;
use Ath\ExerciseBundle\Entity\ExerciseFile as ExerciseFile;
use Symfony\Component\HttpFoundation\Request;
use Ath\ExerciseBundle\Entity\ExerciseInterface;

class AthHangman implements ExerciseInterface
{
  /* affiche l'énoncé */
  public function getSubject(ExerciseFile $exerciseFile)
  {
    $subject = $this->getContent($exerciseFile);
    $subject = str_split($subject[0]);

    $subject_array = array();
    foreach($subject as $char)
    {
      array_push($subject_array, array('char' => $char, 'discovered' => false));
    }
    return $subject_array;
  }

  /* retourne un tableau de bonnes réponses */
  public function getListOfRightAnswers(ExerciseFile $exerciseFile)
  {
    $content = $this->getContent($exerciseFile);
    $content = str_split($content[0]);

    return array_unique($content);
  }

  /* retourne un tableau de réponses possibles */
  public function getListOfAnswers(ExerciseFile $exerciseFile)
  {
    $alphabet = "abcdefghijklmnopqrstuvwxyz";
    return str_split($alphabet);
  }

  /* vérifie si la ou les réponses données sont valides ou non */
  public function areRightAnswers(ExerciseFile $exerciseFile, array $answers)
  {
    $rightAnswers = $this->getListOfRightAnswers($exerciseFile);
    return in_array($answers[0], $rightAnswers);
  }

  /* initialise l'énoncé */
  public function setContent(ExerciseFile $exerciseFile, Request $request)
  {
    if($request->getMethod() == "POST")
    {
      $name = $request->request->get('name');
      $question = $request->request->get('question');
      $answers = $request->request->get('answers');

      $nbAnswers = count($answers);
      $rightAnswer = $request->request->get('rightAnswer');

      $answersIntoString = "";
      foreach($answers as $answer)
        $answersIntoString .= $answer . "\n";

      $exerciseFile->setName($name);
      $exerciseFile->setType("hangman");
      $exerciseFile->setContent($question . "\n" .
                                $nbAnswers . "\n" .
                                $answersIntoString .
                                $rightAnswer);
    }
  }

  /* retourne le contenu sous forme d'un tableau */
  public function getContent(ExerciseFile $exerciseFile)
  {
    return explode(self::DELIMITER, $exerciseFile->getContent());
  }
}
