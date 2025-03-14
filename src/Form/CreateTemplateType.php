<?php

namespace App\Form;

use App\Entity\CvTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CreateTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('thumbnail', FileType::class, [
                'label' => 'Image File',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => 'image/*'],
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                        'mimeTypesMessage' => 'Please upload a valid image file (JPEG, PNG, GIF, WEBP).',
                    ])
                ],
            ])
            ->add('description')
            ->add('html')
            ->add('page_width')
            ->add('page_height')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CvTemplate::class,
        ]);
    }
}
