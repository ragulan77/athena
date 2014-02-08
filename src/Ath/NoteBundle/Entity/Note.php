<?php

namespace Ath\NoteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Note
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ath\NoteBundle\Entity\NoteRepository")
 * @ORM\Entity
 */
class Note
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
     * @ORM\Column(name="intitule", type="string",nullable=false)
     * @Assert\NotBlank(message="Veuillez entrer un coefficient")
     * @Assert\Length(
     * 		min = "2",
     *      max = "255",
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom doit faire moins de {{ limit }} caractères"
     * )
     * @var string
     */
    private $intitule;
    
    /**
     * @var decimal
     *
     * @ORM\Column(name="note", type="float")
     * @Assert\NotBlank(message="Veuillez entrer une note")
     * @Assert\Type(type="float", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
    private $note;
    
    /**
     * @var decimal
     * 
     * @ORM\Column(name="coefficient", type="float")
     * @Assert\NotBlank(message="Veuillez entrer un coefficient")
     * @Assert\Type(type="float", message="La valeur {{ value }} n'est pas un type {{ type }} valide.")
     */
	private $coefficient;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Ath\CoursBundle\Entity\Discipline", inversedBy="notes", cascade={"persist","merge"})
	 * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="Note_idMatiere", referencedColumnName="id")
     * })
	 */
	private $matiere;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Ath\UserBundle\Entity\Student", inversedBy="notes", cascade={"persist", "merge"})
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="Note_idStudent", referencedColumnName="id")
     * })
	 */
	private $student;
	
	/**
	 * @ORM\Column(name="trimestre", type="string",nullable=false)
	 * @var string
	 */
	private $trimestre;
    
	
	
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
     * Set coefficient
     *
     * @param float $coefficient
     * @return Note
     */
    public function setCoefficient($coefficient)
    {
        $this->coefficient = $coefficient;
    
        return $this;
    }

    /**
     * Get coefficient
     *
     * @return float 
     */
    public function getCoefficient()
    {
        return $this->coefficient;
    }

    /**
     * Set matiere
     *
     * @param \Ath\CoursBundle\Entity\Discipline $matiere
     * @return Note
     */
    public function setMatiere(\Ath\CoursBundle\Entity\Discipline $matiere)
    {
        $this->matiere = $matiere;
    
        return $this;
    }

    /**
     * Get matiere
     *
     * @return \Ath\CoursBundle\Entity\Discipline 
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set student
     *
     * @param \Ath\UserBundle\Entity\Student $student
     * @return Note
     */
    public function setStudent(\Ath\UserBundle\Entity\Student $student = null)
    {
        $this->student = $student;
    
        return $this;
    }

    /**
     * Get student
     *
     * @return \Ath\UserBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set note
     *
     * @param float $note
     * @return Note
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return float 
     */
    public function getNote()
    {
        return $this->note;
    }
    
    public function __toString()
    {
    	return ''.$this->note;
    }

    /**
     * Set trimestre
     *
     * @param Trimestre $trimestre
     * @return string
     */
    public function setTrimestre($trimestre)
    {
        $this->trimestre = $trimestre;
    
        return $this;
    }

    /**
     * Get trimestre
     *
     * @return string 
     */
    public function getTrimestre()
    {
        return $this->trimestre;
    }

    /**
     * Set intitule
     *
     * @param string $intitule
     * @return Note
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;
    
        return $this;
    }

    /**
     * Get intitule
     *
     * @return string 
     */
    public function getIntitule()
    {
        return $this->intitule;
    }
}