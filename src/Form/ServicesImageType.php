<?php

namespace App\Form;

use App\Entity\Services;
use App\Entity\ServicesMedia;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ServicesImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true, // allows you to delete the image
                'download_uri' => true, // enables download link
            ])
        ;
    }
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if($view->vars['value']) {
            $view->vars['help'] = "<span class='attach-img-preview' data-src='{$view->vars['value']->getWebPath()}'></span>";
        }
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServicesMedia::class,
        ]);
    }
}
