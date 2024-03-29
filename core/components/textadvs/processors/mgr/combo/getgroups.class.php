<?php

class txaComboGroupGetListProcessor extends modProcessor
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
        $notempty = $this->getProperty('notempty', true);
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

        $rows = array(
            '',
            'Group 1',
            'Group 2',
            'Group 3',
            'Group 4',
        );
        foreach ($rows as $v) {
            $tmp = null;
            if (empty($v)) {
                if ($filter || !$notempty) {
                    $tmp = array(
                        'display' => '(Не указано)',
                        'value' => '_',
                    );
                }
            } else {
                $tmp = array(
                    'display' => $v,
                    'value' => preg_replace('/\s+/', '_', strtolower($v)),
                );
            }
            if (!empty($tmp)) {
                $output[] = $tmp;
            }
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

return 'txaComboGroupGetListProcessor';