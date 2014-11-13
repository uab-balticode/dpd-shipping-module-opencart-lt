<?php
/*
* @package		MijoShop
* @copyright	2009-2013 Mijosoft LLC, mijosoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
//defined('_JEXEC') or die('Restricted access');

class ControllerShippingBalticodedpdcourier extends Controller { 
	private $error = array();
	
	public function index() {  
		$this->language->load('shipping/balticodedpdcourier');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('balticodedpdcourier', $this->request->post);	

			$this->session->data['success'] = $this->language->get('text_success');
									
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		
		$this->data['entry_baseshippingprice'] = $this->language->get('entry_baseshippingprice');
		$this->data['entry_priceperadditional'] = $this->language->get('entry_priceperadditional');
		$this->data['entry_freeshippingfrom'] = $this->language->get('entry_freeshippingfrom');
		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_disableifhtml'] = $this->language->get('entry_disableifhtml');
		$this->data['entry_maxweight'] = $this->language->get('entry_maxweight');
		$this->data['entry_handlingaction'] = $this->language->get('entry_handlingaction');
		$this->data['balticodedpdcourier_handlingactions'] = array($this->language->get('Per order'), $this->language->get('Per package'));
		$this->data['entry_enablefreeshipping'] = $this->language->get('entry_enablefreeshipping');
		$this->data['entry_freeshippingsubtotal'] = $this->language->get('entry_freeshippingsubtotal');
		$this->data['entry_enablecod'] = $this->language->get('entry_enablecod');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/balticodedpdcourier', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/balticodedpdcourier', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'); 

		$this->load->model('localisation/geo_zone');
		
		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();
		
		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'])) {
				$this->data['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'] = $this->request->post['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'];
			} else {
				$this->data['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'] = $this->config->get('balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_baseshippingprice');
			}
			
			if (isset($this->request->post['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_priceperadditional'])) {
				$this->data['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_priceperadditional'] = $this->request->post['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_priceperadditional'];
			} else {
				$this->data['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_priceperadditional'] = $this->config->get('balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_priceperadditional');
			}
			
			if (isset($this->request->post['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'])) {
				$this->data['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'] = $this->request->post['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'];
			} else {
				$this->data['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'] = $this->config->get('balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom');
			}
			
			if (isset($this->request->post['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$this->data['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$this->data['balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_status');
			}		
		}
		
		$this->data['geo_zones'] = $geo_zones;

		if (isset($this->request->post['balticodedpdcourier_tax_class_id'])) {
			$this->data['balticodedpdcourier_tax_class_id'] = $this->request->post['balticodedpdcourier_tax_class_id'];
		} else {
			$this->data['balticodedpdcourier_tax_class_id'] = $this->config->get('balticodedpdcourier_tax_class_id');
		}
		
		if (isset($this->request->post['balticodedpdcourier_price'])) {
			$this->data['balticodedpdcourier_price'] = $this->request->post['balticodedpdcourier_price'];
		} else {
			$this->data['balticodedpdcourier_price'] = $this->config->get('balticodedpdcourier_price');
		}
		if (isset($this->request->post['balticodedpdcourier_disableifhtml'])) {
			$this->data['balticodedpdcourier_disableifhtml'] = $this->request->post['balticodedpdcourier_disableifhtml'];
		} else {
			$this->data['balticodedpdcourier_disableifhtml'] = $this->config->get('balticodedpdcourier_disableifhtml');
		}
		if (isset($this->request->post['balticodedpdcourier_maxweight'])) {
			$this->data['balticodedpdcourier_maxweight'] = $this->request->post['balticodedpdcourier_maxweight'];
		} else {
			$this->data['balticodedpdcourier_maxweight'] = $this->config->get('balticodedpdcourier_maxweight');
		}
		if (isset($this->request->post['balticodedpdcourier_handlingaction'])) {
			$this->data['balticodedpdcourier_handlingaction'] = $this->request->post['balticodedpdcourier_handlingaction'];
		} else {
			$this->data['balticodedpdcourier_handlingaction'] = $this->config->get('balticodedpdcourier_handlingaction');
		}
		if (isset($this->request->post['balticodedpdcourier_enablefreeshipping'])) {
			$this->data['balticodedpdcourier_enablefreeshipping'] = $this->request->post['balticodedpdcourier_enablefreeshipping'];
		} else {
			$this->data['balticodedpdcourier_enablefreeshipping'] = $this->config->get('balticodedpdcourier_enablefreeshipping');
		}
		if (isset($this->request->post['balticodedpdcourier_freeshippingsubtotal'])) {
			$this->data['balticodedpdcourier_freeshippingsubtotal'] = $this->request->post['balticodedpdcourier_freeshippingsubtotal'];
		} else {
			$this->data['balticodedpdcourier_freeshippingsubtotal'] = $this->config->get('balticodedpdcourier_freeshippingsubtotal');
		}
		if (isset($this->request->post['balticodedpdcourier_enablecod'])) {
			$this->data['balticodedpdcourier_enablecod'] = $this->request->post['balticodedpdcourier_enablecod'];
		} else {
			$this->data['balticodedpdcourier_enablecod'] = $this->config->get('balticodedpdcourier_enablecod');
		}
		
		$this->load->model('localisation/tax_class');
				
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		if (isset($this->request->post['balticodedpdcourier_status'])) {
			$this->data['balticodedpdcourier_status'] = $this->request->post['balticodedpdcourier_status'];
		} else {
			$this->data['balticodedpdcourier_status'] = $this->config->get('balticodedpdcourier_status');
		}
		
		if (isset($this->request->post['balticodedpdcourier_sort_order'])) {
			$this->data['balticodedpdcourier_sort_order'] = $this->request->post['balticodedpdcourier_sort_order'];
		} else {
			$this->data['balticodedpdcourier_sort_order'] = $this->config->get('balticodedpdcourier_sort_order');
		}	

		$this->template = 'shipping/balticodedpdcourier.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
		
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/balticodedpdcourier')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>