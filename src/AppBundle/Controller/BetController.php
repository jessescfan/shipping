<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bet;
use AppBundle\Entity\User;
use AppBundle\Entity\UserBet;
use AppBundle\Form\BetType;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BetController extends Controller
{
    /**
     * @Route("/bets", name="bets")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $bets = $em->getRepository('AppBundle:Bet')->findAll();
        $participant_forms = array();

        /** @var UserBet $user_bet */
        foreach ($user->getBets() as $user_bet) {
            $state_date = $user_bet->getBet()->getStartDate();
            $now = (new \DateTime());
            $disabled = $state_date < $now;
            $participant_forms[] = $this->createFormBuilder($user_bet, ['disabled' => $disabled])
                ->add('prediction', TextType::class, array())
                ->add('save', SubmitType::class, array())
                ->setAction($this->generateUrl('participant_update', ['id'=>$user_bet->getId()]))
                ->setMethod('POST')
                ->getForm()
                ->createView();
        }

        return array(
            'bets' => $bets,
            'user' => $user,
            'participant_forms' => $participant_forms
        );
    }

    /**
     * @Route("/bets/new", name="new_bet")
     * @Template()
     *
     * @param Request $request
     * @return array | RedirectResponse
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sport_types = $em->getRepository('AppBundle:SportType')->findBy(array(), array('name'=>'ASC'));
        $sport_types_array = array_map(function($sport_type) {
            return $sport_type->getName();
        }, $sport_types);
        $form = $this->createForm(BetType::class, null, ['sport_types'=>array_flip($sport_types_array)]);
        $all_users = $em->getRepository('AppBundle:User')->findAll();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $bet = $form->getData();
            foreach ($form->get('participants') as $participant) {
                $user_id = $participant->get('user_id')->getData();
                $user = $em->getRepository('AppBundle:User')->find($user_id);
                $user_bet = new UserBet();
                $user_bet->setBet($bet);
                $user_bet->setUser($user);
                $em->persist($user_bet);
            }

            $em->persist($bet);
            $em->flush();
            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('bets');
        }
        $bets = $em->getRepository('AppBundle:Bet')->findAll();

        return array(
            'form' => $form->createView(),
            'bets' => $bets,
            'all_users' => $all_users
        );
    }

    /**
     * @Route("/bets/edit/{id}", name="edit_bet")
     * @Template()
     * @param Request $request
     * @param Bet     $bet
     *
     * @return array | RedirectResponse
     */
    public function editAction(Request $request, Bet $bet)
    {
        $em = $this->getDoctrine()->getManager();
        $sport_types = $em->getRepository('AppBundle:SportType')->findBy(array(), array('name'=>'ASC'));
        $sport_types_array = array_map(function($sport_type) {
            return $sport_type->getName();
        }, $sport_types);

        $form = $this->createForm(BetType::class, $bet, ['sport_types'=>array_flip($sport_types_array)]);
        $all_users = $em->getRepository('AppBundle:User')->findAll();
        $assigned_users = array();
        foreach ($bet->getParticipants() as $user) {
            $assigned_users[$user->getId()] = $user->getFullName();
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $new_bet = $form->getData();
            $current_participants = $new_bet->getParticipants()->toArray();
            $new_participants = array();
            foreach ($form->get('participants') as $participant) {
                $user_id = $participant->get('user_id')->getData();
                $user = $em->getRepository('AppBundle:User')->find($user_id);
                $new_participants[] = $user;
                // add new participant
                if (false === in_array($user, $current_participants)) {
                    $user_bet = new UserBet();
                    $user_bet->setBet($new_bet);
                    $user_bet->setUser($user);
                    $em->persist($user_bet);
                }
            }

            /** @var User $current_participant */
            foreach ($current_participants as $current_participant) {
                if (false === in_array($current_participant, $new_participants)) {
                    foreach ($bet->getUserBets() as $user_bet) {
                        if ($user_bet->getUser() === $current_participant) {
                            $em->remove($user_bet);
                            $em->flush();
                        }
                    }
                }
            }

            $em->persist($new_bet);
            $em->flush();
            $this->addFlash('success', 'Saved!');

            return $this->redirectToRoute('bets');
        }

        return array(
            'form' => $form->createView(),
            '$bet' => $bet,
            'all_users' => $all_users,
            'assigned_users' => $assigned_users
        );
    }
}
