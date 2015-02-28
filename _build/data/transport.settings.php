<?php

$settings = array();

$tmp = array(
  'core_path' => array(
    'value' => PKG_CORE_PATH,
    'xtype' => 'textfield',
    'area' => 'catchway.main',
  ),
  'assets_url' => array(
    'value' => PKG_ASSETS_URL,
    'xtype' => 'textfield',
    'area' => 'catchway.main',
  ),
  'frontend_js' => array(
    'value' => PKG_ASSETS_URL . 'js/web/catchway.js',
    'xtype' => 'textfield',
    'area' => 'catchway.main',
  ),
  'default_page' => array(
    'value' => 1,
    'xtype' => 'numberfield',
    'area' => 'catchway.main',
  ),
  'default_field_cityname' => array(
    'value' => 'pagetitle',
    'xtype' => 'textfield',
    'area' => 'catchway.main',
  )

);

foreach ($tmp as $k => $v) {
  /* @var modSystemSetting $setting */
  $setting = $modx->newObject('modSystemSetting');
  $setting->fromArray(array_merge(
    array(
      'key' => 'catchway_' . $k,
      'namespace' => PKG_NAME_LOWER,
    ), $v
  ), '', true, true);

  $settings[] = $setting;
}

unset($tmp);
return $settings;
