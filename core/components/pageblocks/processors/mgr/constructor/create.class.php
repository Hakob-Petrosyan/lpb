<?php

class blockConstructorCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'pb';
    public $classKey = 'blockConstructor';
    public $languageTopics = ['pageblocks'];
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->properties['name']);
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_name'));
        } elseif ($this->modx->getCount($this->classKey, ['name' => $name])) {
            $this->modx->error->addField('name', $this->modx->lexicon('pb_err_ae'));
        }

        // Проверяем чанк
//        $chunk = trim($this->properties['chunk']);
//        if (empty($chunk)) {
//            $this->modx->error->addField('chunk', $this->modx->lexicon('pb_chunk_err_name'));
//        } elseif ($this->modx->getCount($this->classKey, ['chunk' => $chunk])) {
//            $this->modx->error->addField('chunk', $this->modx->lexicon('pb_chunk_err_ae'));
//        }

        return parent::beforeSet();
    }

    /**
     * @return bool
     */
    public function beforeSave()
    {
        $this->object->fromArray(array(
            'rank' => $this->modx->getCount($this->classKey),
        ));

        return parent::beforeSave();
    }

    /**
     * @return bool
     */
    public function afterSave()
    {
        $where = ['block_id' => 0, 'table_id' => 0];
        // Обновляем поля
        if ($fields = $this->modx->getCollection('blockField', $where)) {
            foreach ($fields as $field) {
                $field->set('block_id', $this->object->id);
                $field->save();
            }
        }

        // Обновляем группы
        if ($groups = $this->modx->getCollection('blockFieldGroup', $where)) {
            foreach ($groups as $group) {
                $group->set('block_id', $this->object->id);
                $group->save();
            }
        }

        // Получаем чанк или создаем новый
        $create_chunk = $this->modx->getOption('pageblocks_create_chunk');
        if($create_chunk) {
            $this->createChunk();
        }


        return parent::afterSave();
    }

    public function createChunk() {
        if (!$chunk = $this->modx->getObject('modChunk', ['name' => $this->object->chunk])) {
            $categoryChunkId = 0;
            if ($category = $this->modx->getObject('modCategory', ['category' => 'PageBlocks'])) {
                $categoryChunkId = $category->id;
            }

            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name', $this->object->chunk);
            $chunk->set('category', $categoryChunkId);
        }
        if ($chunk && !empty($this->properties['chunk_code'])) {
            $chunk->set('description', 'Block: ' . $this->object->name);
            $chunk->set('snippet', $this->properties['chunk_code']);
            $chunk->save();
        }
    }

}

return 'blockConstructorCreateProcessor';