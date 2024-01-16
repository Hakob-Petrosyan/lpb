<?php

class txaTagHr extends txaTagBase
{
    /** @var string $key */
    public $key = 'hr';
    /** @var string $name */
    public $name = '<hr>';

    /**
     * @param string $content
     *
     * @return string
     */
    public function prepare($content)
    {
        $this->idx = 0;
        $content = preg_replace_callback('/<hr[^>]*>/usi', array($this, 'pregReplaceCallback'), $content);

        return $content;
    }
}