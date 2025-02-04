<?php

namespace App\Form;

use App\Entity\Enquiry;
use App\Entity\Product;
use Eckinox\TinymceBundle\Form\Type\TinymceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductEnquiryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phone', null, ['required' => false])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'data' => $options['product'], // Set the default product here
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enquiry::class,
            'product' => null, // Define the 'product' option
        ]);
    }
}
