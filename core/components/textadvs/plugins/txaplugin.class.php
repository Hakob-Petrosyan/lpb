<?php

abstract class txaPlugin
{
    /** @var modX $modx */
    protected $modx;
    /** @var textAdvs $txa */
    protected $txa;
    /** @var array $sp */
    protected $sp;

    public function __construct(&$modx, &$sp)
    {
        $this->sp = &$sp;
        $this->modx = &$modx;
        $this->txa = $this->modx->getService('textadvs', 'textAdvs',
            $this->modx->getOption('txa_core_path', null, MODX_CORE_PATH . 'components/textadvs/') . 'model/textadvs/', $this->sp);
        $this->txa->initialize($this->modx->context->key);
    }

    abstract public function run();
}