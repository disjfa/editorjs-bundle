<?php


namespace Disjfa\EditorjsBundle\Form\DataTransformer;

use EditorJS\EditorJS;
use EditorJS\EditorJSException;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EditorjsTransformer implements DataTransformerInterface
{
    /**
     * @var array
     */
    private $tools;

    /**
     * @param array $tools
     */
    public function __construct(array $tools)
    {
        $this->tools = $tools;
    }

    /**
     * @param mixed $formData
     * @return false|mixed|string
     */
    public function transform($formData)
    {
        return json_encode($formData);
    }

    /**
     * @param string $string
     * @return mixed|void
     */
    public function reverseTransform($string)
    {
        try {
            new EditorJS($string, json_encode([
                'tools' => $this->tools,
            ]));
            return json_decode($string, true);
        } catch (EditorJSException $e) {
            throw new TransformationFailedException($e->getMessage());
        }
    }
}
