<?php

class blockConstructorUpdateProcessor extends modObjectUpdateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockConstructor';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'save';

    public $old_chunk = '';


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        return parent::initialize();
    }


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $id = (int) $this->properties['id'];
        if (empty($id)) {
            return $this->modx->lexicon('pb_err_ns');
        }

        $name = trim($this->properties['name']);
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name, 'id:!=' => $id])) {
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_ae'));
        }

//        $chunk = trim($this->properties['chunk']);
//        if (empty($chunk)) {
//            $this->modx->error->addField('chunk', $this->modx->lexicon('pb_chunk_err_name'));
//        } elseif ($this->modx->getCount($this->classKey, ['chunk' => $chunk, 'id:!=' => $id])) {
//            $this->modx->error->addField('chunk', $this->modx->lexicon('pb_chunk_err_ae'));
//        }

        $this->old_chunk = $this->object->chunk;

        return parent::beforeSet();
    }

    /**
     * @return bool
     */
    public function afterSave()
    {
        $create_chunk = $this->modx->getOption('pageblocks_create_chunk');
        // Если название чанка изменили
        if ($this->old_chunk != $this->object->chunk) {

            // Обновляем имя чанка в блоках
            $blocks = $this->object->getMany('Blocks');
            foreach ($blocks as $block) {
                $block->set('chunk', $this->object->chunk);
                $block->save();
            }
        }

        if ($create_chunk && !empty($this->properties['chunk_code'])) {
            $categoryChunkId = 0;
            if($category = $this->modx->getObject('modCategory', ['category' => 'PageBlocks'])) {
                $categoryChunkId = $category->id;
            }

            // Обновляем код чанка
            if (!$chunk = $this->modx->getObject('modChunk', ['name' => $this->old_chunk])) {
                $chunk = $this->modx->newobject('modChunk');
                $chunk->set('category', $categoryChunkId);
                $chunk->set('description', 'Block: ' . $this->object->name);
            }
            $chunk->set('name', $this->object->chunk);
            $chunk->set('snippet', $this->properties['chunk_code']);
            $chunk->save();
        }


        return parent::afterSave();
    }
}

return 'blockConstructorUpdateProcessor';
