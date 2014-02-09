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
   * @ORM\Column(name="id", type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected  $id;


  /**
   * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\Classe")
   * @ORM\JoinColumn(nullable=true)
   */
  private $classe;

  /**
   * @ORM\OneToMany(targetEntity="Ath\NoteBundle\Entity\Note", mappedBy="student", cascade={"persist", "remove", "merge"})
   * @ORM\JoinColumn(nullable=true)
   */
  private $notes;
  
  public function __construct()
  {
    parent::__construct();
    $this->roles = array('ROLE_STUDENT');
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

    /**
     * Add notes
     *
     * @param \Ath\NoteBundle\Entity\Note $notes
     * @return Student
     */
    public function addNote(\Ath\NoteBundle\Entity\Note $notes)
    {
        $this->notes[] = $notes;
    
        return $this;
    }

    /**
     * Remove notes
     *
     * @param \Ath\NoteBundle\Entity\Note $notes
     */
    public function removeNote(\Ath\NoteBundle\Entity\Note $notes)
    {
        $this->notes->removeElement($notes);
    }

    /**
     * Get notes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotes()
    {
        return $this->notes;
    }
}