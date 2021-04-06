<?php

namespace App\Form;

use App\Entity\Page;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
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
            ->add('slug', TextType::class, [
                'label' => 'Page Url'
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Content Page'
            ])
            ->add('meta_title', TextType::class, [
                'label' => 'Page META TITLE'
            ])
            ->add('meta_description', TextareaType::class, [
                'label' => 'Page META DESCRIPTION'
            ])
            ->add('created_at', DateType::class, [
                'label' => 'Created At',
                'attr'  => [
                    'value' => function() {
                        $date = new \DateTime('NOW');
                        return $date->format('Y-m-d H:i');
                    }
                ]
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
