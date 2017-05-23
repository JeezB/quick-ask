<?php

/**
 * Created by PhpStorm.
 * User: jbaron
 * Date: 20/05/2017
 * Time: 19:37
 */
namespace QuestionBundle\Form\Type;

use QuestionBundle\Entity\Suggestion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SuggestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title');
        $builder->add('isCorrect');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Suggestion::class,
        ));
    }
}