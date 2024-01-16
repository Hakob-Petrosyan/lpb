<?php

class txaComboTagGetListProcessor extends modProcessor
{
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
     * @return string
     */
    public function process()
    {
        $filter = $this->getProperty('filter', false);
        if ($filter) {
            $output = array(
                array(
                    'display' => '(Все)',
                    'value' => '',
                ),
            );
        } else {
            $output = array();
        }

        // $rows = array(
        //     'p',
        //     'blockquote',
        //     'h2',
        //     'img',
        //     'ul',
        //     'ol',
        //     'iframeyoutube',
        // );
        foreach ($this->txa->getTags() as $v) {
            $output[] = array(
                'display' => $v['name'],
                'value' => $v['key'],
            );
        }

        return $this->outputArray($output);
    }

    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return array('textadvs:default');
    }
}

return 'txaComboTagGetListProcessor';