<?php

namespace Ath\ExerciseBundle\Exercises;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Ath\ExerciseBundle\Entity\ExerciseInterface;

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

  public function getRightExerciseService($serviceName)
  {
    return $this->container->getParameter('exercise_services_list')[$serviceName]['service_name'];
  }

  public function getSubjectTemplate($serviceName)
  {
    return $container->getParameter('exercise_services_list')[$serviceName]['subject_template'];
  }

  public function getCreateTemplate($serviceName)
  {
    return $container->getParameter('exercise_services_list')[$serviceName]['create_template'];
  }

  /* retourne un tableau de chaine de caractères */
  public function getListOfServices()
  {
    $container->getParameter('exercise_services_list');
  }
}
