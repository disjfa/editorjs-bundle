# EditorJS bundle

Add editorjs to your symfony project

## Instalation

Basic example of a symfony 4 setup

Add repository
```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/disjfa/editorjs-bundle"
        }
    ],
```

```
composer req disjfa/editorjs-bundle:dev-master
```

## Configuration

Add this in your `config/parameters/disjfa_editorjs.yaml`

```yaml
disjfa_editorjs:
    tools:
        paragraph:
            text:
                type: 'string'
                allowedTags: 'i,b,u,a[href]'
        list:
            style:
                type: 'string'
                canBeOnly: ['ordered', 'unordered']
            items:
                type: 'array'
                data:
                    '-':
                        type: 'string'
                        'allowedTags': 'i,b,u,a[href]'
        header:
            text:
                type: 'string'
                allowedTags: ''
            level:
                type: 'int'
                canBeOnly: [1,2,3,4,5,6]

```

## Doctine

Add an item using the json type

```php
<?php

...
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Article
{
    /**
     * @ORM\Column(type="json")
     */
    private $content = [];
}
```

## In a form

Add a field to your form using the EditorjsType

```php
<?php

...
use Disjfa\EditorjsBundle\Form\Type\EditorjsType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', EditorjsType::class);
    }
}
```

## twig

```twig
{{ article.content | editorjs }}
```

## javascript

Setup your editorjs setup using above config and play.

```javascript
var tmp = document.getElementById('article_content');
var newElement = document.createElement('div');
newElement.id = 'article_content_aa';
tmp.parentNode.appendChild(newElement);
tmp.style.display = 'none';
var data = JSON.parse(tmp.value);
var editor = new EditorJS({
  holder: 'article_content_aa',
  data,
  tools: {
    list: {
      class: List,
      inlineToolbar: true,
    },
    header: Header,
  },
});
tmp.form.addEventListener('submit', function (evt) {
  editor.save().then((outputData) => {
    tmp.value = JSON.stringify(outputData);
  }).catch((error) => {
    console.log('Saving failed: ', error)
  });
});
```
