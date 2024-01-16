<?php

class PageBlocksVideoGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'blockVideo';
    public $languageTopics = array('default');
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'ASC';
//    public $permission = 'pageblocksfile_list';

    /** @var PageBlocks $pp */
    public $pb;


    /**
     * @return bool|null|string
     */
    public function initialize()
    {
        if (!$this->modx->hasPermission($this->permission)) {
            return $this->modx->lexicon('access_denied');
        }

        if ($this->properties['version_id']) {
            $this->classKey = 'pbVersionVideo';
        }

        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        return parent::initialize();
    }

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $where = [
            'block_id' => $this->properties['block_id'] ?: 0,
            'field_id' => $this->properties['field_id'],
            'grid_id' => $this->properties['grid_id'] ?: 0,
        ];
        if (!$this->properties['block_id']) {
            $where['resource_id'] = $this->properties['resource_id'];
            $where['context_key'] = $this->properties['context_key'];
            $where['cultureKey'] = $this->properties['cultureKey'];
        }
        if ($this->properties['version_id']) {
            $where['version_id'] = $this->properties['version_id'];
        }
        $c->where($where);

        return $c;
    }


    /**
     * Prepare the row for iteration
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        if ($this->properties['baseblock'] && !$this->properties['unique']) {
            return $array;
        }

        // fix preview
        if (!empty($array['thumbnail']) && stristr($array['thumbnail'], 'http') === false) {
            $array['thumbnail'] = '/' . trim($array['thumbnail'], '/');
        }

        $array['baseblock'] = 0;
        $array['actions'] = array();

        if ($this->properties['version_id']) {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-eye',
                'title' => $this->modx->lexicon('pb_version_view'),
                'action' => 'viewData',
                'button' => false,
                'menu' => true,
            );
        } else {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-edit',
                'title' => $this->modx->lexicon('pb_video_update_data'),
                'action' => 'updateData',
                'button' => false,
                'menu' => true,
            );

            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-trash-o action-red',
                'title' => $this->modx->lexicon('pb_video_remove'),
                'multiple' => $this->modx->lexicon('pb_video_remove_multiple'),
                'action' => 'removeVideo',
                'button' => false,
                'menu' => true,
            );
        }



        return $array;
    }

}

return 'PageBlocksVideoGetListProcessor';