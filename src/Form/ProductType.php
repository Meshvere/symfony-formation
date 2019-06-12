<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\TaxRate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class,  ['label'=>'Libellé', 'required' => true])
            ->add('description', TextType::class,  ['label'=>'Description'])
            ->add('slug', TextType::class,  ['label'=>'Slug', 'required' => true])
            ->add('price', MoneyType::class,  ['label'=>'Prix', 'required' => true, 'divisor' => 100])
            ->add('enable', CheckboxType::class,  ['label'=>'Actif ?', 'required' => true])
            ->add('taxRate', EntityType::class,  ['label'=>false, 'choice_label'=>'label', 'class' => TaxRate::class, 'attr'=>['class' => 'browser-default'], 'required' => true])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
