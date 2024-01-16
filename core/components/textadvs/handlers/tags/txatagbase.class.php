<?php

abstract class txaTagBase
{
    /** @var string $key */
    public $key;
    /** @var string $name */
    public $name;
    /** @var modX $modx */
    public $modx;
    /** @var textAdvs $txa */
    public $txa;
    /** @var txaObject|null $object */
    public $object;
    /** @var int $idx */
    public $idx = 0;

    /**
     * @param textAdvs       $txa
     * @param txaObject|null $object
     */
    function __construct(textAdvs &$txa, $object = null)
    {
        $this->txa = &$txa;
        $this->object = &$object;
        $this->modx = &$txa->modx;
        $this->modx->lexicon->load('textadvs:default');
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Колбэк для функции preg_replace_callback
     *
     * @param array $match
     *
     * @return string
     */
    protected function pregReplaceCallback($match)
    {
        $output = $match[0];
        if (is_object($this->object)) {
            if ($this->object->get('index') === ++$this->idx) {
                if ($contentObject = $this->getCurrentContentObject()) {
                    switch ($this->object->get('position')) {
                        case 'before':
                            $output = $contentObject->get('content') . $output;
                            break;
                        case 'after':
                            $output .= $contentObject->get('content');
                            break;
                    }
                    $this->setNextCurrentContent();
                }
            }
        }

        return $output;
    }

    /**
     * Получает объявление для показа
     * @return txaContent|null|mixed
     */
    protected function getCurrentContentObject()
    {
        $object = null;
        if (is_object($this->object)) {
            if (!$object = $this->modx->getObject('txaContent', array(
                'object' => $this->object->get('id'),
                'current' => true,
                'active' => true,
            ))) {
                $q = $this->modx->newQuery('txaContent', array(
                    'object' => $this->object->get('id'),
                    'active' => true,
                ));
                $q->sortby('id', 'ASC');
                $q->limit(1);
                if ($object = $this->modx->getObject('txaContent', $q)) {
                    $object->set('current', true);
                    $object->save();
                }
            }
        }

        return $object;
    }

    /**
     * Устанавливает следующее объявление готовым для показа
     * @return mixed
     */
    protected function setNextCurrentContent()
    {
        if (is_object($this->object)) {
            $q = $this->modx->newQuery('txaContent', array(
                'object' => $this->object->get('id'),
                'active' => true,
            ));
            $q->sortby('id', 'ASC');
            if ($this->modx->getCount('txaContent', $q) < 2) {
                return;
            }
            if ($currentObject = $this->getCurrentContentObject()) {
                // if ($objects = $this->modx->getCollection('txaContent', array(
                //     'object' => $this->object->get('id'),
                // ))) {
                //     foreach ($objects as $object) {
                //         $object->set('current', false);
                //         $object->save();
                //     }
                // }
                // unset($objects, $object);
                $currentObject->set('current', false);
                $currentObject->save();

                $q->where(array(
                    'id:>' => $currentObject->get('id'),
                ));

                if (!$this->modx->getCount('txaContent', $q)) {
                    $q = $this->modx->newQuery('txaContent', array(
                        'id:!=' => $currentObject->get('id'),
                        'object' => $this->object->get('id'),
                        'active' => true,
                    ));
                    $q->sortby('id', 'ASC');
                }
                if ($contentObject = $this->modx->getObject('txaContent', $q)) {
                    $contentObject->set('current', true);
                    $contentObject->save();
                }
            }
        }
    }

    /**
     * http://php.net/manual/ru/function.preg-replace-callback.php
     * http://php.net/manual/ru/function.preg-replace-callback-array.php
     * @param string $content
     *
     * @return string
     */
    abstract public function prepare($content);
}