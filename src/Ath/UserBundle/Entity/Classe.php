<?php

namespace Ath\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ath\UserBundle\Entity\Classe
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Classe
{
  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

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
