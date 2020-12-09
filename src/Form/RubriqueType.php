<?php

namespace App\Form;

use App\Entity\Rubrique;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RubriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('dropdown')
            ->add('redacteur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom',
                'query_builder' =>
                    function (UtilisateurRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orwhere('u.roles = \'["ROLE_REDACTEUR"]\'')
                        ->orWhere('u.roles = \'["ROLE_ADMIN"]\'')
                        ->orderBy('u.nom', 'asc');
                    },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rubrique::class,
        ]);
    }
}
