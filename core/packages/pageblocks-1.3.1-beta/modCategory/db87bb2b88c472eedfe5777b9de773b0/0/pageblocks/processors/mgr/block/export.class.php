<?php

class pageBlockExportProcessor extends modObjectGetListProcessor
{
    public $objectType = 'pb';
    public $classKey = 'pageBlock';
    public $languageTopics = ['pageblocks:default'];
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'asc';


    public function initialize() {

        $this->setProperty('columns', 'cultureKey,constructor_id,chunk,active,baseblock,unique,values');
        $filename = $this->objectType . '.csv';
        if ($this->properties['resource_id']) {
            $filename =  $this->objectType . '_' . $this->properties['language'] . '_res_' . $this->properties['resource_id'] . '.csv';
        }
        $this->properties['filename'] = $filename;
        $this->properties['directory'] = $this->modx->getOption('core_path') . 'cache/export/pageblocks/';
        $this->properties['delimiter'] = ',';

        return parent::initialize();
    }


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $collection_id = (int) $this->properties['collection_id'];
        $c->where([
            'resource_id' => $this->properties['resource_id'],
            'cultureKey' => trim($this->properties['language']),
            'context_key' => trim($this->properties['context_key']),
            'collection_id' => $collection_id,
        ]);

        // Если выбран блок
        if ($this->properties['block_id']) {
            $c->where([
                'constructor_id' => $this->properties['block_id']
            ]);
        }

        // Экпорт колекции
        if ($collection_id && $collection = $this->modx->getObject('blockCollection', $collection_id)) {
            $c->where([
                'constructor_id' => $collection->constructor_id
            ]);
        }

        return $c;
    }

    public function process() {
        $beforeQuery = $this->beforeQuery();
        if ($beforeQuery !== true) {
            return $this->failure($beforeQuery);
        }
        $data = $this->getData();
        $list = $this->iterate($data);

        if (!is_dir($this->properties['directory'])) {
            if (!mkdir($this->properties['directory'], 0777, true)) {
                return $this->failure($this->modx->lexicon('pb_export_dir_failed'));
            }
        }

        if (!$this->properties['download']) {
            return $this->createFile($list);
        }

        return $this->downloadFile();
    }

    public function getColumns(array $data = [], array $columns = [])
    {
        foreach ($data as $array) {
            foreach ($array['values'] as $column => $value) {
                if (!in_array($column, $columns)) {
                    $columns[] = $column;
                }
            }
        }
        return $columns;
    }


    public function createFile($data = [])
    {
        $columns = explode(',', $this->properties['columns']);
        if (!empty($this->properties['block_id']) || $this->properties['collection_id']) {
            $columns = $this->getColumns($data, $columns);
            if (($key = array_search('values', $columns)) !== false) {
                unset($columns[$key]);
            }
        }

        $fopen = fopen($this->properties['directory'] . $this->properties['filename'], 'wb');
        if ($fopen) {
            fputcsv($fopen, $columns, $this->properties['delimiter']);
            foreach ($data as $row) {
                if (is_array($row['values'])) {
                    $row = array_merge($row, $row['values']);
                }

                $value = [];
                foreach ($columns as $column) {
                    if (isset($row[$column])) {
                        if (is_array($row[$column])) {
                            $value[] = implode(',', $row[$column]);
                        } else {
                            $value[] = $row[$column];
                        }
                    } else {
                        $value[] = '';
                    }
                }
                fputcsv($fopen, $value, $this->properties['delimiter']);
            }

            fclose($fopen);

            return $this->success('', ['language' => trim($this->properties['language'])]);
        }

        return $this->failure($this->modx->lexicon('pb_export_failed'));
    }

    public function downloadFile()
    {
        $file = $this->properties['directory'] . $this->properties['filename'];

        if (is_file($file)) {
            $content = file_get_contents($file);

            if ($content) {
                header('Content-Encoding: UTF-8');
                header('Content-Type: application/force-download');
                header('Content-Disposition: attachment; filename="' . $this->properties['filename'] . '"');
                header("Pragma: no-cache");
                header("Expires: 0");

                return $content;
            }
        }

        return $this->failure($this->modx->lexicon('pb_export_failed'));
    }

    /**
     * Prepare the row for iteration
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        if (!empty($this->properties['block_id']) || $this->properties['collection_id']) {
            $array['values'] = json_decode($array['values'], 1);
        }
        return $array;
    }

}

return 'pageBlockExportProcessor';