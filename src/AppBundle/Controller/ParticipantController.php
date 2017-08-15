<?php
/**
 * Created by PhpStorm.
 * User: nachoe
 * Date: 4/28/17
 * Time: 6:25 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\UserBet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ParticipantController extends Controller
{
    /**
     * @Route("/participant/update/{id}", name="participant_update")
     * @Template()
     *
     * @param Request $request
     * @param UserBet $participant
     * @return array | RedirectResponse
     */
    public function updateAction(Request $request, UserBet $participant)
    {
        /** @var Form $form */
        $form = $this->createFormBuilder($participant)
            ->add('prediction', TextType::class, array())
            ->add('save', SubmitType::class, array())
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user_bet = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user_bet);
            $em->flush();
            return $this->redirectToRoute('bets');
        }

        return $this->redirectToRoute('bets');
    }
}