<?php

namespace Ath\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ath\CoursBundle\Entity\CourseRepository")
 * @UniqueEntity(fields= {"name", "discipline"}, message="Ce cours existe déjà...")
 * @ORM\HasLifecycleCallbacks
 */
class Course
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
     * 
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer un nom")
     * @Assert\Length(
     * 		min = "5",
     *      max = "255",
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Le nom doit faire moins de {{ limit }} caractères"
     * )
     */
    private $name;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     * @Assert\DateTime()
     */
    private $date;
    
    //METTRE DES VERIFICATION DE FICHIER A UPLOAD
    /**
     * @var File
     * @Assert\NotBlank(message="Veuillez sélectionner un fichier avec une extension autre que: .exe, .bat, .scr, .pif, .com")
     * @Assert\File(
     * 		maxSize="6000000"
     * )
     */
    private $file;
    
    /**
     * @ORM\Column(name="chemin", type="string", length=500, nullable=true)
     * @Assert\Length(min="5",max="500")
     */
    public $path;
    
    
    /**
   	 * @ORM\ManyToOne(targetEntity="Ath\CoursBundle\Entity\Discipline")
   	 * @ORM\JoinColumn(nullable=false)
   	 */
    private $discipline;
    
    //Constructeur
    function __construct(){
    	$this->setDate(new \DateTime("now"));
    }
    
    /********GETTER ET SETTER*********/
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
     * @return Cours
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

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Cours
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
    	$this->file = $file;
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
    	return $this->file;
    }
    /**
     * Set path
     *
     * @param string $path
     * @return Cours
     */
    public function setPath($path)
    {
    	$this->path = $path;
    
    	return $this;
    }
    
    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
    	return $this->path;
    }
    
    /**
     * Set discipline
     *
     * @param \Ath\CoursBundle\Entity\Discipline $discipline
     * @return Cours
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
    
    /*************Fonctions pour definir l'emplacement de l upload du cours***************/
    public function getAbsolutePath()
    {
    	return null === $this->path
    	? null
    	: $this->getUploadRootDir().'/'.$this->path;
    }
    
    public function getWebPath()
    {
    	return null === $this->path
    	? null
    	: $this->getUploadDir().'/'.$this->path;
    }
    
    protected function getUploadRootDir()
    {
    	// the absolute directory path where uploaded
    	// documents should be saved
    	return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
    	//RAJOUTER LA CLASSE AVANT LA MATIERE
    	// get rid of the __DIR__ so it doesn't screw up
    	// when displaying uploaded doc/image in the view.
    	return 'uploads/'.$this->getDiscipline()->getName().'/'.$this->getName();
    }
    
    
    /******************Configuration pour que le cours et le fichier ne soit pas upload si pb********************/
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
    	//ENCODER LE CHEMIN
    	if (null !== $this->getFile()){
    		//generate a unique name
    		//$filename = sha1(uniqid(mt_rand(), true));
    		//$this->path = $filename.'.'.$this->getFile()->getClientOriginalExtension();
    		$filename = $this->getFile()->getClientOriginalName();
    		$this->path = $this->getUploadDir().'/'.$filename;
    	}
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
    	if (null === $this->getFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->fichier = null;
    }
    
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
    	if ($file = $this->getPath()) {
    		unlink($file);
    	}
    }

   
}