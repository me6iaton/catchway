<?php

/**
 * The base class for catchway.
 */
class Catchway {
  /* @var modX $modx */
  public $modx;
  /** @var pdoFetch $pdoFetch */
  public $pdoTools;

  /**
   * @param modX $modx
   * @param array $config
   */
  function __construct(modX &$modx, array $config = array()) {
    $this->modx =& $modx;

    $corePath = $this->modx->getOption('catchway_core_path', $config, $this->modx->getOption('core_path') . 'components/catchway/');
    $assetsUrl = $this->modx->getOption('catchway_assets_url', $config, $this->modx->getOption('assets_url') . 'components/catchway/');
    $connectorUrl = $assetsUrl . 'connector.php';

    $this->config = array_merge(array(
      'assetsUrl' => $assetsUrl,
      'cssUrl' => $assetsUrl . 'css/',
      'jsUrl' => $assetsUrl . 'js/',
      'imagesUrl' => $assetsUrl . 'images/',
      'connectorUrl' => $connectorUrl,

      'corePath' => $corePath,
      'modelPath' => $corePath . 'model/',
      'chunksPath' => $corePath . 'elements/chunks/',
      'templatesPath' => $corePath . 'elements/templates/',
      'chunkSuffix' => '.chunk.tpl',
      'snippetsPath' => $corePath . 'elements/snippets/',
      'processorsPath' => $corePath . 'processors/'
    ), $config);

    $this->modx->addPackage('catchway', $this->config['modelPath']);
    $this->modx->lexicon->load('catchway:default');
  }

  /**
   * Process and return the output from a Chunk by name.
   *
   * @param string $name The name of the chunk.
   * @param array $properties An associative array of properties to process the Chunk with, treated as placeholders within the scope of the Element.
   * @param boolean $fastMode If false, all MODX tags in chunk will be processed.
   *
   * @return string The processed output of the Chunk.
   */
  public function getChunk($name, array $properties = array(), $fastMode = false)
  {
    if (!$this->modx->parser) {
      $this->modx->getParser();
    }
    if (!$this->pdoTools) {
      $this->loadPdoTools();
    }

    return $this->pdoTools->getChunk($name, $properties, $fastMode);
  }

  /**
   * Loads an instance of pdoTools
   *
   * @param array $config
   *
   * @return boolean
   */
  public function loadPdoTools($config = array())
  {
      /** @var pdoFetch $pdoFetch */
      $fqn = $this->modx->getOption('pdoFetch.class', null, 'pdotools.pdofetch', true);
      if ($pdoClass = $this->modx->loadClass($fqn, '', false, true)) {
        $this->pdoTools = new $pdoClass($this->modx, $config);
      }
      return true;
  }

  /**
   * @param string $name
   * @return null|string
   */
  public function getContextKey($name){
    $fieldCityname = $this->modx->getOption('catchway_default_field_cityname');
    $this->loadPdoTools(array(
      'parents' => 0
    , 'limit' => 1
    , 'return' => 'data'
    , 'where' => array($fieldCityname . ':=' => $name)
    ));
    $res = $this->pdoTools->run();
    if($res){
      return $res[0]['context_key'];
    }else{
      return null;
    }
  }
  /**
   * @param string $name
   * @param string $context
   * @return array|bool|string
   */
  public function getSityId($name, $context)
  {
    $fieldCityname = $this->modx->getOption('catchway_default_field_cityname');
    $this->loadPdoTools(array(
      'parents' => 0
    , 'context' => $context
    , 'limit' => 1
    , 'return' => 'ids'
    , 'where' => array($fieldCityname . ':=' => $name)
    ));
    return $this->pdoTools->run();
  }

  /**
   * @param array $config
   * @return string
   */
  public function getCities ($config = array()){
    $output = '';
    $config = array_merge(array(
      'parents' => 0
      ,'limit' => 300
      ,'context' => $this->modx->context->key
      ,'where' => array('properties:LIKE' => '%{"catchway_city":"1"}%')
      ,'return' => 'data'
    ), $config);
    $this->loadPdoTools($config);
    $cities = $this->pdoTools->run();
    foreach($cities as $item){
      if($item['pagetitle'] == $_COOKIE['catchway-city-name']){
        $item['selected'] = 'selected';
      }
      $output = $output . $this->getChunk($config['tpl'], $item, $config['fastMode']);
    }
    return $output;
  }
}