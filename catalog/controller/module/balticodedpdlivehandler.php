<?php  
class ControllerModulebalticodedpdlivehandler extends Controller { 
	protected function index() {
		$this->language->load('module/balticodedpdlivehandler');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_mymod'] 		= $this->language->get('text_mymod');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/balticodedpdlivehandler.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/balticodedpdlivehandler.tpl';
		} else {
			$this->template = 'default/template/module/balticodedpdlivehandler.tpl';
		}
		
		$this->render();
	}
}
?>