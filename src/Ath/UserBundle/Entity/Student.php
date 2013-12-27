<?php

namespace Ath\UserBundle\Entity;

use Ath\UserBundle\Entity\Utilisateur as MyBaseUser;
use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="Ath\UserBundle\Entity\StudentRepository")
 * @UniqueEntity(fields = "username", targetClass = "Ath\UserBundle\Entity\Utilisateur", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Ath\UserBundle\Entity\Utilisateur", message="fos_user.email.already_used")
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
  
	/* (non-PHPdoc)
	 * @see \Ath\UserBundle\Entity\Utilisateur::__construct()
	 */
  public function __construct() {
	// TODO: Auto-generated method stub
	parent::__construct();
	$this->addRole('ROLE_STUDENT');
  }

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
  public function setClasse( $classe)
  {
    $this->classe =  $classe;
  }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function __toString()
    {
    	return $this->getFirstname().' '.$this->getLastname();
    }
}