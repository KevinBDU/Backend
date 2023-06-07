<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Categories;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TaskType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array
    $options)
    {
        $builder
            ->add('nameTask', TextType::class, array('label' => 'Nom de la 
tâche', 'attr' => array(
                'class' => 'form-control',
                'title' => 'Nom de la tâche',
            )))
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.libelleCategory', 'ASC');
                },
                'choice_label' => 'libelleCategory',
                'label' => 'Catégorie',
                'attr' => array(
                    'class' => 'form-control',
                    'title' => 'Catégorie'
                )
            ])
            ->add(
                'descriptionTask',
                TextareaType::class,
                array('label' => 'Description', 'attr' => array(
                    'class' => 'form-control',
                    'title' => 'Description',
                ))
            )
            ->add(
                'priorityTask',
                ChoiceType::class,
                array(
                    'label' => 'Priorité',
                    'choices' => array(
                        'Basse' => 'Basse',
                        'Normale' => 'Normale',
                        'Haute' => 'Haute'
                    ),
                    'attr' => array(
                        'class' => 'form-control',
                        'title' => 'Priorité',
                    )
                )
            )
            ->add('dueDateTask', DateTimeType::class, array('label' => 'Date 
effective', 'attr' => array(
                'class' => 'formcontrol',
                'title' => 'Date effective'
            )));

        $builder->add('save', SubmitType::class, array(
            'label' => 'Enregistrer',
            'attr' => array(
                'class' => 'btn btn-primary btn-margin',
                'title' => 'Enregistrer'
            )
        ));
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Task',
            'route' => null
        ));
    }
}
