<?php

class txaContentGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'txaContent';
    public $classKey = 'txaContent';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    public $permission = 'list';
    public $languageTopics = array('textadvs:default', 'template', 'category');

    /**
     * @return boolean|string
     */
    public function initialize()
    {
        return parent::initialize();
    }

    /**
     * @return boolean|string
     */
    public function beforeQuery()
    {
        if (!$this->checkPermissions()) {
            return $this->modx->lexicon('access_denied');
        }

        $this->setProperty('sort', str_replace('_formatted', '', $this->getProperty('sort')));

        return parent::beforeQuery();
    }

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->select(array($this->modx->getSelectColumns($this->classKey, $this->classKey)));

        //
        if ($object = (int)$this->getProperty('object', 0)) {
            $c->where(array(
                $this->classKey . '.object' => $object,
            ));
        }

        // Поиск
        if ($query = trim($this->getProperty('query'))) {
            $c->where(array(
                $this->classKey . '.content:LIKE' => "%{$query}%",
            ));
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
        $data = $object->toArray();

        // Контент
        $data['content_formatted'] = htmlspecialchars($data['content']);

        // Кнопки
        $data['actions'] = $this->getActions($data);

        return $data;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function getActions(array $data)
    {
        $actions = array();
        $actions[] = array(
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('txa_button_update'),
            'action' => 'updateObject',
            'button' => true,
            'menu' => true,
        );
        if (!$data['active']) {
            $actions[] = array(
                'cls' => '',
                'icon' => 'icon icon-toggle-on action-green',
                'title' => $this->modx->lexicon('txa_button_enable'),
                'multiple' => $this->modx->lexicon('txa_button_enable_multiple'),
                'action' => 'enableObject',
                'button' => true,
                'menu' => true,
            );
        } else {
            $actions[] = array(
                'cls' => '',
                'icon' => 'icon icon-toggle-off action-red',
                'title' => $this->modx->lexicon('txa_button_disable'),
                'multiple' => $this->modx->lexicon('txa_button_disable_multiple'),
                'action' => 'disableObject',
                'button' => true,
                'menu' => true,
            );
        }
        $actions[] = array(
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('txa_button_remove'),
            'multiple' => $this->modx->lexicon('txa_button_remove_multiple'),
            'action' => 'removeObject',
            'button' => false,
            'menu' => true,
        );

        return $actions;
    }
}

return 'txaContentGetListProcessor';