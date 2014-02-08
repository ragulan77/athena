<?php

namespace Ath\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Discipline
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ath\CoursBundle\Entity\DisciplineRepository")
 * @UniqueEntity(fields="name", message="Cette matière existe déjà...")
 */
class Discipline
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Ath\UserBundle\Entity\Classe", cascade={"persist"})
     */
    private $classes;

    /**
   	 * @ORM\OneToMany(targetEntity="Ath\NoteBundle\Entity\Note", mappedBy="matiere", cascade={"persist", "remove", "merge"})
   	 * @ORM\JoinColumn(nullable=true)
     */
    private $notes;

    public function __construct(){

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


    /**
     * Set name
     *
     * @param string $name
     * @return Matiere
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


    public function __toString()
    {
    	return $this->getName();
    }

    /**
     * Add notes
     *
     * @param \Ath\NoteBundle\Entity\Note $notes
     * @return Discipline
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

