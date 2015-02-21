<?php
/** @var pdoFetch $pdoFetch */
$fqn = $modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
if ($pdoClass = $modx->loadClass($fqn, '', false, true)) {
  $pdoFetch = new $pdoClass($modx, $scriptProperties);
} elseif ($pdoClass = $modx->loadClass($fqn, MODX_CORE_PATH . 'components/pdotools/model/', false, true)) {
  $pdoFetch = new $pdoClass($modx, $scriptProperties);
} else {
  $modx->log(modX::LOG_LEVEL_ERROR, 'Could not load pdoFetch from "MODX_CORE_PATH/components/pdotools/model/".');
  return false;
}
$pdoFetch->addTime('pdoTools loaded');

if (empty($tpl)) {
  $tpl = 'tpl.Tickets.comment.list.row';
}