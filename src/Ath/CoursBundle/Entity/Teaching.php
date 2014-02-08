<?php

namespace Ath\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Teaching
 * @ORM\Entity
 */
class Teaching
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\Professor")
     */
    private $professor;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\Classe")
     */
    private $classe;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ath\CoursBundle\Entity\Discipline")
     */
    private $discipline;


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
     * Set professor
     *
     * @param \Ath\UserBundle\Entity\Professor $professor
     * @return Teaching
     */
    public function setProfessor(\Ath\UserBundle\Entity\Professor $professor)
    {
        $this->professor = $professor;
    
        return $this;
    }

    /**
     * Get professor
     *
     * @return \Ath\UserBundle\Entity\Professor 
     */
    public function getProfessor()
    {
        return $this->professor;
    }

    /**
     * Set classe
     *
     * @param \Ath\UserBundle\Entity\Classe $classe
     * @return Teaching
     */
    public function setClasse(\Ath\UserBundle\Entity\Classe $classe)
    {
        $this->classe = $classe;
    
        return $this;
    }

    /**
     * Get classe
     *
     * @return \Ath\UserBundle\Entity\Classe 
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * Set discipline
     *
     * @param \Ath\CoursBundle\Entity\Discipline $discipline
     * @return Teaching
     */
    public function setDiscipline(\Ath\CoursBundle\Entity\Discipline $discipline)
    {
        $this->discipline = $discipline;
    
        return $this;
    }

    /**
     * Get discipline
     *
     * @return \Ath\CoursBundle\Entity\Discipline 
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }
}