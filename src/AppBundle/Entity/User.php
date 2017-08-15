<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="UserBet", mappedBy="user")
     */
    private $bets;

    /**
     * @var
     *
     * @ORM\Column(name="first_name", type="string", nullable=true)
     */
    private $first_name;

    /**
     * @var
     *
     * @ORM\Column(name="last_name", type="string", nullable=true)
     */
    private $last_name;


    public function __construct()
    {
        parent::__construct();
        // your own logic

        $this->bets = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getBets()
    {
        return $this->bets;
    }

    /**
     * @param mixed $bets
     * @return self
     */
    public function setBets($bets)
    {
        $this->bets = $bets;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     * @return self
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     * @return self
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function __toString()
    {
        return $this->getFullName();
    }
}