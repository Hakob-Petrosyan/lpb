<?php

class blockTableValueDisableProcessor extends modProcessor
{
    public $classKey = 'blockTableValue';

    /**
    * @return array|string
    */
    public function process()
    {
        if ($table = $this->modx->getObject($this->classKey, $this->properties['id'])) {
            $table->set('active', 0);
            if ($table->save()) {
                return $this->success();
            }
        }

        return $this->failure();
    }

}

return 'blockTableValueDisableProcessor';
