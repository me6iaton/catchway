<?php
if($_COOKIE['catchway-city-name'] == 'default'){
  $res = $modx->getObject('modResource', array('id' => $modx->getOption('catchway_default_page'), 'context_key' => $modx->context->key));
  if ($res) {
    return $res->get('pagetitle');
  }
}else{
  return $_COOKIE['catchway-city-name'];
}
