<?php
namespace AppBundle\Form;

use AppBundle\Entity\Bet;
use AppBundle\Form\Type\ParticipantType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $sport_types = $options['sport_types'];
        /** @var Bet $bet */
        $bet = $builder->getData();
        $builder
            ->add('name')
            ->add('description')
            ->add('amount')
            ->add('type')
            ->add('sport_type', ChoiceType::class, array(
                'choices' => $sport_types,
            ))
            ->add('start_date', DateTimeType::class, array(
                'data' => $bet ? $bet->getStartDate() : (new \DateTime()),
            ))
            ->add("participants", CollectionType::class, array(
                'entry_type' => ParticipantType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => ['label'=>false],
                'mapped' => false,
                'data' => $bet ? $bet->getParticipants() : null,
                'label' => false,
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Bet::class,
            'sport_types' => array(),
        ));
    }
}