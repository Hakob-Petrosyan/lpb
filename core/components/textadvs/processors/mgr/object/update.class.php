<?php

class txaObjectUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'txaObject';
    public $classKey = 'txaObject';
    public $languageTopics = array('textadvs:default');
    public $permission = 'save';
    /** @var textAdvs $txa */
    protected $txa;

    /**
     * @return bool
     */
    public function initialize()
    {
        $this->txa = $this->modx->getService('textadvs', 'textAdvs',
            $this->modx->getOption('txa_core_path', null, MODX_CORE_PATH . 'components/textadvs/') . 'model/textadvs/');
        $this->txa->initialize($this->modx->context->key);

        return parent::initialize();
    }

    /**
     * @return bool|string
     */
    public function beforeSave()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::beforeSave();
    }

    /**
     * @return bool
     */
    public function beforeSet()
    {
        if (!$id = (int)$this->getProperty('id')) {
            return $this->modx->lexicon('txa_err_ns');
        }

        if (($tmp = $this->prepareProperties()) !== true) {
            return $tmp;
        }
        unset($tmp);

        // Проверяем на заполненность
        $required = array(
            'name:txa_err_required_name',
            'position',
            'tag',
            'index',
        );
        $this->txa->tools->checkProcessorRequired($this, $required, 'txa_err_required');

        // Проверяем на уникальность
        $unique = array(
            'name:txa_err_unique_name',
        );
        $this->txa->tools->checkProcessorUnique('', 0, $this, $unique, 'txa_err_unique');

        return parent::beforeSet();
    }

    /**
     * @return string|bool
     */
    public function prepareProperties()
    {
        $properties = $this->getProperties();
        // return print_r($properties, 1);

        // Вычисляем idx
        // $properties['idx'] = $this->modx->getCount($this->classKey, array('id:!=' => 0));
        // ++$properties['idx'];

        $properties['template'] = is_numeric($properties['template']) ? $properties['template'] : null;

        // return print_r($properties, 1);
        $this->setProperties($properties);

        return true;
    }
}

return 'txaObjectUpdateProcessor';