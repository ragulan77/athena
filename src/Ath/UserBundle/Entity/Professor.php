<?php

namespace Ath\UserBundle\Entity;

use Ath\UserBundle\Entity\Utilisateur as MyBaseUser;
use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="professor")
 * @ORM\Entity(repositoryClass="Ath\UserBundle\Entity\ProfessorRepository")
 * @UniqueEntity(fields = "username", targetClass = "Ath\UserBundle\Entity\Utilisateur", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Ath\UserBundle\Entity\Utilisateur", message="fos_user.email.already_used")
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
   * @ORM\ManyToMany(targetEntity="Ath\CoursBundle\Entity\Discipline", cascade={"persist"})
   */
  private $matieres;

  /**
   * @ORM\ManyToMany(targetEntity="Ath\UserBundle\Entity\Classe", cascade={"persist"})
   */
  private $classes;

  public function __construct()
  {
    parent::__construct();
    $this->classes = new \Doctrine\Common\Collections\ArrayCollection();
    $this->roles = array('ROLE_PROFESSOR');
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
  public function addClasse(Classe $classe)
  {
    $this->classes[] = $classe;
  }

  	/**
     * Remove classes
     *
     * @param Ath\UserBundle\Entity\Classe $classe
     */
  	public function removeClasse(Classe $classe)
  	{
    	$this->classes->removeElement($classe);
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
     * Add matieres
     *
     * @param \Ath\CoursBundle\Entity\Discipline $matieres
     * @return Professor
     */
    public function addMatiere(\Ath\CoursBundle\Entity\Discipline $matieres)
    {
        $this->matieres[] = $matieres;

        return $this;
    }

    /**
     * Remove matieres
     *
     * @param \Ath\CoursBundle\Entity\Discipline $matieres
     */
    public function removeMatiere(\Ath\CoursBundle\Entity\Discipline $matieres)
    {
        $this->matieres->removeElement($matieres);
    }

    /**
     * Get matieres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     *
     * @param \Ath\CoursBundle\Entity\Discipline $matiere
     * @return boolean
     */
    public function hasMatiere(\Ath\CoursBundle\Entity\Discipline $matiere)
    {
      foreach ($this->matieres as $discipline) {
        if($discipline->getId() == $matiere->getId())
          return true;
      }

      return false;
    }

    public function toArray()
    {
      $disciplineArray = array();
      foreach($this->matieres as $discipline)
        array_push($disciplineArray, $discipline->getName());

      $userArray = array('id' => $this->id,
                          'firstname' => $this->getFirstname(),
                          'lastname' => $this->getLastname(),
                         'disciplines' => $disciplineArray
                         );
      return $userArray;
    }
}
