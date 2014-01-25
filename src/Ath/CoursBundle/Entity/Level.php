<?php

namespace Ath\CoursBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Level
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ath\CoursBundle\Entity\LevelRepository")
 */
class Level
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Ath\CoursBundle\Entity\Discipline", cascade={"persist"})
     */
    private $disciplines;


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
     * @return Level
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
     * Add disciplines
     *
     * @param \Ath\CoursBundle\Entity\Discipline $disciplines
     * @return Discipline
     */
    public function addDiscipline(\Ath\CoursBundle\Entity\Discipline $disciplines)
    {
        $this->disciplines[] = $disciplines;

        return $this;
    }

    /**
     * Remove disciplines
     *
     * @param \Ath\CoursBundle\Entity\Discipline $disciplines
     */
    public function removeDiscipline(\Ath\CoursBundle\Entity\Discipline $disciplines)
    {
        $this->disciplines->removeElement($disciplines);
    }

    /**
     * Get disciplines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisciplines()
    {
        return $this->disciplines;
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
