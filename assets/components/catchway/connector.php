<?php
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var catchway $catchway */
$catchway = $modx->getService('catchway', 'catchway', $modx->getOption('catchway_core_path', null, $modx->getOption('core_path') . 'components/catchway/') . 'model/catchway/');
$modx->lexicon->load('catchway:default');

// handle request
$corePath = $modx->getOption('catchway_core_path', null, $modx->getOption('core_path') . 'components/catchway/');
$path = $modx->getOption('processorsPath', $catchway->config, $corePath . 'processors/');
$modx->request->handleRequest(array(
  'processors_path' => $path,
  'location' => '',
));