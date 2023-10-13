<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PHPUnit\TextUI\XmlConfiguration\Logging\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Enter your full name'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Enter your phone'
            ])
            ->add('addres', TextType::class, [
                'label' => 'Enter your addres'
            ])
            ->add('zipcode', IntegerType::class, [
                'label' => 'Enter your zipcode'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
