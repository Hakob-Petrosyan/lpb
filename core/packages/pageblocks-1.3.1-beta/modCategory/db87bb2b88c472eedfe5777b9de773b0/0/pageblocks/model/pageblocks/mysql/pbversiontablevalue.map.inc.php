<?php
$xpdo_meta_map['pbVersionTableValue']= array (
  'package' => 'pageblocks',
  'version' => '1.1',
  'table' => 'pb_version_table_values',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'version_id' => 0,
    'version_table_id' => 0,
    'resource_id' => 0,
    'context_key' => 'web',
    'cultureKey' => 'ru',
    'block_id' => 0,
    'table_id' => 0,
    'grid_id' => 0,
    'field_id' => 0,
    'values' => '',
    'rank' => 0,
    'active' => 1,
  ),
  'fieldMeta' => 
  array (
    'version_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'version_table_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'resource_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'context_key' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => 'web',
    ),
    'cultureKey' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => 'ru',
    ),
    'block_id' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'table_id' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'grid_id' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'field_id' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => true,
      'default' => 0,
    ),
    'values' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'rank' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '10',
      'phptype' => 'integer',
      'attributes' => 'unsigned',
      'null' => false,
      'default' => 0,
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'boolean',
      'null' => false,
      'default' => 1,
    ),
  ),
  'indexes' => 
  array (
    'version_id' => 
    array (
      'alias' => 'version_id',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'version_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Files' => 
    array (
      'class' => 'blockFile',
      'local' => 'id',
      'foreign' => 'grid_id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
    'Videos' => 
    array (
      'class' => 'blockVideo',
      'local' => 'id',
      'foreign' => 'grid_id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
    'Grids' => 
    array (
      'class' => 'blockTableValue',
      'local' => 'id',
      'foreign' => 'grid_id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
  ),
  'aggregates' => 
  array (
    'Block' => 
    array (
      'class' => 'pageBlock',
      'local' => 'block_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Table' => 
    array (
      'class' => 'blockTable',
      'local' => 'table_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Fields' => 
    array (
      'class' => 'blockField',
      'local' => 'table_id',
      'foreign' => 'table_id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
    'Groups' => 
    array (
      'class' => 'blockFieldGroup',
      'local' => 'table_id',
      'foreign' => 'table_id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
    'Columns' => 
    array (
      'class' => 'pbTableColumn',
      'local' => 'table_id',
      'foreign' => 'table_id',
      'cardinality' => 'many',
      'owner' => 'foreign',
    ),
    'Field' => 
    array (
      'class' => 'blockField',
      'local' => 'field_id',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
