<?php
/* @var Catchway $Catchway */
$Catchway = $modx->getService('catchway', 'Catchway', $modx->getOption('catchway_core_path', null, $modx->getOption('core_path') . 'components/catchway/') . 'model/catchway/');

$output = $Catchway->getCities($scriptProperties);

if (!empty($tplWrapper)) {
  $output = $Catchway->getChunk($tplWrapper, array('output' => $output), $fastMode);
}

return $output;