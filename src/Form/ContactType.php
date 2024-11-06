<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    const NAME_FIELD_CLASS = 'form-control form-control-responsive form-control-lg bg-transparent text-white border-white';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => self::NAME_FIELD_CLASS,
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => self::NAME_FIELD_CLASS,
                    'minlength' => '2',
                    'maxlength' => '50',
                ],
                'label' => 'Prenom',
                'label_attr' => [
                    'class' => 'form-label'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => self::NAME_FIELD_CLASS,
                    'minlength' => '2',
                    'maxlength' => '180',
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min' => 2, 'max' => 180])
                ]
            ])
            ->add('contact_reason', ChoiceType::class, [
                'attr' => [
                    'class' => self::NAME_FIELD_CLASS,
                ],
                'label' => 'Quelle boite possédez-vous ?',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Grec VS Mésopotamien' => 'Grec VS Mésopotamien',
                    'Egyptien VS Slave' => 'Egyptien VS Slave',
                    'Je possède les deux !' => 'Je possède les deux !',
                    'Je n\'en possède pas encore !' => 'Je n\'en possède pas encore !',
                ],
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => self::NAME_FIELD_CLASS,
                ],
                'label' => 'Message',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn text-center text-white border'
                ],
                'label' => 'Envoyer'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
