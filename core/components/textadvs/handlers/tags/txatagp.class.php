<?php

class txaTagP extends txaTagBase
{
    /** @var string $key */
    public $key = 'p';
    /** @var string $name */
    public $name = '<p>[...]</p>';

    /**
     * @param string $content
     *
     * @return string
     */
    public function prepare($content)
    {
        $this->idx = 0;
        $content = preg_replace_callback('/<p[^>]*>.*?<\/p>/usi', array($this, 'pregReplaceCallback'), $content);

        return $content;
    }
}