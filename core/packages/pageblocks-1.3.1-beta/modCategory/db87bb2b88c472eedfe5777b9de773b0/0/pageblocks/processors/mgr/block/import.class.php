<?php

class pageBlockImportProcessor extends modProcessor
{
    public $classKey = 'pageBlock';
    public $defaultColumns = 'resource_id, context_key, cultureKey, constructor_id, collection_id, chunk, values, rank, active, baseblock, unique';
    /** @var PageBlocks $pb */
    public $pb;

    public function process() {

        $this->pb = $this->modx->getService('pageblocks', 'PageBlocks', MODX_CORE_PATH . 'components/pageblocks/model/');

        if($_FILES['import']['tmp_name']) {

            // Проверяем формат файла
            $allowed_mime = ['text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'];
            if(!in_array($_FILES['import']['type'], $allowed_mime)) {
                return $this->failure($this->modx->lexicon('pb_import_file_type_error'));
            }
            $rows = $this->csv_to_array($_FILES['import']['tmp_name']);
            foreach ($rows as $row) {
                if(empty($row['chunk'])) continue;
                $row['resource_id'] = $this->properties['resource_id'];
                $row['context_key'] = $this->properties['context_key'];
                $row['cultureKey'] = $this->properties['cultureKey'];
                $row['collection_id'] = $this->properties['collection_id'];
                $row['rank'] = $this->modx->getCount($this->classKey, [
                    'resource_id' => $this->properties['resource_id'],
                    'context_key' => $this->properties['context_key'],
                    'cultureKey' => $this->properties['cultureKey'],
                    'collection_id' => $this->properties['collection_id'],
                ]);

                if(isset($row['values'])) {
                    $this->importBlocks($row);
                } else {
                    $this->importOneBlock($row);
                }
            }

            return $this->success($this->modx->lexicon('pb_import_success'), ['total' => count($rows)]);
        }

        return $this->failure($this->modx->lexicon('pb_import_failed'));
    }


    /**
     * @param array $row
     */
    public function importBlocks($row = [])
    {
        $newBlock = $this->modx->newObject($this->classKey);
        $newBlock->fromArray($row, '', false, true);
        if ($newBlock->save()) {
            $values = json_decode($row['values'],1);
            foreach ($values as $key => $value) {
                if (is_array($value)) {
                    if ($field = $this->modx->getObject('blockField', [
                        'block_id' => $row['constructor_id'],
                        'name' => $key
                    ])) {

                        if ($field->xtype == 'pb-image-gallery') {
                            $this->importGallery($value, array_merge($row, [
                                'block_id' => $newBlock->id,
                                'field_id' => $field->id,
                                'grid_id' => 0,
                            ]));
                        }

                        if ($field->xtype == 'pb-grid-table') {
                            foreach ($value as $val) {
                                $this->importTable($val, array_merge($row, [
                                    'block_id' => $newBlock->id,
                                    'table_id' => $field->field_table_id,
                                    'field_id' => $field->id,
                                    'grid_id' => 0,
                                ]));
                            }
                        }
                    }
                }
            }
        }
    }


    /**
     * @param $values
     * @param array $properties
     */
    public function importTable($values, array $properties)
    {
        $newTable = $this->modx->newObject('blockTableValue');
        $newTable->fromArray([
            'resource_id' => $properties['resource_id'],
            'context_key' => $properties['context_key'],
            'cultureKey' => $properties['cultureKey'],
            'block_id' => $properties['block_id'],
            'table_id' => $properties['table_id'],
            'field_id' => $properties['field_id'],
            'grid_id' => $properties['grid_id'],
            'values' => json_encode($values),
            'rank' => $this->pb->table->getRank([
                'block_id' => $properties['block_id'],
                'resource_id' => $properties['resource_id'],
                'context_key' => $properties['context_key'],
                'cultureKey' => $properties['cultureKey'],
                'field_id' => $properties['field_id'],
                'grid_id' => $properties['grid_id'],
            ]),
            'active' => 1,
        ],'', false, true);
        if ($newTable->save()) {
            foreach ($values as $key => $value) {

                if (is_array($value)) {
                    if ($field = $this->modx->getObject('blockField', [
                        'block_id' => 0,
                        'table_id' => $newTable->table_id,
                        'name' => $key
                    ])) {

                        if ($field->xtype == 'pb-image-gallery') {
                            $this->importGallery($value, array_merge($properties, [
                                'field_id' => $field->id,
                                'grid_id' => $newTable->id,
                            ]));
                        }

                        if ($field->xtype == 'pb-grid-table') {
                            foreach ($value as $val) {
                                $this->importTable($val, array_merge($properties, [
                                    'table_id' => $field->field_table_id,
                                    'field_id' => $field->id,
                                    'grid_id' => $newTable->id,
                                ]));
                            }
                        }
                    }
                }
            }
        }
    }


    /**
     * @param array $files
     * @param array $properties
     */
    public function importGallery(array $files = [], array $properties)
    {
        foreach ($files as $file) {
            $newFile = $this->modx->newObject('blockFile');
            $newFile->fromArray(array_merge($file, [
                'resource_id' => $properties['resource_id'],
                'context_key' => $properties['context_key'],
                'cultureKey' => $properties['cultureKey'],
                'block_id' => $properties['block_id'],
                'field_id' => $properties['field_id'],
                'grid_id' => $properties['grid_id'],
                'rank' => $this->pb->files->getRank([
                    'block_id' => $properties['block_id'],
                    'resource_id' => $properties['resource_id'],
                    'context_key' => $properties['context_key'],
                    'cultureKey' => $properties['cultureKey'],
                    'field_id' => $properties['field_id'],
                    'grid_id' => $properties['grid_id'],
                ]),
                'active' => 1,
            ]),'', false, true);
            $newFile->save();
        }
    }


    /**
     * @param array $row
     */
    public function importOneBlock($row = [])
    {
        $columns = explode(',', $this->defaultColumns);
        $values = array_filter($row, function ($field) use ($columns) {
            return !in_array($field, $columns);
        }, ARRAY_FILTER_USE_KEY);
        $row['values'] = json_encode($values);

        $newBlock = $this->modx->newObject($this->classKey);
        $newBlock->fromArray($row, '', false, true);
        $newBlock->save();
    }

    public function csv_to_array($filename)
    {
        $csv = array_map(function ($file){
            return str_getcsv($file, $this->properties['delimiter'] ?: ',');
        }, file($filename));

        array_walk($csv, function(&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });
        array_shift($csv);
        return $csv;
    }

}

return 'pageBlockImportProcessor';