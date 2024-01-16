<?php

class PageBlockResource
{
    /** @var modX $modx */
    public $modx;
    /** @var PageBlocks $pb */
    public $pb;

    public $classKey = 'modResource';

    const FIELDMETA = [
        'textfield' => [
            'dbtype' => 'varchar',
            'precision' => '255',
            'phptype' => 'string',
            'null' => true,
            'default' => null,
        ],
        'textarea' => [
            'dbtype' => 'text',
            'phptype' => 'string',
            'null' => true,
            'default' => null,
        ],
        'richtext' => [
            'dbtype' => 'text',
            'phptype' => 'string',
            'null' => true,
            'default' => null,
        ],
        'numberfield' => [
            'dbtype' => 'int',
            'precision' => 10,
            'attributes' => 'unsigned',
            'phptype' => 'integer',
            'null' => true,
            'default' => 0,
        ],
        'xcheckbox' => [
            'dbtype' => 'tinyint',
            'precision' => 1,
            'attributes' => 'unsigned',
            'phptype' => 'integer',
            'null' => true,
            'default' => 0,
        ],
        'pb-combo-boolean' => [
            'dbtype' => 'tinyint',
            'precision' => 1,
            'attributes' => 'unsigned',
            'phptype' => 'boolean',
            'null' => false,
            'default' => 0,
        ],
        'datefield' => [
            'dbtype' => 'int',
            'precision' => 20,
            'phptype' => 'date',
            'null' => true,
            'default' => null,
        ],
        'timefield' => [
            'dbtype' => 'varchar',
            'precision' => '255',
            'phptype' => 'string',
            'null' => true,
            'default' => null,
        ],
        'displayfield' => [
            'dbtype' => 'varchar',
            'precision' => '255',
            'phptype' => 'string',
            'null' => true,
            'default' => null,
        ],
    ];

    /**
     * PageBlockResource constructor.
     * @param modX $modx
     * @param $pageblocks
     */
    function __construct(modX $modx, $pageblocks)
    {
        $this->modx = $modx;
        $this->pb = $pageblocks;

        $this->modx->lexicon->load('core:resource');
    }

    /**
     * @param pageBlock $object
     * @return bool
     */
    public function create($data)
    {
        if (!$this->checkData($data)) return false;
        $data = $this->prepareData($data);

        $response = $this->modx->runProcessor('resource/create', array_merge($data, [
            'parent' => $data['resource_id'],
            'show_in_tree' => 0,
            'hidemenu' => 1,
        ]));
        if ($response->isError()) {
            return $this->modx->error->failure($response->getMessage());
        }

        $resource = $this->getResource($response->response['object']['id']);
        return $resource->toArray();
    }

