<?php

namespace App\Form;

use App\Entity\Coach;
use App\Entity\Member;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', PasswordType::class)
            ->add('firstName')
            ->add('lastName')
            ->add('adresse')
            ->add('telephone')
            ->add('email',EmailType::class)
            ->add('photo',FileType::class)
            ->add('role',ChoiceType::class, [
                'choices'  => [
                    'Vendor'=>'Vendor',
                    'Member'=>'Member',
                    'Coach'=>'Coach',
                ],

            ])
        ->add('captcha', CaptchaType::class, array(
        'width' => 200,
        'height' => 50,
        'length' => 6,
    ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
    /*public function getName()
    {
        return 'array_choice';
    }*/

}
