<?php

namespace Ath\UserBundle\Entity;

use Ath\UserBundle\Entity\User as MyBaseUser;
use Doctrine\ORM\Mapping as ORM;
use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="administrator")
 * @UniqueEntity(fields = "username", targetClass = "Ath\UserBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "Ath\UserBundle\Entity\User", message="fos_user.email.already_used")
 */
class Administrator extends MyBaseUser
{

  /**
   * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected  $id;

    public function __construct()
  {
    parent::__construct();
    $this->roles = array('ROLE_ADMINISTRATOR');
  }
}
