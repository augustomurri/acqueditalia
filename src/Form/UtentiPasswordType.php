<?php

namespace App\Form;

use App\Entity\Utenti;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtentiPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field', 'autocomplete' => 'new-password']],
                'required' => false,
                'first_options'  => [
                    'label' => 'Password',
                    'attr' => [
                        'class' => 'forms-control forms-control-g',
                        'placeholder' => 'Password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Ripeti Password',
                    'attr' => [
                        'class' => 'forms-control forms-control-lg',
                        'placeholder' => 'Ripeti password'
                    ]
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utenti::class,
        ]);
    }
}
