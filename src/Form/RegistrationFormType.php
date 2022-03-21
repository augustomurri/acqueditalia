<?php

namespace App\Form;

use App\Entity\Utenti;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label'   => false,
                'attr' => array(
                    'placeholder' => 'Email'
                )
            ])
            ->add('condizioni', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field', 'autocomplete' => 'new-password']],
                'required' => true,
                'label' => false,
                'first_options'  => [
                    'label' => false,
                    'attr' => [
                        'class' => 'forms-control forms-control-lg forms-control-alt py-3',
                        'placeholder' => 'Password'
                    ]
                ],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'class' => 'forms-control forms-control-lg forms-control-alt py-3',
                        'placeholder' => 'Ripeti password'
                    ]
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utenti::class,
        ]);
    }
}
