<?php

/**
 * Class catchwayMainController
 */
abstract class catchwayMainController extends modExtraManagerController {
	/** @var catchway $catchway */
	public $catchway;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('catchway_core_path', null, $this->modx->getOption('core_path') . 'components/catchway/');
		require_once $corePath . 'model/catchway/catchway.class.php';

		$this->catchway = new catchway($this->modx);
		$this->addCss($this->catchway->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->catchway->config['jsUrl'] . 'mgr/catchway.js');
		$this->addHtml('
		<script type="text/javascript">
			catchway.config = ' . $this->modx->toJSON($this->catchway->config) . ';
			catchway.config.connector_url = "' . $this->catchway->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('catchway:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends catchwayMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}