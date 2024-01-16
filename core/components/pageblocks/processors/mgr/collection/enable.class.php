<?php

require_once(dirname(__FILE__) . '/update.class.php');

class blockCollectionEnableProcessor extends blockCollectionUpdateProcessor
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

return 'blockCollectionEnableProcessor';
