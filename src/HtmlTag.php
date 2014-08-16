<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 * @author Smotrov Dmitriy <dsxack@gmail.com>
 */

namespace PetrGrishin\HtmlTag;


use CHtml;

class HtmlTag {
    const TAG_DIV = 'div';

    private $htmlOptions = array();
    private $tagName;
    private $content;

    /**
     * @param string $tagName
     * @param array $htmlOptions
     * @return static
     */
    public static function create($tagName = self::TAG_DIV, array $htmlOptions = array()) {
        /** @var $htmlTag HtmlTag */
        $htmlTag = new static();

        return $htmlTag
            ->setTagName($tagName)
            ->setHtmlOptions($htmlOptions);
    }

    public function begin() {
        ob_start();
        return $this;
    }

    /**
     * @param bool $return
     * @return $this|string
     */
    public function end($return = false) {
        $this->content = ob_get_clean();

        if ($return) {
            return $this->toS();
        }

        echo $this->toS();
        return $this;
    }

    /**
     * Output content
     * @return string
     */
    public function run() {
        $s = $this->toS();
        echo $s;
        return $s;
    }

    /**
     * @return string
     */
    public function toS() {
        ob_start();
        echo CHtml::openTag($this->getTagName(), $this->getHtmlOptions());
        echo $this->content;
        echo CHtml::closeTag($this->getTagName());
        return ob_get_clean();
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->toS();
    }

    /**
     * @return $this
     */
    public function addClass() {
        $classes = explode(' ', isset($this->htmlOptions['class']) ? trim($this->htmlOptions['class']) : '');
        $classes = array_merge($classes, func_get_args());
        $this->htmlOptions['class'] = trim(implode(' ', array_unique($classes)));
        return $this;
    }

    /**
     * @param $className
     * @return $this
     */
    public function removeClass($className) {
        $classes = explode(" ", $this->htmlOptions["class"]);
        $this->htmlOptions["class"] = trim(implode(" ", array_diff($classes, array($className))));
        return $this;
    }

    public function addAttr($name, $value) {
        return $this->setAttr($name, $value);
    }

    public function setAttr($name, $value) {
        if (!isset($value)) {
            throw new Exception\HtmlTagException("Value is not set for attr `{$name}`");
        }
        $this->htmlOptions[$name] = $value;
        return $this;
    }

    public function getAttr($name) {
        if (!array_key_exists($name, $this->htmlOptions)) {
            throw new Exception\HtmlTagException(sprintf('Attr `%s` not exists', $name));
        }
        return $this->htmlOptions[$name];
    }

    /**
     * @param $name
     * @return $this
     */
    public function removeAttr($name) {
        unset($this->htmlOptions[$name]);
        return $this;
    }

    /**
     * @return string
     */
    protected function getTagName() {
        return $this->tagName;
    }

    /**
     * @param string $tagName
     * @return $this
     */
    public function setTagName($tagName) {
        $this->tagName = $tagName;
        return $this;
    }

    /**
     * @return array
     */
    public function getHtmlOptions() {
        return $this->htmlOptions;
    }

    /**
     * @param array $htmlOptions
     * @return $this
     */
    public function setHtmlOptions(array $htmlOptions = array()) {
        $this->htmlOptions = array_merge($this->htmlOptions, $htmlOptions);
        return $this;
    }

    /**
     * @return HtmlTag
     */
    public function copy() {
        return clone $this;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
}
 