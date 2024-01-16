<?php

require_once(dirname(__FILE__) . '/update.class.php');

class blockFieldEnableProcessor extends blockFieldUpdateProcessor
{
    /**
     * @return bool
     */
    public function beforeSet()
    {
        $this->properties = array(
            'active' => true,
        );

        return true;
    }

}

return 'blockFieldEnableProcessor';
