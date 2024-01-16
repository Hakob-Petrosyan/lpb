<?php

class cbResourceGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'modResource';
    public $languageTopics = array('resource');
    public $defaultSortField = 'pagetitle';


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        if ($where = $this->properties['where']) {
            $where = json_decode($where,1);
            foreach ($where as $cr) {
                $c->where($cr);
            }
        }

        if ($this->properties['combo']) {
            $c->select('id,pagetitle');
        }
        if ($id = (int) $this->properties['id']) {
            $c->where(array('id' => $id));
        }
        if ($query = trim($this->properties['query'])) {
            $c->where(array('pagetitle:LIKE' => "%{$query}%"));
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        if ($this->properties['combo']) {
            $array = array(
                'id' => $object->id,
                'pagetitle' => '(' . $object->id . ') ' . $object->pagetitle,
            );
        } else {
            $array = $object->toArray();
        }

        return $array;
    }
}

return 'cbResourceGetListProcessor';