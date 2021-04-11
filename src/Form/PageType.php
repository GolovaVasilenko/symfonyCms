<?php

namespace App\Form;

use App\Entity\Page;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Page title'
            ])
            ->add('body', CKEditorType::class, [
                'label' => 'Content Page'
            ])
            ->add('meta_title', TextType::class, [
                'label' => 'Page META TITLE'
            ])
            ->add('meta_description', TextareaType::class, [
                'label' => 'Page META DESCRIPTION'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create Page',
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
