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
}
