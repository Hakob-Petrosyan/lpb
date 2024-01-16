<?php

class txaContent extends xPDOSimpleObject
{
    /**
     * @param null $cacheFlag
     *
     * @return bool
     */
    public function save($cacheFlag = null)
    {
        if (!$this->xpdo->getCount('txaContent', array('object' => $this->get('object'), 'current' => true))) {
            $this->set('current', true);
        }

        return parent::save($cacheFlag);
    }
}