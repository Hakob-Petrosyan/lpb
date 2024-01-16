<?php

class txaObjectGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'txaObject';
    public $classKey = 'txaObject';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';
    public $permission = 'list';
    public $languageTopics = array('textadvs:default', 'template', 'category');
    /** @var textAdvs $txa */
    protected $txa;

    /**
     * @return boolean|string
     */
    public function initialize()
    {
        $this->txa = $this->modx->getService('textadvs', 'textAdvs',
            $this->modx->getOption('txa_core_path', null, MODX_CORE_PATH . 'components/textadvs/') . 'model/textadvs/');
        $this->txa->initialize($this->modx->context->key);

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
        $c->leftJoin('modTemplate', 'modTemplate', 'modTemplate.id = txaObject.template');

        $c->select(array($this->modx->getSelectColumns('txaObject', 'txaObject')));
        $c->select(array('modTemplate.templatename as template_formatted'));

        // // Фильтр по свойствам основного объекта
        // foreach (array('group') as $v) {
        //     if (${$v} = $this->getProperty($v)) {
        //         if (${$v} == '_') {
        //             $c->where(array(
        //                 '(' . $this->classKey . '.' . $v . ' = "" OR ' . $this->classKey . '.' . $v . ' IS NULL)',
        //             ));
        //         } else {
        //             $c->where(array(
        //                 $this->classKey . '.' . $v => ${$v},
        //             ));
        //         }
        //     }
        // }

        // Поиск
        if ($query = trim($this->getProperty('query'))) {
            $c->where(array(
                $this->classKey . '.name:LIKE' => "%{$query}%",
                'OR:' . $this->classKey . '.tag:LIKE' => "%{$query}%",
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

        // Шаблон
        if (is_null($data['template'])) {
            $data['template_formatted'] = $this->modx->lexicon('txa_template_all');
        } elseif (empty($data['template'])) {
            $data['template_formatted'] = $this->modx->lexicon('template_empty');
        }

        // Тег
        /** @var txaTagBase $cls */
        $data['tag_formatted'] = '';
        if ($cls = $this->txa->getTagClass(null, $data['tag'])) {
            $data['tag_formatted'] = htmlspecialchars($cls->getName());
        }
        unset($cls);

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
            'button' => true,
            'menu' => true,
        );

        return $actions;
    }
}

return 'txaObjectGetListProcessor';