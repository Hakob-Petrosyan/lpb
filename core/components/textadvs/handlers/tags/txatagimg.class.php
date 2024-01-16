<?php

class txaTagImg extends txaTagBase
{
    /** @var string $key */
    public $key = 'img';
    /** @var string $name */
    public $name = '<img src="[...]"/>';

    /**
     * @param string $content
     *
     * @return string
     */
    public function prepare($content)
    {
        $this->idx = 0;
        $content = preg_replace_callback('/<img[^>]+src[^=]*=[^>]+>/usi', array($this, 'pregReplaceCallback'), $content);

        return $content;
    }
}