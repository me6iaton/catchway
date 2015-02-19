<?php
$modx->log(modX::LOG_LEVEL_ERROR, 'catchway test 4');
//error_log('catchway test 2');
switch ($modx->event->name) {
  case 'OnHandleRequest':
    if ($modx->context->key == 'mgr') break;

    if(empty($_COOKIE['catchway-city-name'])){
      if($catchwayJs = $modx->getOption('catchway_frontend_js')){
        $modx->regClientHTMLBlock($modx->getChunk('tpl.catchway.modal'));
        $modx->regClientScript($modx->getOption('catchway_assets_url') . 'vendor/curl/dist/curl-with-js-and-domReady/curl.js');
        $modx->regClientScript($catchwayJs);
      }
    }else{
      $url = $modx->makeUrl(98);
      if ($_REQUEST['q'] !== $url) {
        $modx->sendRedirect($url);
      }
    }
    break;
}