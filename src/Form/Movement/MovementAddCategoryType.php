<?php

namespace App\Form\Movement;

use App\Entity\Category;
use App\Entity\Movement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class MovementAddCategoryType extends AbstractType
{
    private string $newCategoryName = '';

    public function getNewCategoryName()
    {
        return $this->newCategoryName;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choices' => $options['categories'],
                'required' => false,
                'placeholder' => 'new_category'
            ])
            ->add('new', TextType::class, [
                'mapped' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movement::class,
            'categories' => []
        ]);

        $resolver->setAllowedTypes('categories', 'array');
    }
}
