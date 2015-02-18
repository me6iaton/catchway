<?php
$modx->log(modX::LOG_LEVEL_ERROR, 'catchway test 4');
//error_log('catchway test 2');
switch ($modx->event->name) {
  case 'OnHandleRequest':
    if($modx->context->key == 'mgr') break;
    $url = $modx->makeUrl(98);
    if ($_REQUEST['q'] !== $url) {
      $modx->sendRedirect($url);
    }
    break;
}