<?php
$xpdo_meta_map['blockTable']= array (
  'package' => 'pageblocks',
  'version' => '1.1',
  'table' => 'pb_tables',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'name' => '',
    'rank' => 0,
    'active' => 1,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'rank' => 
    array (
      'dbtype' => 'smallint',
      'precision' => '10',
      'phptype' => 'integer',
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
  'composites' => 
  array (
    'Fields' => 
    array (
      'class' => 'blockField',
      'local' => 'id',
      'foreign' => 'table_id',
      'cardinality' => 'many',
      'owner' => 'local',
      'criteria' => 
      array (
        'foreign' => 
        array (
          'block_id' => '0',
        ),
      ),
    ),
    'Columns' => 
    array (
      'class' => 'pbTableColumn',
      'local' => 'id',
      'foreign' => 'table_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Groups' => 
    array (
      'class' => 'blockFieldGroup',
      'local' => 'id',
      'foreign' => 'table_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'Field' => 
    array (
      'class' => 'blockField',
      'local' => 'id',
      'foreign' => 'table_id',
      'cardinality' => 'one',
      'owner' => 'foreign',
      'criteria' => 
      array (
        'foreign' => 
        array (
          'block_id:!=' => '0',
        ),
      ),
    ),
  ),
);
