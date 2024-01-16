<?php

class txaTagIframeyoutube extends txaTagBase
{
    /** @var string $key */
    public $key = 'iframeyoutube';
    /** @var string $name */
    public $name = '<iframe src="https://youtube.com/[...]"></iframe>';

    /**
     * @param string $content
     *
     * @return string
     */
    public function prepare($content)
    {
        $this->idx = 0;
        $content = preg_replace_callback('/<iframe[^>]+src=["\']*[^>]+(youtube|youtu\.be)[^>]+["\']*[^>]*>[^<]*<\/iframe>/usi',
            array($this, 'pregReplaceCallback'), $content);

        return $content;
    }
}