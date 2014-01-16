<?php

namespace Ath\ExerciseBundle\Exercises;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Ath\ExerciseBundle\Entity\ExerciseInterface;
use Ath\ExerciseBundle\Entity\ExerciseFile;

class AthExerciseManager
{

  /**
   *
   * @var \Symfony\Component\DependencyInjection\ContainerInterface
   */
  protected $container;


  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function getRightExerciseService(ExerciseFile $exercise)
  {
    $serviceName = $exercise->getType();
    return $this->container->getParameter('exercise_services_list')[$serviceName]['service_name'];
  }

  public function getRightExerciseServiceByType($type)
  {
    $serviceName = $type;
    return $this->container->getParameter('exercise_services_list')[$serviceName]['service_name'];
  }

  public function getSubjectTemplate(ExerciseFile $exercise)
  {
    $serviceName = $exercise->getType();
    $exercise_services_list = $this->container->getParameter('exercise_services_list');
    if(!array_key_exists($serviceName, $exercise_services_list))
      throw new \Exception('Cette page n\'existe pas');

    return $exercise_services_list[$serviceName]['subject_template'];
  }

  public function getCreateTemplate($type)
  {
      $serviceName = $type;
      $exercise_services_list = $this->container->getParameter('exercise_services_list');
      if(!array_key_exists($serviceName, $exercise_services_list))
        throw new \Exception('Cette page n\'existe pas');

      return $exercise_services_list[$serviceName]['create_template'];
  }

  /* retourne un tableau de chaine de caractères */
  public function getListOfServices()
  {
    $container->getParameter('exercise_services_list');
  }
}
