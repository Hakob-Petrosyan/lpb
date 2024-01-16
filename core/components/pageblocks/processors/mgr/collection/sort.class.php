<?php

class blockCollectionSortProcessor extends modObjectProcessor
{
    public $classKey = 'blockCollection';


    /**
     * @return bool|null|string
     */
    public function initialize()
    {

        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }

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
        foreach ($sources as $id) {
            /** @var blockCollection $source */
            $source = $this->modx->getObject($this->classKey, compact('id'));
            /** @var blockCollection $target */
            $target = $this->modx->getObject($this->classKey, array('id' => $this->properties['target']));
            $this->sort($source, $target);
        }
        $this->updateIndex();

        return $this->modx->error->success();
    }


    /**
     * @param blockCollection $source
     * @param blockCollection $target
     *
     * @return array|string
     */
    public function sort(blockCollection $source, blockCollection $target)
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



    public function updateIndex()
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

return 'blockCollectionSortProcessor';