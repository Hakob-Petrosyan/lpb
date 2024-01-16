<?php

class PageBlocksFileGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'blockFile';
    public $languageTopics = array('default');
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'ASC';
//    public $permission = 'pageblocksfile_list';

    public $images = [];

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

        if ($this->properties['version_id']) {
            $this->classKey = 'pbVersionFile';
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

        if ($thumb = $this->getImageThumb($array)) {
            $array = array_merge($array, $thumb);
        }

        if ($this->properties['baseblock'] && !$this->properties['unique']) {
            return $array;
        }

        $array['baseblock'] = 0;
        $array['actions'] = array();

        if ($this->properties['version_id']) {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-eye',
                'title' => $this->modx->lexicon('pb_version_view'),
                'action' => 'viewFile',
                'button' => false,
                'menu' => true,
            );
        } else {
            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-edit',
                'title' => $this->modx->lexicon('pb_gallery_file_rename'),
                'action' => 'updateFile',
                'button' => false,
                'menu' => true,
            );

            $array['actions'][] = array(
                'cls' => '',
                'icon' => 'icon icon-trash-o action-red',
                'title' => $this->modx->lexicon('pb_gallery_file_delete'),
                'multiple' => $this->modx->lexicon('pb_gallery_file_delete_multiple'),
                'action' => 'deleteFiles',
                'button' => false,
                'menu' => true,
            );
        }



        return $array;
    }


    public function getImageThumb($array)
    {
        if (isset($this->images[$array['path']])) {
            $images = $this->images[$array['path']];
        } else {
            $images = [];
            $ls = $this->pb->files->getSourceFiles($this->properties['source'], $array['path']);
            foreach ($ls as $l) {
                if (!empty($l['name']) && !empty($l['thumb'])) {
                    $images[$l['name']] = [
                        'thumb' => $l['thumb'],
                        'thumb_width' => $l['thumb_width'],
                        'thumb_height' => $l['thumb_height'],
                    ];
                } else {
                    $images[] = [];
                }
            }
            $this->images[$array['path']] = $images;
        }

        return $images[$array['filename']] ?? [];
    }

}

return 'PageBlocksFileGetListProcessor';