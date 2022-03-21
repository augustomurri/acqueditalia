<?php

namespace App\Form;

use App\Entity\Comuni;
use App\Entity\Utenti;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtentiManageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isVerified', CheckboxType::class, [
                'label' => 'Verificato'
            ])
            ->add('attivo')
            ->add('gestore', EntityType::class, [
                'class' => Utenti::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.gestore is NULL')
                        ->orderBy('u.nome', 'ASC');
                },
            ])
            ->add('ruolo')
            ->add('apitoken', TextType::class, [
                'attr' => array(
                    'readonly' => true
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utenti::class,
        ]);
    }
}
