<?php

namespace Ath\ExerciseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExerciseFile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ath\ExerciseBundle\Entity\ExerciseFileRepository")
 */
class ExerciseFile
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Ath\CoursBundle\Entity\Level")
     * @ORM\JoinColumn(nullable=false)
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Ath\CoursBundle\Entity\Chapter")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chapter;


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
     * Set type
     *
     * @param string $type
     * @return ExerciseFile
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ExerciseFile
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ExerciseFile
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
     * Set level
     *
     * @param \Ath\CoursBundle\Entity\Level $level
     * @return ExerciseFile
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

    /**
     * Set chapter
     *
     * @param \Ath\CoursBundle\Entity\Chapter $chapter
     * @return ExerciseFile
     */
    public function setChapter(\Ath\CoursBundle\Entity\Chapter $chapter)
    {
        $this->chapter = $chapter;

        return $this;
    }

    /**
     * Get chapter
     *
     * @return \Ath\CoursBundle\Entity\Chapter
     */
    public function getChapter()
    {
        return $this->chapter;
    }
}
