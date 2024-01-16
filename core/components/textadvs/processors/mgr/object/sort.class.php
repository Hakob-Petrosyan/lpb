<?php

class txaObjectSortProcessor extends modObjectProcessor
{
    public $classKey = 'txaObject';
    private $_object;
    private $_object_key = ''; // Для группировки по родителю указать ключ: 'object_id';

    /**
     * @return array|string
     */
    public function process()
    {
        /** @var txaObject $target */
        if (!$target = $this->modx->getObject($this->classKey, $this->getProperty('target'))) {
            return $this->failure();
        }
        $this->_object = empty($this->_object_key) ? 0 : $target->get($this->_object_key);

        $sources = json_decode($this->getProperty('sources'), true);
        if (!is_array($sources)) {
            return $this->failure();
        }
        foreach ($sources as $id) {
            /** @var txaObject $source */
            if ($source = $this->modx->getObject($this->classKey, $id)) {
                if (empty($this->_object_key) || $source->get($this->_object_key) == $this->_object) {
                    $target = $this->modx->getObject($this->classKey, $this->getProperty('target'));
                    $this->sort($source, $target);
                } else {
                    $this->move($source);
                }
            }
        }
        $this->updateIndex();

        return $this->modx->error->success();
    }

    /**
     * @param txaObject $source
     * @param txaObject $target
     */
    public function sort(txaObject $source, txaObject $target)
    {
        $c = $this->modx->newQuery($this->classKey);
        $c->command('UPDATE');
        if (!empty($this->_object_key)) {
            $c->where(array(
                $this->_object_key => $this->_object,
            ));
        }
        if ($source->get('idx') < $target->get('idx')) {
            $c->query['set']['idx'] = array(
                'value' => '`idx` - 1',
                'type' => false,
            );
            $c->andCondition(array(
                'idx:<=' => $target->idx,
                'idx:>' => $source->idx,
            ));
            $c->andCondition(array(
                'idx:>' => 0,
            ));
        } else {
            $c->query['set']['idx'] = array(
                'value' => '`idx` + 1',
                'type' => false,
            );
            $c->andCondition(array(
                'idx:>=' => $target->idx,
                'idx:<' => $source->idx,
            ));
        }
        $c->prepare();
        $c->stmt->execute();
        $source->set('idx', $target->get('idx'));
        $source->save();
    }

    /**
     * @param txaObject $source
     */
    public function move(txaObject $source)
    {
        if (!empty($this->_object_key)) {
            $source->set($this->_object_key, $this->_object);
            $source->set('idx', $this->modx->getCount($this->classKey, array($this->_object_key => $this->_object)));
            $source->save();
        }
    }

    /**
     *
     */
    public function updateIndex()
    {
        // Update indexes
        $condition = empty($this->_object_key) ? array('id:!=' => 0) : array($this->_object_key => $this->_object);
        $c = $this->modx->newQuery($this->classKey, $condition);
        $c->select('id');
        $c->sortby('idx', 'ASC');
        $c->sortby('id', 'ASC');
        if ($c->prepare() && $c->stmt->execute()) {
            $table = $this->modx->getTableName($this->classKey);
            $update = $this->modx->prepare("UPDATE {$table} SET idx = ? WHERE id = ?");
            while ($id = $c->stmt->fetch(PDO::FETCH_COLUMN)) {
                $i = empty($i) ? 1 : ++$i;
                $update->execute(array($i, $id));
            }
        }
    }
}

return 'txaObjectSortProcessor';