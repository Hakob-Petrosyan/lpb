<?php

class txaTagUl extends txaTagBase
{
    /** @var string $key */
    public $key = 'ul';
    /** @var string $name */
    public $name = '<ul>[...]</ul>';

    /**
     * @param string $content
     *
     * @return string
     */
    public function prepare($content)
    {
        $this->idx = 0;
        $content = preg_replace_callback('/<ul[^>]*>.*?<\/ul>/usi', array($this, 'pregReplaceCallback'), $content);

        return $content;
    }
}