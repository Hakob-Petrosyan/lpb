<?php
$xpdo_meta_map['blockConstructor']= array (
  'package' => 'pageblocks',
  'version' => '1.1',
  'table' => 'pb_constructors',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'name' => '',
    'chunk' => '',
    'rank' => 0,
    'active' => 1,
    'ab_templates' => '',
    'ab_parents' => '',
    'ab_resources' => '',
    'ab_class' => '',
    'ab_context' => '',
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
    'chunk' => 
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
    'ab_templates' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ab_parents' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ab_resources' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ab_class' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'ab_context' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
  'composites' => 
  array (
    'Blocks' => 
    array (
      'class' => 'pageBlock',
      'local' => 'id',
      'foreign' => 'constructor_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Groups' => 
    array (
      'class' => 'blockFieldGroup',
      'local' => 'id',
      'foreign' => 'block_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Fields' => 
    array (
      'class' => 'blockField',
      'local' => 'id',
      'foreign' => 'block_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Collection' => 
    array (
      'class' => 'blockCollection',
      'local' => 'id',
      'foreign' => 'constructor_id',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
