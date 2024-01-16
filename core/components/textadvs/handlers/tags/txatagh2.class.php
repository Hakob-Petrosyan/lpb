<?php

class txaTagH2 extends txaTagBase
{
    /** @var string $key */
    public $key = 'h2';
    /** @var string $name */
    public $name = '<h2>[...]</h2>';

    /**
     * @param string $content
     *
     * @return string
     */
    public function prepare($content)
    {
        $this->idx = 0;
        $content = preg_replace_callback('/<h2[^>]*>.*?<\/h2>/usi', array($this, 'pregReplaceCallback'), $content);

        return $content;
    }
}