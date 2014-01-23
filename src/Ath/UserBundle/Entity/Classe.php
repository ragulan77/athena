<?php

namespace Ath\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Ath\UserBundle\Entity\Classe
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="Ath\UserBundle\Entity\ClasseRepository")
 * @UniqueEntity(fields="name", message="Cette classe existe déjà...")
 */
class Classe
{
  /**
   * @var integer $id
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var string
   *
   *
   * @ORM\Column(name="name", type="string", length=255)
   * @Assert\NotBlank(message="Veuillez entrer un nom")
   * @Assert\Length(
   * 		min = "4",
   *      max = "255",
   *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
   *      maxMessage = "Le nom doit faire moins de {{ limit }} caractères"
   * )
   */
  private $name;

  /**
   * @ORM\ManyToOne(targetEntity="Ath\CoursBundle\Entity\Level")
   * @ORM\JoinColumn(nullable=false)
   */
  private $level;

  /**
   * Get id
   *
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

    /**
     * Set name
     *
     * @param string $name
     * @return Classe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    public function __toString(){
    	return $this->getName();
    }

    /**
     * Set level
     *
     * @param \Ath\CoursBundle\Entity\Level $level
     * @return Classe
     */
    public function setLevel(\Ath\CoursBundle\Entity\Level $level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return \Ath\CoursBundle\Entity\Level 
     */
    public function getLevel()
    {
        return $this->level;
    }
}