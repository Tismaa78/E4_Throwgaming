<?php

namespace App\Form;

use App\Entity\Jeu;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
// types de données
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
// verif
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
// relations
use App\Entity\Genre;
use App\Entity\Console;
use App\Entity\Editeur;

class JeuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un titre',
                    ]),
                ],
                "attr"=>["placeholder"=>"Saisir le nom du jeu"],
                "required"=>true
            ])
            ->add('prix', MoneyType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un prix',
                    ]),
                ],
                "attr"=>["placeholder"=>"Saisir le prix du jeu"],
                "currency"=>"EUR",
                "required"=>true
            ])
            ->add('image', UrlType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une url vers une image',
                    ]),
                ],
                "attr"=>["placeholder"=>"Url vers l'image du jeu"],
                "required"=>false
            ])
            ->add('description', TextAreaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une description',
                    ]),
                ],
                "attr"=>["placeholder"=>"Description du jeu"],
                "required"=>false
            ])
            ->add('date', IntegerType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir une date en format "AAAA"',
                    ]),
                ],
                "required"=>true
            ])
            ->add('genre', EntityType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un genre',
                    ]),
                ],
                "class"=>Genre::class,
                "choice_label"=>"libelle",
                "required"=>true
            ])
            ->add('editeur', EntityType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner un editeur',
                    ]),
                ],
                "class"=>Editeur::class,
                "choice_label"=>"nom",
                "required"=>true
            ])
            ->add('consoles', EntityType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner une ou des consoles',
                    ]),
                ],
                "class"=>Console::class,
                // "query_builder"=>function(ConsoleRepository $rep){
                //     return $rep->findAllQ();
                // },
                "choice_label"=>"nom",
                "multiple" => true,
                "expanded" => false,
                "required"=>true,
                "by_reference"=>false,
                "attr"=>["class"=>"selection"]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jeu::class,
        ]);
    }
}
