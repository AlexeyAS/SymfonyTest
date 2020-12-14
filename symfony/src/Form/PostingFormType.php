<?php

namespace App\Form;

use App\Entity\Posting;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PostingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('subject', TextType::class, [
                //'mapped' => false,
                'constraints' => [
					new NotBlank([
						'message' => 'Введи тему',
					]),
					new Length([
						'min' => 3,
						'minMessage' => 'Тема должна содержать не менее {{ limit }} символов',
						// max length allowed by Symfony for security reasons
						'max' => 100,
						'maxMessage' => 'Тема должна содержать не более {{ limit }} символов',
					]),
                ],
				'required' => false,

            ])
            ->add('message', TextareaType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                //'mapped' => false,

				'constraints' => [
                    new NotBlank([
                        'message' => 'Введи сообщение',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'Сообщение должно содержать не менее {{ limit }} символов',
                        // max length allowed by Symfony for security reasons
                        'max' => 1024,
                    ]),
                ],
				'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posting::class,
        ]);
    }
}
