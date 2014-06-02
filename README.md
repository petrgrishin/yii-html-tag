yii-html-tag
============

Builder to create a html tag, an object-oriented approach

Installation
------------
Add a dependency to your project's composer.json:
```json
{
    "require": {
        "petrgrishin/yii-html-tag": "dev-master"
    }
}
```

Usage examples
--------------
#### Create tag
```php
use \PetrGrishin\HtmlTag\HtmlTag;

$tag = HtmlTag::create(HtmlTag::TAG_DIV, array('class' => 'content'))->begin();
$tag->addClass('well');

printf('content');

$tag->end();
// output: <div class="content well">content</div>
```