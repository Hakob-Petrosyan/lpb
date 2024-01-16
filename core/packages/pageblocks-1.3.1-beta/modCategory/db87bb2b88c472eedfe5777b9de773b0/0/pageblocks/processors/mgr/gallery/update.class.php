<?php

class PageBlocksFileUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'blockFile';
    public $languageTopics = array('default');
//    public $permission = 'pageblocksfile_save';

    public $path = null;
    public $old_url = null;
    public $old_filename = null;
    public $old_name = null;

    /** @var PageBlocks $pb */
    public $pb;


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::initialize();
    }

    /**
     * @return array|bool|string
     */
    public function beforeSet()
    {
        $data = $this->object->toArray();
        $this->path = $data['path'];
        $this->old_filename = $data['filename'];
        $this->old_name = $data['name'];
        $this->old_url = $data['url'];

        // Проверяем название файла
        if ($this->modx->getObject($this->classKey,[
            'resource_id' => $data['resource_id'],
            'context_key' => $data['context_key'],
            'cultureKey' => $data['cultureKey'],
            'block_id' => $data['block_id'],
            'field_id' => $data['field_id'],
            'name' => $this->properties['name'],
            'id:!=' => $this->properties['id']
        ])) {
            $this->addFieldError('name', $this->modx->lexicon('pb_gallery_filename_err_ae'));
        } else {
            $this->setProperty('name', $this->properties['name']);
        }

        return parent::beforeSet();
    }

}

return 'PageBlocksFileUpdateProcessor';