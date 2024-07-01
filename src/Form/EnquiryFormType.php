<?php

namespace App\Form;

use App\Entity\Enquiry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EnquiryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', null)
            ->add('lastname', null)
            ->add('phone', null)
            ->add('email', EmailType::class)
            ->add('pincode', null)
            ->add('requirement', null);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enquiry::class,
        ]);
    }
}
