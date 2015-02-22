<?php

$properties = array();

$tmp = array(
  'tpl' => array(
    'type' => 'textfield'
  , 'value' => 'tpl.catchway.cities.row'
  )
, 'tplWrapper' => array(
    'type' => 'textfield'
  , 'value' => 'tpl.catchway.cities'
  )
, 'fastMode' => array(
    'type' => 'combo-boolean'
  , 'value' => true
  )
, 'sortby' => array(
    'type' => 'textfield'
  , 'value' => 'publishedon'
  )
, 'sortdir' => array(
    'type' => 'list'
  , 'options' => array(
      array('text' => 'ASC', 'value' => 'ASC')
    , array('text' => 'DESC', 'value' => 'DESC')
    )
  , 'value' => 'DESC',
  )
, 'limit' => array(
    'type' => 'numberfield'
  , 'value' => 300
  )
, 'offset' => array(
    'type' => 'numberfield'
  , 'value' => 0
  )
, 'depth' => array(
    'type' => 'numberfield'
  , 'value' => 1
  )
, 'parents' => array(
    'type' => 'textfield'
  , 'value' => '0'
  )
, 'includeContent' => array(
    'type' => 'combo-boolean'
  , 'value' => false
  )
, 'includeTVs' => array(
    'type' => 'textfield'
  , 'value' => ''
  )
, 'prepareTVs' => array(
    'type' => 'textfield'
  , 'value' => '1'
  )
, 'processTVs' => array(
    'type' => 'textfield'
  , 'value' => ''
  )
, 'tvPrefix' => array(
    'type' => 'textfield'
  , 'value' => 'tv.'
  )
, 'tvFilters' => array(
    'type' => 'textfield'
  , 'value' => ''
  )
, 'tvFiltersAndDelimiter' => array(
    'type' => 'textfield'
  , 'value' => ','
  )
, 'tvFiltersOrDelimiter' => array(
    'type' => 'textfield'
  , 'value' => '||'
  )
, 'showUnpublished' => array(
    'type' => 'combo-boolean'
  , 'value' => false
  )
, 'showDeleted' => array(
    'type' => 'combo-boolean'
  , 'value' => false
  )
, 'showHidden' => array(
    'type' => 'combo-boolean'
  , 'value' => true
  )
, 'hideContainers' => array(
    'type' => 'combo-boolean'
  , 'value' => false
  )
, 'select' => array(
    'type' => 'textarea'
  , 'value' => ''
  )
, 'loadModels' => array(
    'type' => 'textfield'
  , 'value' => ''
  )
, 'scheme' => array(
    'type' => 'list'
  , 'options' => array(
      array(
        'name' => '-1 (relative to site_url)'
      , 'value' => -1
      )
    , array(
        'name' => 'full (absolute, prepended with site_url)'
      , 'value' => 'full'
      )
    , array(
        'name' => 'abs (absolute, prepended with base_url)'
      , 'value' => 'abs'
      )
    , array(
        'name' => 'http (absolute, forced to http scheme)'
      , 'value' => 'http'
      )
    , array(
        'name' => 'https (absolute, forced to https scheme)'
      , 'value' => 'https'
      )
    )
  , 'value' => -1
  ),
  'useWeblinkUrl' => array(
    'type' => 'combo-boolean',
    'value' => false,
  ),

);
foreach ($tmp as $k => $v) {
  $properties[] = array_merge(
    array(
      'name' => $k,
      'desc' => PKG_NAME_LOWER . '_prop_' . $k,
      'lexicon' => PKG_NAME_LOWER . ':properties',
    ), $v
  );
}

return $properties;