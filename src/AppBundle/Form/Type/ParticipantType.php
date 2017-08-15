<?php
namespace AppBundle\Form\Type;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ParticipantType
 * @package AppBundle\Form\Type
 */
class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user_id', HiddenType::class, array(
            'mapped' => false,
        ));
        $builder->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event){
            $event->getForm()
                ->add('user_id', HiddenType::class, array(
                    'mapped' => false,
                    'data' => $event->getData() ? $event->getData()->getId() : null,
                ))
            ;
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
