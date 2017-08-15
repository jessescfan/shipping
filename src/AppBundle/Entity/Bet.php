<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="bets")
 */
class Bet
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     * @ORM\Column(type="string", name="name")
     */
    private $name;

    /**
     * @var string $description
     * @ORM\Column(type="string", name="description", nullable=true)
     */
    private $description;

    /**
     * @var integer $amount
     * @ORM\Column(type="integer", name="amount", nullable=true)
     */
    private $amount;

    /**
     * @var string $type
     * @ORM\Column(type="string", name="type", nullable=true)
     */
    private $type;

    /**
     * @var string $currency
     * @ORM\Column(type="string", name="currency", nullable=true)
     */
    private $currency;

    /**
     * @ORM\OneToMany(targetEntity="UserBet", mappedBy="bet", cascade={"persist", "remove"})
     */
    private $participants;

    /**
     * @var string
     * @ORM\Column(type="string", name="sport_type", nullable=true)
     */
    private $sport_type;

    /**
     * @ORM\Column(type="datetime", name="start_date", nullable=true)
     * @Assert\NotBlank()
     */
    private $start_date;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return ArrayCollection UserBet
     */
    public function getUserBets()
    {
        return $this->participants;
    }

    /**
     * @return ArrayCollection
     */
    public function getParticipants()
    {
        $participants = new ArrayCollection();
        foreach ($this->participants as $user_bet) {
            $participants ->add($user_bet->getUser());
        }

        return $participants;
    }

    /**
     * @param mixed $participants
     * @return self
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;

        return $this;
    }

    /**
     * @param User $participant
     */
    public function addParticipant($participant)
    {
        $this->participants[] = $participant;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     * @return self
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;

        return $this;
    }

    /**
     * @return string
     */
    public function getSportType()
    {
        return $this->sport_type;
    }

    /**
     * @param string $sport_type
     * @return self
     */
    public function setSportType($sport_type)
    {
        $this->sport_type = $sport_type;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}