<?php
$modx->log(modX::LOG_LEVEL_ERROR, 'catchway test 4');
/* @var Catchway $Catchway */
$Catchway = $modx->getService('catchway', 'Catchway', $modx->getOption('catchway_core_path', null, $modx->getOption('core_path') . 'components/catchway/') . 'model/catchway/');

switch ($modx->event->name) {
  case 'OnHandleRequest':
    if ($modx->context->key == 'mgr') break;

    if($_REQUEST['catchway_city']){
      $Catchway->loadPdoTools([
        'parents' => 0
        , 'limit' => 1
        , 'return' => 'ids'
        , 'where' => '{"pagetitle:=":"' . $_REQUEST['catchway_city'] . '"}'
      ]);
      $id = $Catchway->pdoTools->run();
      $parts = array_reverse(explode('.', $_SERVER['SERVER_NAME']));
      $domain = $parts[1].'.'.$parts[0];
      $time = time() + 60 * 60 * 24 * 60;
      setcookie('catchway-city-name',$_REQUEST['catchway_city'],$time,null,$domain);
      setcookie('catchway-city-id',$id,$time,null,$domain);
      $modx->sendRedirect($modx->makeUrl($id));
      break;
    }

    if($_SERVER['REQUEST_URI'] == '/'){
      if (empty($_COOKIE['catchway-city-id'])) {
        if ($catchwayJs = $modx->getOption('catchway_frontend_js')) {
          $modx->regClientHTMLBlock($Catchway->getChunk('tpl.catchway.modal'));
          $modx->regClientScript($modx->getOption('catchway_assets_url') . 'vendor/curl/dist/curl-with-js-and-domReady/curl.js');
          $modx->regClientScript($catchwayJs);
          break;
        }
      }else {
        $modx->sendRedirect($modx->makeUrl($_COOKIE['catchway-city-id']));
        break;
      }
    }


    break;
}