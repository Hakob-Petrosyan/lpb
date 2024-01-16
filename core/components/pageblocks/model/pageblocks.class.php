<?php

class PageBlocks
{
    /** @var modX $modx */
    public $modx;

    /** @var PageBlock $block */
    public $block;

    /** @var PageBlockTable $table */
    public $table;

    /** @var PageBlockFiles $files */
    public $files;

    /** @var PageBlockVideo $video */
    public $video;

    /** @var PageBlockResource $resource */
    public $resource;

    /** @var PageBlockTools $tools */
    public $tools;

    /** @var PageBlockVersion $version */
    public $version;


    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX $modx, array $config = [])
    {
        $this->modx = $modx;
        $corePath = MODX_CORE_PATH . 'components/pageblocks/';
        $assetsUrl = MODX_ASSETS_URL . 'components/pageblocks/';

        $this->config = array_merge([
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'processorsPath' => $corePath . 'processors/',

            'connectorUrl' => $assetsUrl . 'connector.php',
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
        ], $config);

        $this->modx->addPackage('pageblocks', $this->config['modelPath']);
        $this->modx->lexicon->load('pageblocks:default');
        $this->loadServices();
    }

    /**
     * Initialize PageBlocks
     */
    public function initialize($contextKey = 'web')
    {
        $this->resource->loadData();
    }

    /**
     * Загружаем другие классы
     * @return bool
     */
    public function loadServices()
    {
        if (!class_exists('PageBlockItem')) {
            require_once dirname(__FILE__) . '/pbblock.class.php';
        }

        if (!class_exists('PageBlockTable')) {
            require_once dirname(__FILE__) . '/pbtable.class.php';
        }

        if (!class_exists('PageBlockFiles')) {
            require_once dirname(__FILE__) . '/pbfiles.class.php';
        }

        if (!class_exists('PageBlockVideo')) {
            require_once dirname(__FILE__) . '/pbvideo.class.php';
        }

        if (!class_exists('PageBlockResource')) {
            require_once dirname(__FILE__) . '/pbresource.class.php';
        }

        if (!class_exists('PageBlockTools')) {
            require_once dirname(__FILE__) . '/pbtools.class.php';
        }

        if (!class_exists('PageBlockVersion')) {
            require_once dirname(__FILE__) . '/pbversion.class.php';
        }

        $this->block = new PageBlockItem($this->modx, $this);
        $this->table = new PageBlockTable($this->modx, $this);
        $this->files = new PageBlockFiles($this->modx, $this);
        $this->video = new PageBlockVideo($this->modx, $this);
        $this->resource = new PageBlockResource($this->modx, $this);
        $this->tools = new PageBlockTools($this->modx, $this);
        $this->version = new PageBlockVersion($this->modx, $this);

        return true;
    }


    /**
     * @param string $action
     * @param array $data
     * @return false
     */
    public function runProcessor($action = '', $data = array())
    {
        if (empty($action)) {
            return false;
        }
        $this->modx->error->reset();
        $processorsPath = !empty($this->config['processorsPath'])
            ? $this->config['processorsPath']
            : MODX_CORE_PATH . 'components/pageblocks/processors/';

        return $this->modx->runProcessor($action, $data, array(
            'processors_path' => $processorsPath,
        ));
    }


    /**
     * @param modSystemEvent $event
     * @param array $scriptProperties
     */
    public function handleEvent(modSystemEvent $event, array $scriptProperties)
    {
        extract($scriptProperties);

        switch ($event->name) {
            case 'OnDocFormPrerender':
                /** @var $resource */
                if ($resource) {
                    $data = $resource->toArray();

                    $res = [
                        'id' => $data['id'],
                        'template' => $data['template'],
                        'context_key' => $data['context_key'],
                        'class_key' => $data['class_key'],
                    ];

                    $this->modx->controller->addCss($this->config['cssUrl'] . 'mgr/main.css');
                    $this->modx->controller->addCss($this->config['cssUrl'] . 'mgr/manager.css');

                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/pageblocks.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/utils.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/combo.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/default.grid.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/default.window.js');

                    // Image
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/image/panel.js');

                    // Image gallery
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/plupload/plupload.full.min.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/ext.ddview.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/image/gallery/panel.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/image/gallery/view.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/image/gallery/window.js');

                    // Video
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/video/jsVideoUrlParser.min.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/video/panel.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/video/window.js');

                    // Video gallery
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/video/gallery/panel.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/video/gallery/view.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/misc/video/gallery/window.js');

                    // Blocks
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/widgets/block/grid.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/widgets/block/windows.js');

                    // Grids
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/widgets/grid/grid.js');
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/widgets/grid/windows.js');

                    // Collection
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/widgets/collection/block/grid.js');

                    // Resource
                    $this->modx->controller->addJavascript($this->config['jsUrl'].'mgr/inject/pageblocks.js');

                    $this->modx->controller->addHtml('<script type="text/javascript">
                        PageBlocks.config = ' . json_encode($this->config) . ';
                        PageBlocks.config.connector_url = "' . $this->config['connectorUrl'] . '";
                        PageBlocks.resource = ' . json_encode($res) .';
                        PageBlocks.config.media_source = ' . json_encode($this->getMediaSources()) . ';
                        PageBlocks.collections = ' . json_encode($this->getCollections($data)) . ';
                        </script>');

                }
                break;
            case 'OnDocFormSave':
                /** @var modResource $resource */

                // Синхронизируем поля блока
                $this->block->syncValues($resource);
                break;
            case 'OnResourceDuplicate':
                /** @var modResource $oldResource
                 *  @var modResource $newResource
                 */

                // Копируем все блоки
                $this->block->copyBlockResource($oldResource, $newResource);
                break;
            case 'OnBeforeEmptyTrash':
                /** @var $ids*/

                // Удаляем блоки
                foreach ($ids as $id) {
                    $blocks = $this->getCollection('pageBlock', ['resource_id' => $id]);
                    foreach ($blocks as $block) {
                        $this->runProcessor('mgr/block/remove', ['id' => $block->id]);
                    }
                }
                break;
        }
    }

    /**
     * @param $className
     * @param array $where
     * @param string $sortby
     * @param string $sortdir
     * @return mixed
     */
    public function getFetchAll($className, $where = [], $sortby = 'rank', $sortdir = 'asc')
    {
        $q = $this->modx->newQuery($className);
        $q->select($this->modx->getSelectColumns($className, $className, '', '', false));
        $q->where($where);
        $q->sortby($sortby, $sortdir);
        $q->prepare();
        $q->stmt->execute();
        $results = $q->stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results;
    }

    /**
     * @param $className
     * @param array $where
     * @param string $sortby
     * @param string $sortdir
     * @return mixed
     */
    public function getCollection($className, $where = [], $sortby = 'rank', $sortdir = 'asc')
    {
        $q = $this->modx->newQuery($className);
        $q->where($where);
        $q->sortby($sortby, $sortdir);
        $results = $this->modx->getCollection($className, $q);

        return $results;
    }

    /**
     * @param xPDOObject $object
     * @param string $many
     * @param array $where
     * @return false
     */
    public function getMany(xPDOObject $object, string $many, array $where = ['active' => true])
    {

        $className = null;
        switch($many) {
            case 'Fields' : $className = 'blockField'; break;
            case 'FieldGroup' : $className = 'blockFieldGroup'; break;
            case 'Tables' : $className = 'blockTableValue'; break;
            case 'Files' : $className = 'blockFile'; break;
            case 'Groups' : $className = 'blockFieldGroup'; break;
            case 'Collection' : $className = 'blockCollection'; break;
            case 'Columns' : $className = 'pbTableColumn'; break;
        }
        if(!$className) return false;

        $criteria = $this->modx->newQuery($className);
        $criteria->where($where);
        $criteria->sortby('rank','asc');
        return $object->getMany($many, $criteria);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getCollections(array $data)
    {
        $blocks = $this->getFetchAll('blockCollection', ['active' => 1], 'rank', 'desc');
        if ($blocks = $this->getFilteredBlocks($blocks, $data)) {
            $blocks = array_map(function ($block){
                $block['columns'] = $this->getObjectColumns($this->modx->getObject('blockCollection', $block['id']));
                return $block;
            },$blocks);
        }
        return $blocks;
    }

    /**
     * @param array $blocks
     * @param array $data
     * @return array
     */
    public function getFilteredBlocks(array $blocks, array $data)
    {
        $blocks = array_filter($blocks, function ($block) use ($data) {
            $filters = array_filter(['ab_templates', 'ab_parents', 'ab_resources', 'ab_class', 'ab_context'], function ($field) use($block) {
                return !empty($block[$field]);
            });
            if (!count($filters)) return true;
            if ($block['context_key'] == 'mgr') return true;
            foreach ($filters as $filter) {
                $key = $data['id'];
                switch ($filter) {
                    case 'ab_templates': $key = $data['template']; break;
                    case 'ab_parents': $key = $data['parent']; break;
                    case 'ab_class': $key = $data['class_key']; break;
                    case 'ab_context': $key = $data['context_key']; break;
                }
                if (in_array($key, explode(',', $block[$filter]))) {
                    return true;
                }
            }
            return false;
        });

        return array_values($blocks);
    }

    /**
     * @return array
     */
    public function getMediaSources()
    {
        $all = [];
        $sources = $this->modx->getCollection('sources.modMediaSource');
        foreach ($sources as $source) {
            $all[$source->id] = $source->getPropertyList();
        }
        return $all;
    }

    /**
     * @param array $scriptProperties
     */
    public function loadRTE($scriptProperties = [])
    {
        // Подключаем редактор
        if ($this->modx->getOption('which_editor') == 'TinyMCE RTE') {

            $corePath = $this->modx->getOption('tinymcerte.core_path', null, $this->modx->getOption('core_path') . 'components/tinymcerte/');
            /** @var TinyMCERTE $tinymcerte */
            $this->tinymcerte = $this->modx->getService('tinymcerte', 'TinyMCERTE', $corePath . 'model/tinymcerte/', [
                'core_path' => $corePath
            ]);

            $classes = ['OnRichTextEditorInit'];
            if ($this->tinymcerte) {
                foreach ($classes as $className) {
                    $className = 'TinyMCERTE\Plugins\Events\\' . $className;
                    if (class_exists($className)) {
                        $handler = new $className($this->modx, $scriptProperties);
                        if (get_class($handler) == $className) {
                            $handler->run();
                        }
                    }
                }
            }

        }
    }

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function getObjectColumns(xPDOObject $object)
    {
        $values = [];
        $columns = $this->getMany($object,'Columns');
        foreach ($columns as $column) {
            $field = $column->getOne('Field');
            $values[] = [
                'name' => $field->name,
                'caption' => $field->caption,
                'width' => $column->width,
                'render' => $column->render,
                'fixed' => $column->fixed,
            ];
        }
        return $values;
    }

    /**
     * @param $group
     * @return array
     */
    public function getGroupValues($group)
    {
        $values = [];
        $fields = $this->getMany($group, 'Fields');
        foreach ($fields as $field) {
            $values[] = $this->getFieldValue($field);
        }

        return $values;
    }

    /**
     * @param $field
     * @return mixed
     */
    public function getFieldValue($field)
    {
        $values = $field->toArray();
        // Получаем поля колонок
        if ($values['xtype'] == 'pb-grid-table') {
            $values['table_columns'] = $this->getObjectColumns($field->getOne('Table'));
        }
        return $values;
    }

    /**
     * @param $source_path
     * @return mixed
     */
    public function getSourcePath($source_path)
    {
        if (empty($source_path)) {
            $source_path = $this->modx->getoption('pageblocks_source_path');
        }
        $source_path = trim($source_path, '/') . '/';

        return $source_path;
    }

    /**
     * @param $className
     * @param array $where
     * @return array
     */
    public function getValues($className, $where = [])
    {
        $values = [];
        $rows = $this->getFetchAll($className, $where);
        foreach ($rows as $row) {
            $values[] = json_decode($row['values'],1);
        }

        return $values;
    }


    /**
     * @param $className
     * @param array $where
     * @return int|mixed
     */
    public function getRank($className, $where = [])
    {
        $rank = 0;
        $q = $this->modx->newQuery($className);
        $q->select('rank');
        $q->where($where);
        $q->sortby('rank', 'desc');
        $q->limit(1);
        if($q->prepare() && $q->stmt->execute()) {
            if($grid_last = $q->stmt->fetch(PDO::FETCH_ASSOC)) {
                $rank = ++$grid_last['rank'];
            }
        }

        return $rank;
    }

}