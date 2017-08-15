<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Bet;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @param Bet $bet
     * @return array
     * @TODO doesn't work
     */
    public function findAllNotBoundToBet(Bet $bet)
    {
        $current_participants = $bet->getUserBets()->filter(function ($user_bet){
            return $user_bet;
        });

        $qb = $this->createQueryBuilder('u');
        $qb
            ->select('u')
            ->where($qb->expr()->notIn('u.bets', $current_participants));

        return $qb->getQuery()->getResult();
    }
}