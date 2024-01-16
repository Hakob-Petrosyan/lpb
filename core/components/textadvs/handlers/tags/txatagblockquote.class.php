<?php

class txaTagBlockquote extends txaTagBase
{
    /** @var string $key */
    public $key = 'blockquote';
    /** @var string $name */
    public $name = '<blockquote>[...]</blockquote>';

    /**
     * @param string $content
     *
     * @return string
     */
    public function prepare($content)
    {
        $this->idx = 0;
        $content = preg_replace_callback('/<blockquote[^>]*>.*?<\/blockquote>/usi', array($this, 'pregReplaceCallback'), $content);

        return $content;
    }
}