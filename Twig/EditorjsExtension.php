<?php

namespace Disjfa\EditorjsBundle\Twig;

use EditorJS\EditorJS;
use EditorJS\EditorJSException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class EditorjsExtension extends AbstractExtension
{
    /**
     * @var array
     */
    private $tools;

    public function __construct(array $tools)
    {
        $this->tools = $tools;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('editorjs', [$this, 'renderEditorjs'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param $value
     * @return string
     */
    public function renderEditorjs($value)
    {
        try {
            $tmp = new EditorJS(json_encode($value), json_encode([
                'tools' => $this->tools
            ]));
        } catch (EditorJSException $e) {
            return '';
        }
        $html = '';
        foreach ($tmp->getBlocks() as $block) {
            switch ($block['type']) {
                case 'paragraph':
                    $html .= '<p>' . $block['data']['text'];
                    break;
                case 'list':
                    $tag = $block['data']['style'] === 'ordered' ? 'ol' : 'ul';
                    $html .= sprintf('<%s>', $tag);
                    foreach ($block['data']['items'] as $item) {
                        $html .= sprintf('<li>%s</li>', $item);
                    }
                    $html .= sprintf('</%s>', $tag);
                    break;
                case 'header':
                    $html .= sprintf('<h%d>%s</h%d>', $block['data']['level'], $block['data']['text'], $block['data']['level']);
                    break;
                default:
                    dump($block);
                    break;
            }
        }
        return $html;
    }
}
