<?php
/* @var Catchway $Catchway */
$Catchway = $modx->getService('catchway', 'Catchway', $modx->getOption('catchway_core_path', null, $modx->getOption('core_path') . 'components/catchway/') . 'model/catchway/');
$modx->addPackage('catchway', $modx->getOption('catchway_core_path', null, $modx->getOption('core_path') . 'components/catchway/') . 'model/');
$modx->getService('lexicon', 'modLexicon');
$modx->lexicon->load('catchway:default');
$context = $modx->context->key;

switch ($modx->event->name) {
  case 'OnHandleRequest':
    if ($context == 'mgr') return;
    $cookieNameId = 'catchway-city-' . $context . '-id';
    $time = time() + 60 * 60 * 24 * 60;
    $parts = array_reverse(explode('.', $_SERVER['SERVER_NAME']));
    $domain = $parts[1] . '.' . $parts[0];

    // set city, if $_REQUEST['catchway_city']
    if ($city = $_REQUEST['catchway_city']) {
      // clean old cookie in all contexts
      $Catchway->loadPdoTools([
        'class' => 'modContext'
        , 'limit' => 100
        , 'return' => 'data'
      ]);
      $contexts = $Catchway->pdoTools->run();
      foreach ($contexts as $item) {
        if ($item['key'] == 'mgr') continue;
        setcookie('catchway-city-' . $item['key'] . '-id', '', time() - 3600, null, $domain);
      }

      if ($city == 'default') {
        $id = $modx->getOption('catchway_default_page');
        if(!$id){
          $modx->sendRedirect('/');
          break;
        }
      } else {
        // get city id
        $id = $Catchway->getSityId($context, $city);
      }
      // set new cookies
      setcookie('catchway-city-name', $city, $time, null, $domain);
      setcookie($cookieNameId, $id, $time, null, $domain);
      // update user
      if ($profile = $modx->user->getOne('Profile')) {
        $profile->set('city', $city);
        $profile->save();
      }
      // redirect
      $url = $modx->makeUrl($id);
      $modx->sendRedirect($url);
      break;
    }

    // redirect to city page
    if ($_SERVER['REQUEST_URI'] == '/') {
      if (isset($_COOKIE[$cookieNameId])) {
        if ($url = $modx->makeUrl($_COOKIE[$cookieNameId], $context) == '/') {
          break; // prevent a redirect loop
        } else {
          $modx->sendRedirect($modx->makeUrl($_COOKIE[$cookieNameId]));
          break;
        }
      } else if (isset($_COOKIE['catchway-city-name'])) {
        // if $cookieNameId not found in this context, get city id
        $id = $Catchway->getSityId($context, $_COOKIE['catchway-city-name']);
        if ($id) {
          setcookie($cookieNameId, $id, $time, null, $domain);
          $modx->sendRedirect($modx->makeUrl($id));
          break;
        } else {
          // redirect default city page
          if ($id = $modx->getOption('catchway_default_page')) {
            $res = $modx->getObject('modResource', array('id' => $id, 'context_key' => $context));
            if ($res) {
              setcookie($cookieNameId, $id, $time, null, $domain);
              $url = $modx->makeUrl($id, $context);
              if ($url !== $_SERVER['REQUEST_URI']){
                $modx->sendRedirect($url);
              }
              break;
            }
          }
        }
      }

      // show modal dialog, if sity not found before this
      if ($catchwayJs = $modx->getOption('catchway_frontend_js')) {
        $cities = $Catchway->getCities(array('tpl' => 'tpl.catchway.modal.cities.row'));
        $output = $Catchway->getChunk('tpl.catchway.modal', array('output' => $cities), false);
        $modx->regClientHTMLBlock($output);
        $modx->regClientScript($modx->getOption('catchway_assets_url') . 'vendor/curl/dist/curl-with-js-and-domReady/curl.js');
        $modx->regClientScript($catchwayJs);
        break;
      }
    }
    break;

  case 'OnUserActivate':
    if ($context == 'mgr') return;
    // update user
    if (isset($_COOKIE['catchway-city-name'])){
      if ($profile = $modx->user->getOne('Profile')) {
        if(!$profile->get('city')){
          $profile->set('city', $_COOKIE['catchway-city-name']);
          $profile->save();
        }
      }
    }
    break;

  case 'OnDocFormPrerender':
    $modx->controller->addJavascript($modx->getOption('catchway_assets_url') . 'js/mgr/catchway.js');
    break;

  case 'OnBeforeDocFormSave':
    $resource =& $modx->event->params['resource'];
    if (isset($_POST['catchway-city'])) {
      $catchwayCity = $_POST['catchway-city'];
    } else{
      $catchwayCity = '0';
    }
    $resource->setProperties(array('catchway_city' => $catchwayCity), 'catchway', false);
    break;
}