    /**
     * @param pageBlock $object
     * @return bool
     */
    public function update(pageBlock $object)
    {
        $data = $object->toArray();
        if (!$data['object_id']) return false;
        $data = $this->prepareData($data);
        $data['id'] = $data['object_id'];

        $response = $this->modx->runProcessor('resource/update', $data);
        if ($response->isError()) {
            return $this->modx->error->failure($response->getMessage());
        }
        return false;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getResource($id)
    {
        return $this->modx->getObject($this->classKey, $id);
    }

    /**
     * @param $id
     * @param int $parent
     * @return mixed
     */
    public function copy($id, $parent = 0)
    {
        $response = $this->modx->runProcessor('resource/duplicate', ['id' => $id]);
        if ($response->isError()) {
            return $this->modx->error->failure($response->getMessage());
        }
        $resource = $this->getResource($response->response['object']['id']);

        // Обновляем menuindex
        $resource->set('menuindex', $this->modx->getCount($this->classKey, ['parent' => $resource->parent]) - 1);
        if($parent) {
            $resource->set('parent', $parent);
        }
        $resource->save();

        return $resource->toArray();
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        return $this->modx->removeObject($this->classKey, $id);
    }

    /**
     * @param $id
     * @param $published
     * @return bool
     */
    public function published($id, $published)
    {
        if ($resource = $this->getResource($id)) {
            $resource->set('published', $published);
            if (!$resource->publishedon) {
                $resource->set('publishedon', time());
            }
            $resource->set('editedby', $this->modx->user->id);
            $resource->set('editedon', time());
            if ($resource->save()) return true;
        }

        return false;
    }


    /**
     * @param pbResourceColumn $field
     */
    public function createTableColumn(pbResourceColumn $field)
    {
        $this->modx->exec($this->getSQL($field, 'create'));
    }


    /**
     * @param pbResourceColumn $field
     */
    public function updateTableColumn(pbResourceColumn $field)
    {
        $this->modx->exec($this->getSQL($field, 'update'));
    }


    /**
     * @param pbResourceColumn $field
     */
    public function removeTableColumn(pbResourceColumn $field)
    {
        $this->modx->exec($this->getSQL($field));
    }


    /**
     * @param pbResourceColumn $field
     * @param string $command
     * @return string
     */
    public function getSQL(pbResourceColumn $field, $command = 'remove')
    {
        $table = $this->modx->getTableName($this->classKey);
        $fieldmeta = self::FIELDMETA[$field->xtype];
        $type = $fieldmeta['dbtype'] . ($fieldmeta['precision'] ? "({$fieldmeta['precision']})" : '');
        $null = $fieldmeta['null'] ? 'NULL' : 'NOT NULL';
        $default = $fieldmeta['default'] !== null ? " DEFAULT {$fieldmeta['default']}" : '';

        switch ($command) {
            case 'create':
                $sql = "ALTER TABLE {$table} ADD `{$field->name}` {$type} {$null}{$default};";
                break;
            case 'update':
                $sql = "ALTER TABLE {$table} MODIFY COLUMN `{$field->name}` {$type} {$null}{$default};";
                break;
            case 'remove':
                $sql = "ALTER TABLE {$table} DROP COLUMN `{$field->name}`;";
                break;
        }

        return $sql;
    }


    public function loadData()
    {
        $this->modx->loadClass($this->classKey);
        $fields = $this->modx->getCollection('pbResourceColumn');
        foreach ($fields as $field) {
            $fieldmeta = self::FIELDMETA[$field->xtype];
            $this->modx->map[$this->classKey]['fields'][$field->name] = $fieldmeta['default'];
            $this->modx->map[$this->classKey]['fieldMeta'][$field->name] = array(
                'dbtype' => $fieldmeta['dbtype'],
                'precision' => $fieldmeta['precision'],
                'attributes' => $fieldmeta['attributes'],
                'phptype' => $fieldmeta['phptype'],
                'null' => $fieldmeta['null'] ? true : false,
                'default' => $fieldmeta['default'],
            );
        }
    }


    /**
     * @return mixed
     */
    public function getReservedFieldNames()
    {
        $q = $this->modx->prepare("DESCRIBE " . $this->modx->getTableName($this->classKey));
        $q->execute();
        $fields = $q->fetchAll(PDO::FETCH_COLUMN);

        return $fields;
    }

    /**
     * @param $data
     * @return bool
     */
    public function checkData($data)
    {
        if (isset($data['alias'])
            && isset($data['pagetitle'])
            && isset($data['template'])
            && $data['collection_id']
        ) return true;

        return false;
    }

    /**
     * @param $data
     * @return array
     */
    public function prepareData($data)
    {
        return array_map(function($value){
            return is_array($value) ? json_encode($value) : $value;
        },$data);
    }

    /**
     * @param modResource $source
     * @param modResource $target
     *
     * @return array|string
     */
    public function sort($source_id, $target_id)
    {
        $source = $this->getResource($source_id);
        $target = $this->getResource($target_id);
        if (!$source || !$target) return;

        $c = $this->modx->newQuery($this->classKey);
        $c->command('UPDATE');
        if ($source->menuindex < $target->menuindex) {
            $c->query['set']['menuindex'] = array(
                'value' => '`menuindex` - 1',
                'type' => false,
            );
            $c->andCondition(array(
                'menuindex:<=' => $target->menuindex,
                'menuindex:>' => $source->menuindex,
            ));
            $c->andCondition(array(
                'menuindex:>' => 0,
            ));
        } else {
            $c->query['set']['menuindex'] = array(
                'value' => '`menuindex` + 1',
                'type' => false,
            );
            $c->andCondition(array(
                'menuindex:>=' => $target->menuindex,
                'menuindex:<' => $source->menuindex,
            ));
        }
        $c->prepare();
        $c->stmt->execute();

        $source->set('menuindex', $target->menuindex);
        $source->save();
    }


    public function updateIndex($where = [])
    {
        // Check if need to update indexes
        $c = $this->modx->newQuery($this->classKey);
        $c->groupby('menuindex');
        $c->select('COUNT(menuindex) as idx');
        $c->sortby('idx', 'DESC');
        $c->limit(1);
        if ($c->prepare() && $c->stmt->execute()) {
            if ($c->stmt->fetchColumn() == 1) {
                return;
            }
        }

        // Update indexes
        $c = $this->modx->newQuery($this->classKey);
        $c->where($where);
        $c->select('id');
        $c->sortby('menuindex ASC, id', 'ASC');
        if ($c->prepare() && $c->stmt->execute()) {
            $table = $this->modx->getTableName($this->classKey);
            $update = $this->modx->prepare("UPDATE {$table} SET menuindex = ? WHERE id = ?");
            $i = 0;
            while ($id = $c->stmt->fetch(PDO::FETCH_COLUMN)) {
                $update->execute(array($i, $id));
                $i++;
            }
        }
    }

}