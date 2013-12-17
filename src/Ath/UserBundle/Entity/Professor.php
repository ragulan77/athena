<?php

namespace Ath\UserBundle\Entity;

use Ath\UserBundle\Entity\User as MyBaseUser;
use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="professor")
 * @UniqueEntity(fields = "username", targetClass = "Ath\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Ath\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Professor extends MyBaseUser
{

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected  $id;

  /**
   * @ORM\ManyToMany(targetEntity="Ath\UserBundle\Entity\Classe", cascade={"persist"})
   */
  private $classes;

  public function __construct()
  {
    parent::__construct();
    $this->classes = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
   * Get classes
   *
   * @return Doctrine\Common\Collections\Collection
   */
  public function getClasses()
  {
    return $this->classes;
  }

  /**
    * Add classes
    *
    * @param Ath\UserBundle\Entity\Classe $classes
    */
  public function addClasse(Ath\UserBundle\Entity\Classe $classe)
  {
    $this->classes[] = $classe;
  }

  /**
    * Remove classes
    *
    * @param Ath\UserBundle\Entity\Classe $classe
    */
  public function removeClasse(Ath\UserBundle\Entity\Classe $classe)
  {
    $this->classes->removeElement($classe);
  }
}
