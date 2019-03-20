<?php

namespace Shopsys\ShopBundle\Form\Admin;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Shopsys\FrameworkBundle\Form\Locale\LocalizedType;
use Shopsys\ShopBundle\Model\StaticBlock\StaticBlockData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class StaticBlockFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
            'code', TextType::class, [
                'label' => t('Code'),
                'constraints' => new NotBlank(),
            ])
            ->add(
                'texts', LocalizedType::class, [
                    'entry_type' => CKEditorType::class,
                ]
            )
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => StaticBlockData::class,
                'attr' => ['novalidate' => 'novalidate'],
            ]);
    }
}
