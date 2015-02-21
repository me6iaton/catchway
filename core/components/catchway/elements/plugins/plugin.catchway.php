<?php
$modx->log(modX::LOG_LEVEL_ERROR, 'catchway test 4');
/* @var Catchway $Catchway */
$Catchway = $modx->getService('catchway', 'Catchway', $modx->getOption('catchway_core_path', null, $modx->getOption('core_path') . 'components/catchway/') . 'model/catchway/');

switch ($modx->event->name) {
  case 'OnHandleRequest':
    if ($context == 'mgr') break;
    $context = $modx->context->key;
    $cookieNameId = 'catchway-city-' . $context . '-id';
    $time = time() + 60 * 60 * 24 * 60;
    $parts = array_reverse(explode('.', $_SERVER['SERVER_NAME']));
    $domain = $parts[1] . '.' . $parts[0];

    // set city
    if ($city = $_REQUEST['catchway_city']) {
      if ($city == 'default') {
        $id = $modx->getOption('catchway_default_page');
      } else {
        // clean old cookie in all contexts
        $Catchway->loadPdoTools([
          'class' => 'modContext'
          , 'limit' => 100
          , 'return' => 'data'
        ]);
        $contexts = $Catchway->pdoTools->run();
        foreach ($contexts as $item) {
          if ($item['key'] == 'mgr') continue;
          setcookie('catchway-city-' . $item['key'] . '-id', '', time() - 3600);
        }
        // get id
        $Catchway->loadPdoTools([
          'parents' => 0
          , 'context' => $context
          , 'limit' => 1
          , 'return' => 'ids'
          , 'where' => '{"pagetitle:=":"' . $city . '"}'
        ]);
        $id = $Catchway->pdoTools->run();
      }

      setcookie('catchway-city-name', $city, $time, null, $domain);
      setcookie($cookieNameId, $id, $time, null, $domain);
      $url = $modx->makeUrl($id);
      $modx->sendRedirect($url);
      break;
    }

    if ($_SERVER['REQUEST_URI'] == '/') {
      if (isset($_COOKIE[$cookieNameId])) {
        // prevent a redirect loop
        if ($_COOKIE['catchway-city-id'] !== '1') {
          $modx->sendRedirect($modx->makeUrl($_COOKIE[$cookieNameId]));
          break;
        }
      } else if (isset($_COOKIE['catchway-city-name'])) {
        // get id
        $Catchway->loadPdoTools([
          'parents' => 0
          , 'context' => $context
          , 'limit' => 1
          , 'return' => 'ids'
          , 'where' => '{"pagetitle:=":"' . $_COOKIE['catchway-city-name'] . '"}'
        ]);
        $id = $Catchway->pdoTools->run();
        if($id){
          $modx->sendRedirect($modx->makeUrl($id));
          break;
        }else{
          if($id = $modx->getOption('catchway_default_page')){
            $modx->sendRedirect($modx->makeUrl($id));
            break;
          }
        }
      }else {
        if ($catchwayJs = $modx->getOption('catchway_frontend_js')) {
          $modx->regClientHTMLBlock($Catchway->getChunk('tpl.catchway.modal'));
          $modx->regClientScript($modx->getOption('catchway_assets_url') . 'vendor/curl/dist/curl-with-js-and-domReady/curl.js');
          $modx->regClientScript($catchwayJs);
          break;
        }
      }
    }


    break;
}