<?php

require_once(dirname(__FILE__) . '/update.class.php');

class blockConstructorEnableProcessor extends blockConstructorUpdateProcessor
{
    
    /**
     * @return bool
     */
    public function beforeSet()
    {
        $this->properties = array(
            'active' => true,
            'noupdatefield' => true,
        );

        return true;
    }

}

return 'blockConstructorEnableProcessor';
