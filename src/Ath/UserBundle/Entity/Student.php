<?php

namespace Ath\UserBundle\Entity;

use Ath\UserBundle\Entity\User as MyBaseUser;
use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="student")
 * @UniqueEntity(fields = "username", targetClass = "Ath\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Ath\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Student extends MyBaseUser
{

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected  $id;


  /**
   * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\Classe")
   * @ORM\JoinColumn(nullable=false)
   */
  private $classe;

  /**
   * Get classe
   *
   * @return Ath\UserBundle\Entity\Classe
   */
  public function getClasse()
  {
    return $this->classe;
  }

  /**
   * Set classe
   *
   * @param Ath\UserBundle\Entity\Classe $classe
   */
  public function setClasse(Ath\UserBundle\Entity\Classe $classe)
  {
    $this->classe =  $classe;
  }
}
