<?php

require_once(dirname(__FILE__) . '/update.class.php');

class blockConstructorDisableProcessor extends blockConstructorUpdateProcessor
{
    /**
     * @return bool
     */
    public function beforeSet()
    {
        $this->properties = array(
            'active' => false,
            'noupdatefield' => true,
        );

        return true;
    }
}

return 'blockConstructorDisableProcessor';
