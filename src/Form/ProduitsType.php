<?php

namespace App\Form;

use App\Entity\Produits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;




class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('descriptionProd')
            ->add('price')
            ->add('photoProd')
            ->add('stock')
            ->add('idVendor')
            ->add('captcha', CaptchaType::class)


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
