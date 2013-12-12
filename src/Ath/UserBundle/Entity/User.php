<?php

namespace Ath\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
* Ath\UserBundle\Entity\User
*
* @ORM\Table()
* @ORM\Entity(repositoryClass="Ath\UserBundle\Entity\UserRepository")
*/
class User extends BaseUser
{
  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string $firstname
   *
   * @ORM\Column(name="firstname", type="string", length=40)
   */
  private $firstname;

  /**
   * @var string $lastname
   *
   * @ORM\Column(name="lastname", type="string", length=50)
   */
  private $lastname;

  /**
   * @var date $birthdate
   *
   * @ORM\Column(name="birthdate", type="date", nullable=true)
   */
  private $birthdate;


  /**
   * @var string $phone
   *
   * @ORM\Column(name="phone", type="string", length=10, nullable=true)
   */
  private $phone;

  /**
   * @var string $address
   *
   * @ORM\Column(name="address", type="string", length=255, nullable=true)
   */
  private $address;

  /**
   * @var string $zipcode
   *
   * @ORM\Column(name="zipcode", type="string", length=5, nullable=true)
   */
  private $zipcode;

  /**
   * @var string $city
   *
   * @ORM\Column(name="city", type="string", length=40, nullable=true)
   */
  private $city;

  /**
   * @var string $country
   *
   * @ORM\Column(name="country", type="string", length=3, nullable=true)
   */
  private $country;

  public function __construct()
  {
    parent::__construct();

    $suscribeDate = new \Datetime();
    $birthdate = new \Datetime();
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
   * Set firstname
   *
   * @param string $firstname
   */
  public function setFirstname($firstname)
  {
    $this->firstname = $firstname;
  }

  /**
   * Get firstname
   *
   * @return string
   */
  public function getFirstname()
  {
    return $this->firstname;
  }


  /**
   * Get name
   *
   * @return string
   */
  public function getName()
  {
    return ucfirst($this->firstname) . " " . ucfirst($this->lastname);
  }


  /**
   * Set lastname
   *
   * @param string $lastname
   */
  public function setLastname($lastname)
  {
    $this->lastname = $lastname;
  }

  /**
   * Get lastname
   *
   * @return string
   */
  public function getLastname()
  {
    return $this->lastname;
  }


  /**
   * Set birthdate
   *
   * @param date $birthdate
   */
  public function setBirthdate($birthdate)
  {
    $this->birthdate = $birthdate;
  }

  /**
   * Get birthdate
   *
   * @return date
   */
  public function getBirthdate()
  {
    return $this->birthdate;
  }

  /**
   * Set phone
   *
   * @param string $phone
   */
  public function setPhone($phone)
  {
    $this->phone = $phone;
  }

  /**
   * Get phone
   *
   * @return string
   */
  public function getPhone()
  {
    return $this->phone;
  }

  /**
   * Set address
   *
   * @param string $address
   */
  public function setAddress($address)
  {
    $this->address = $address;
  }

  /**
   * Get address
   *
   * @return string
   */
  public function getAddress()
  {
    return $this->address;
  }

  /**
   * Set zipcode
   *
   * @param string $zipcode
   */
  public function setZipcode($zipcode)
  {
    $this->zipcode = $zipcode;
  }

  /**
   * Get zipcode
   *
   * @return string
   */
  public function getZipcode()
  {
    return $this->zipcode;
  }

  /**
   * Set city
   *
   * @param string $city
   */
  public function setCity($city)
  {
    $this->city = $city;
  }

  /**
   * Get city
   *
   * @return string
   */
  public function getCity()
  {
    return $this->city;
  }

  /**
   * Set country
   *
   * @param string $country
   */
  public function setCountry($country)
  {
    $this->country = $country;
  }

  /**
   * Get country
   *
   * @return string
   */
  public function getCountry()
  {
      return $this->country;
  }
}
