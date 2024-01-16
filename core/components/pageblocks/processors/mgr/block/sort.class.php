<?php

class pageBlockSortProcessor extends modObjectProcessor
{
    public $classKey = 'pageBlock';

    /** @var PageBlocks $pb */
    public $pb;


    /**
     * @return bool|null|string
     */
    public function initialize()
    {

        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }
        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::initialize();
    }


    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->modx->getCount($this->classKey, $this->properties['target'])) {
            return $this->failure();
        }

        $sources = json_decode($this->properties['sources'], true);
        if (!is_array($sources)) {
            return $this->failure();
        }

        /** @var pageBlock $target */
        $target = $this->modx->getObject($this->classKey, array('id' => $this->properties['target']));

        foreach ($sources as $id) {
            /** @var pageBlock $source */
            $source = $this->modx->getObject($this->classKey, compact('id'));
            $this->sort($source, $target);

            // Сортируем ресурс
            if($source->object_id && $target->object_id) {
                $this->pb->resource->sort($source->object_id, $target->object_id);
            }
        }
        $this->updateIndex([
            'resource_id' => $target->resource_id,
            'collection_id' => $target->collection_id,
        ]);

        if($target->object_id) {
            $this->pb->resource->updateIndex([
                'parent' => $target->resource_id
            ]);
        }

        return $this->modx->error->success();
    }


    /**
     * @param pageBlock $source
     * @param pageBlock $target
     *
     * @return array|string
     */
    public function sort(pageBlock $source, pageBlock $target)
    {
        $c = $this->modx->newQuery($this->classKey);
        $c->command('UPDATE');
        if ($source->rank < $target->rank) {
            $c->query['set']['menuindex'] = array(
                'value' => '`menuindex` - 1',
                'type' => false,
            );
            $c->andCondition(array(
                'rank:<=' => $target->rank,
                'rank:>' => $source->rank,
            ));
            $c->andCondition(array(
                'rank:>' => 0,
            ));
        } else {
            $c->query['set']['rank'] = array(
                'value' => '`rank` + 1',
                'type' => false,
            );
            $c->andCondition(array(
                'rank:>=' => $target->rank,
                'rank:<' => $source->rank,
            ));
        }
        $c->prepare();
        $c->stmt->execute();

        $source->set('rank', $target->rank);
        $source->save();
    }


    public function updateIndex($where = [])
    {
        // Check if need to update indexes
        $c = $this->modx->newQuery($this->classKey);
        $c->groupby('rank');
        $c->select('COUNT(rank) as idx');
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
        $c->sortby('rank ASC, id', 'ASC');
        if ($c->prepare() && $c->stmt->execute()) {
            $table = $this->modx->getTableName($this->classKey);
            $update = $this->modx->prepare("UPDATE {$table} SET rank = ? WHERE id = ?");
            $i = 0;
            while ($id = $c->stmt->fetch(PDO::FETCH_COLUMN)) {
                $update->execute(array($i, $id));
                $i++;
            }
        }
    }
}

return 'pageBlockSortProcessor';