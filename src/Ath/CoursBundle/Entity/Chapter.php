<?php

namespace Ath\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chapter
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ath\CoursBundle\Entity\ChapterRepository")
 */
class Chapter
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
     * @ORM\ManyToOne(targetEntity="Ath\CoursBundle\Entity\Discipline")
     * @ORM\JoinColumn(nullable=false)
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
     * Set name
     *
     * @param string $name
     * @return Chapter
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
     * Set discipline
     *
     * @param \Ath\CoursBundle\Entity\Discipline $discipline
     * @return Chapter
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
