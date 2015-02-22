<?php
if($_COOKIE['catchway-city-name'] == 'default'){
  $res = $modx->getObject('modResource', array('id' => $_COOKIE['catchway-city-'.$modx->context->key.'-id'], 'context_key' => $modx->context->key));
  if ($res) {
    return $res->get('pagetitle');
  }
}else{
  return $_COOKIE['catchway-city-name'];
}
