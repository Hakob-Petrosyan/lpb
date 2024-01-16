<?php

require_once MODX_CORE_PATH . 'model/modx/processors/element/template/getlist.class.php';

class txaComboTemplateGetListProcessor extends modTemplateGetListProcessor
{
    public $languageTopics = array('textadvs:default', 'template', 'category');
    /** @var textAdvs $txa */
    protected $txa;

    /**
     * @return bool
     */
    public function initialize()
    {
        $this->txa = $this->modx->getService('textadvs', 'textAdvs',
            $this->modx->getOption('txa_core_path', null, MODX_CORE_PATH . 'components/textadvs/') . 'model/textadvs/');
        $this->txa->initialize($this->modx->context->key);

        return parent::initialize();
    }

    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c = parent::prepareQueryBeforeCount($c);
        $query = $this->getProperty('query');
        if (is_numeric($query)) {
            $c->orCondition(array(
                'id' => $query,
            ));
        }

        return $c;
    }

    /**
     * @param array $list
     *
     * @return array
     */
    public function beforeIteration(array $list)
    {
        $list = parent::beforeIteration($list);
        array_unshift($list, array(
            'id' => '_',
            'templatename' => $this->modx->lexicon('txa_combo_template_all'),
            'description' => '',
            'editor_type' => 0,
            'icon' => '',
            'template_type' => 0,
            'content' => '',
            'category_name' => '',
            'locked' => false,
        ));

        return $list;
    }

    /**
     * @param array $list
     *
     * @return array
     */
    public function afterIteration(array $list)
    {
        $list = parent::afterIteration($list);
        // $this->modx->log(1, print_r($list, 1));

        // // Удаляем "(пустой шаблон)"
        // $list_new = array();
        // foreach ($list as $v) {
        //     if (is_numeric($v['id']) && !empty($v['id'])) {
        //         $list_new[] = $v;
        //     }
        // }
        // $list = $list_new;
        // unset($list_new);

        // // Заменяем текст "(пустой шаблон)" на свой
        // foreach ($list as &$v) {
        //     if (is_numeric($v['id']) && !empty($v['id'])) {
        //         $v['templatename'] = $this->modx->lexicon('txa_combo_template_empty');
        //     }
        // }
        // unset($v);

        return $list;
    }
}

return 'txaComboTemplateGetListProcessor';