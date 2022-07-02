<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('Nom', TextType::class)

            ->add('Prenom', TextType::class)  //sans accent

            ->add('Email', EmailType::class)

            ->add(
                'Telephone',
                NumberType::class
            ) //[0-9]{1,10}[0-9]

            ->add('Type', ChoiceType::class, [
                'label' => 'Objet de la demande',
                'choices' => [
                    'Informations' => 'Informations',
                    'Adhésion' => 'Adhésion',
                    'Aide' => 'Aide',
                    'Autre' => 'Autre'
                ]

            ])


            ->add('Message', TextareaType::class, ['label' => 'Votre Message'])

            ->add('Envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-outline-dark', 'far icon' => 'paper-plane']
            ])

            //. \PHP_EOL .

            ->add('Vider', ResetType::class, [
                'attr' => ['class' => 'btn btn-outline-dark']
            ]);

        //  ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
