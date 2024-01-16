<?php

class txaTagOl extends txaTagBase
{
    /** @var string $key */
    public $key = 'ol';
    /** @var string $name */
    public $name = '<ol>[...]</ol>';

    /**
     * @param string $content
     *
     * @return string
     */
    public function prepare($content)
    {
        $this->idx = 0;
        $content = preg_replace_callback('/<ol[^>]*>.*?<\/ol>/usi', array($this, 'pregReplaceCallback'), $content);

        return $content;
    }
}