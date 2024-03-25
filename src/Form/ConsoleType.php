<?php

namespace App\Form;

use App\Entity\Jeu;
use App\Entity\Console;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ConsoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "attr"=>["placeholder"=>"Saisir le nom du jeu"],
                "required"=>true
            ])
            ->add('image', UrlType::class, [
                "attr"=>["placeholder"=>"Url vers l'image du jeu"],
                "required"=>false
            ])
            ->add('date', IntegerType::class, [
                "required"=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Console::class,
        ]);
    }
}
