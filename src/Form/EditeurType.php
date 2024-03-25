<?php

namespace App\Form;

use App\Entity\Editeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditeurType extends AbstractType
{
    private $defaultinp = "w-full border p-2 rounded";

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('nom', TextType::class, [
                "attr"=>[
                    "placeholder"=>"Saisir le nom",
                    "class"=>$this->defaultinp
                ],
                "required" => false,
            ])


            ->add('logo', TextType::class, [
                "attr"=>[
                    "placeholder"=>"Saisir l'url",
                    "class"=>$this->defaultinp
                ],
                "required" => true,
            ])
            ->add('description', TextareaType::class, [
                "attr"=>[
                    "placeholder"=>"Saisir la description",
                    "class"=>$this->defaultinp
                ],
                "required" => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Editeur::class,
        ]);
    }
}