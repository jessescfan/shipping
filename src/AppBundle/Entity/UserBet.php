<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_bets")
 */
class UserBet
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="bets")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     */
    private $user;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="Bet", inversedBy="participants")
     * @ORM\JoinColumn(name="bet_id", referencedColumnName="id")
     *
     */
    private $bet;

    /**
     * @var
     *
     * @ORM\Column(name="selection", type="string", nullable=true)
     */
    private $selection;

    /**
     * @var
     *
     * @ORM\Column(name="prediction", type="string", nullable=true)
     */
    private $prediction;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Bet
     */
    public function getBet()
    {
        return $this->bet;
    }

    /**
     * @param mixed $bet
     */
    public function setBet($bet)
    {
        $this->bet = $bet;
    }

    /**
     * @return mixed
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * @param mixed $selection
     */
    public function setSelection($selection)
    {
        $this->selection = $selection;
    }

    /**
     * @return mixed
     */
    public function getPrediction()
    {
        return $this->prediction;
    }

    /**
     * @param mixed $prediction
     */
    public function setPrediction($prediction)
    {
        $this->prediction = $prediction;
    }

    public function __toString()
    {
        return $this->getBet()->getName();
    }
}