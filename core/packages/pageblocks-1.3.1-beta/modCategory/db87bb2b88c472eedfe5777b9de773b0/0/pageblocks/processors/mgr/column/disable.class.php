<?php

require_once(dirname(__FILE__) . '/update.class.php');

class pbTableColumnDisableProcessor extends pbTableColumnUpdateProcessor
{
    /**
     * @return bool
     */
    public function beforeSet()
    {
        $this->properties = array(
            'active' => false,
        );

        return true;
    }
}

return 'pbTableColumnDisableProcessor';
