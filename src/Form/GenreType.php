<?php

namespace App\Form;

use App\Entity\Genre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;

class GenreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                "constraints"=>[
                    new NotBlank([
                        'message' => 'Veuillez saisir un libelle',
                    ]),
                ],
                "attr"=>[
                    "placeholder"=>"Saisir le nom du genre",
                ],
                "required" => true,
            ])
            ->add('couleur', ColorType::class, [
                "constraints"=>[
                    new NotBlank([
                        'message' => 'Veuillez donner une couleur au genre',
                    ]),
                ],
                "attr"=>[
                    "placeholder"=>"ex: red",
                ],
                "required" => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Genre::class,
        ]);
    }
}
