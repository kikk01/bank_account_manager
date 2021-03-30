<?php

namespace App\Form\Movement;

use App\Entity\BankAccount;
use App\Entity\Movement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\UX\Dropzone\Form\DropzoneType;

class MovementCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bankAccount', EntityType::class, [
                'class' => BankAccount::class,
                'label' => 'select_bank_account',
                'choices' => $options['bank_accounts'],
                'choice_label' => 'name',
            ])
            ->add('accountStatement', DropzoneType::class, [
                'label' => 'Ajoutez un fichier au format csv',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '100k',
                        'mimeTypes' => [
                            'text/csv', 'text/plain'
                        ]
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movement::class,
            'bank_accounts' => []
        ]);

        $resolver->setAllowedTypes('bank_accounts', 'array');
    }
}
