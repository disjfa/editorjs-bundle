<?php


namespace Disjfa\EditorjsBundle\Form\Type;

use Disjfa\EditorjsBundle\Form\DataTransformer\EditorjsTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditorjsType extends AbstractType
{
    /**
     * @var EditorjsTransformer
     */
    private $transformer;

    /**
     * @param EditorjsTransformer $transformer
     */
    public function __construct(EditorjsTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->transformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'invalid_message' => 'The content could not be parsed',
        ]);
    }

    /**
     * @return string|null
     */
    public function getParent()
    {
        return TextareaType::class;
    }
}
