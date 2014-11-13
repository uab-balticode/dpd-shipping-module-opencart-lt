<?php
/*
* @package		MijoShop
* @copyright	2009-2013 Mijosoft LLC, mijosoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
//defined('_JEXEC') or die('Restricted access');

error_reporting(E_ALL);
ini_set("display_errors", 1);

class ControllerShippingbalticodedpdparcelstore extends Controller { 
	private $error = array();
	
	public function index() {  
		$this->language->load('shipping/balticodedpdparcelstore');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('balticodedpdparcelstore', $this->request->post);	

			$this->session->data['success'] = $this->language->get('text_success');
									
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if ( $this->error ) {
			$this->data['error'] = $this->error;
		} else {
			$this->data['error'] = array();
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

		$this->data['text_send_after_checkout'] = $this->language->get('text_send_after_checkout');
		$this->data['text_send_after_shipment'] = $this->language->get('text_send_after_shipment');
		$this->data['text_send_manual'] = $this->language->get('text_send_manual');
		$this->data['text_all_allowed_countries'] = $this->language->get('text_all_allowed_countries');
		$this->data['text_specific_countries'] = $this->language->get('text_specific_countries');
		$this->data['text_rebuild'] = $this->language->get('text_rebuild');
		$this->data['entry_baseshippingprice'] = $this->language->get('entry_baseshippingprice');
		$this->data['entry_priceperadditional'] = $this->language->get('entry_priceperadditional');
		$this->data['entry_freeshippingfrom'] = $this->language->get('entry_freeshippingfrom');
		$this->data['entry_price'] = $this->language->get('entry_price');
		$this->data['entry_short_office_names'] = $this->language->get('entry_short_office_names');
		$this->data['entry_sort_office_by_priority'] = $this->language->get('entry_sort_office_by_priority');

		$this->data['entry_disableifhtml'] = $this->language->get('entry_disableifhtml');
		$this->data['entry_maxweight'] = $this->language->get('entry_maxweight');
		$this->data['entry_handlingaction'] = $this->language->get('entry_handlingaction');
		$this->data['balticodedpdparcelstore_handlingactions'] = array($this->language->get('Per order'), $this->language->get('Per package'));
		$this->data['entry_enablefreeshipping'] = $this->language->get('entry_enablefreeshipping');
		$this->data['entry_freeshippingsubtotal'] = $this->language->get('entry_freeshippingsubtotal');
		$this->data['entry_auto_send_data'] = $this->language->get('entry_auto_send_data');
/* SHOW IF balticodedpdparcelstore_auto_send_data IS VALUE "1" start */
		$this->data['entry_send_parcel_data']=$this->language->get('entry_send_parcel_data');
		$this->data['entry_order_status_id']=$this->language->get('entry_order_status_id');
		$this->data['entry_pickup_address_name']=$this->language->get('entry_pickup_address_name');
		$this->data['entry_pickup_address_company']=$this->language->get('entry_pickup_address_company');
		$this->data['entry_pickup_address_email']=$this->language->get('entry_pickup_address_email');
		$this->data['entry_pickup_address_phone']=$this->language->get('entry_pickup_address_phone');
		$this->data['entry_pickup_address_street']=$this->language->get('entry_pickup_address_street');
		$this->data['entry_pickup_address_city_county']=$this->language->get('entry_pickup_address_city_county');
		$this->data['entry_pickup_adress_zip_code']=$this->language->get('entry_pickup_adress_zip_code');
		$this->data['entry_pickup_address_country']=$this->language->get('entry_pickup_address_country');
/* SHOW IF balticodedpdparcelstore_auto_send_data IS VALUE "1" end */
		$this->data['entry_error_message']=$this->language->get('entry_error_message');
		$this->data['entry_ship_to_specific_status']=$this->language->get('entry_ship_to_specific_status');
		$this->data['entry_ship_to_specific_list']=$this->language->get('entry_ship_to_specific_list');
		$this->data['entry_pixels_city']=$this->language->get('entry_pixels_city');
		$this->data['entry_pixels_office']=$this->language->get('entry_pixels_office');
		$this->data['entry_show_one_dropdown_status']=$this->language->get('entry_show_one_dropdown_status');
		$this->data['entry_update_interval']=$this->language->get('entry_update_interval');
		$this->data['entry_population_list_of_list_status']=$this->language->get('entry_population_list_of_list_status');
		$this->data['entry_rebuild_list_status']=$this->language->get('entry_rebuild_list_status');
		$this->data['entry_allow_courier_pickup'] = $this->language->get('entry_allow_courier_pickup');

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
			'href'      => $this->url->link('shipping/balticodedpdparcelstore', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('shipping/balticodedpdparcelstore', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'); 

		$this->load->model('localisation/geo_zone');
		
		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();
		
		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'])) {
				$this->data['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'] = $this->request->post['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'];
			} else {
				$this->data['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'] = $this->config->get('balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_baseshippingprice');
			}
			
			if (isset($this->request->post['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_priceperadditional'])) {
				$this->data['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_priceperadditional'] = $this->request->post['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_priceperadditional'];
			} else {
				$this->data['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_priceperadditional'] = $this->config->get('balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_priceperadditional');
			}
			
			if (isset($this->request->post['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'])) {
				$this->data['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'] = $this->request->post['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'];
			} else {
				$this->data['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'] = $this->config->get('balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom');
			}
			
			if (isset($this->request->post['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_status'])) {
				$this->data['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_status'];
			} else {
				$this->data['balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_status');
			}		
		}
		$this->data['geo_zones'] = $geo_zones;
		
		
		$this->load->model('localisation/order_status');

		$this->data['balticodedpdparcelstore_order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['balticodedpdparcelstore_tax_class_id'])) {
			$this->data['balticodedpdparcelstore_tax_class_id'] = $this->request->post['balticodedpdparcelstore_tax_class_id'];
		} else {
			$this->data['balticodedpdparcelstore_tax_class_id'] = $this->config->get('balticodedpdparcelstore_tax_class_id');
		}
		if (isset($this->request->post['balticodedpdparcelstore_price'])) {
			$this->data['balticodedpdparcelstore_price'] = $this->request->post['balticodedpdparcelstore_price'];
		} else {
			$this->data['balticodedpdparcelstore_price'] = $this->config->get('balticodedpdparcelstore_price');
		}
		if (isset($this->request->post['balticodedpdparcelstore_short_office_names'])) {
			$this->data['balticodedpdparcelstore_short_office_names'] = $this->request->post['balticodedpdparcelstore_short_office_names'];
		} else {
			$this->data['balticodedpdparcelstore_short_office_names'] = $this->config->get('balticodedpdparcelstore_short_office_names');
		}
		if (isset($this->request->post['balticodedpdparcelstore_sort_office_by_priority'])) {
			$this->data['balticodedpdparcelstore_sort_office_by_priority'] = $this->request->post['balticodedpdparcelstore_sort_office_by_priority'];
		} else {
			$this->data['balticodedpdparcelstore_sort_office_by_priority'] = $this->config->get('balticodedpdparcelstore_sort_office_by_priority');
		}
		if (isset($this->request->post['balticodedpdparcelstore_disableifhtml'])) {
			$this->data['balticodedpdparcelstore_disableifhtml'] = $this->request->post['balticodedpdparcelstore_disableifhtml'];
		} else {
			$this->data['balticodedpdparcelstore_disableifhtml'] = $this->config->get('balticodedpdparcelstore_disableifhtml');
		}
		if (isset($this->request->post['balticodedpdparcelstore_maxweight'])) {
			$this->data['balticodedpdparcelstore_maxweight'] = $this->request->post['balticodedpdparcelstore_maxweight'];
		} else {
			$this->data['balticodedpdparcelstore_maxweight'] = $this->config->get('balticodedpdparcelstore_maxweight');
		}
		if (isset($this->request->post['balticodedpdparcelstore_handlingaction'])) {
			$this->data['balticodedpdparcelstore_handlingaction'] = $this->request->post['balticodedpdparcelstore_handlingaction'];
		} else {
			$this->data['balticodedpdparcelstore_handlingaction'] = $this->config->get('balticodedpdparcelstore_handlingaction');
		}
		if (isset($this->request->post['balticodedpdparcelstore_enablefreeshipping'])) {
			$this->data['balticodedpdparcelstore_enablefreeshipping'] = $this->request->post['balticodedpdparcelstore_enablefreeshipping'];
		} else {
			$this->data['balticodedpdparcelstore_enablefreeshipping'] = $this->config->get('balticodedpdparcelstore_enablefreeshipping');
		}
		if (isset($this->request->post['balticodedpdparcelstore_freeshippingsubtotal'])) {
			$this->data['balticodedpdparcelstore_freeshippingsubtotal'] = $this->request->post['balticodedpdparcelstore_freeshippingsubtotal'];
		} else {
			$this->data['balticodedpdparcelstore_freeshippingsubtotal'] = $this->config->get('balticodedpdparcelstore_freeshippingsubtotal');
		}
		if (isset($this->request->post['balticodedpdparcelstore_auto_send_data'])) {
			$this->data['balticodedpdparcelstore_auto_send_data'] = $this->request->post['balticodedpdparcelstore_auto_send_data'];
		} else {
			$this->data['balticodedpdparcelstore_auto_send_data'] = $this->config->get('balticodedpdparcelstore_auto_send_data');
		}
/* SHOW IF balticodedpdparcelstore_auto_send_data IS VALUE "1" start */
		if(isset($this->request->post['balticodedpdparcelstore_send_parcel_data'])){
			$this->data['balticodedpdparcelstore_send_parcel_data'] = $this->request->post['balticodedpdparcelstore_send_parcel_data'];
		} else {
			$this->data['balticodedpdparcelstore_send_parcel_data'] = $this->config->get('balticodedpdparcelstore_send_parcel_data');
		}
		if(isset($this->request->post['balticodedpdparcelstore_order_status_id'])){
			$this->data['balticodedpdparcelstore_order_status_id'] = $this->request->post['balticodedpdparcelstore_order_status_id'];
		} else {
			$this->data['balticodedpdparcelstore_order_status_id'] = $this->config->get('balticodedpdparcelstore_order_status_id');
		}
		if(isset($this->request->post['balticodedpdparcelstore_pickup_address_name'])){
			$this->data['balticodedpdparcelstore_pickup_address_name'] = $this->request->post['balticodedpdparcelstore_pickup_address_name'];
		} else {
			$this->data['balticodedpdparcelstore_pickup_address_name'] = $this->config->get('balticodedpdparcelstore_pickup_address_name');
		}		
		if(isset($this->request->post['balticodedpdparcelstore_pickup_address_company'])){
			$this->data['balticodedpdparcelstore_pickup_address_company'] = $this->request->post['balticodedpdparcelstore_pickup_address_company'];
		} else {
			$this->data['balticodedpdparcelstore_pickup_address_company'] = $this->config->get('balticodedpdparcelstore_pickup_address_company');
		}		
		if(isset($this->request->post['balticodedpdparcelstore_pickup_address_email'])){
			$this->data['balticodedpdparcelstore_pickup_address_email'] = $this->request->post['balticodedpdparcelstore_pickup_address_email'];
		} else {
			$this->data['balticodedpdparcelstore_pickup_address_email'] = $this->config->get('balticodedpdparcelstore_pickup_address_email');
		}		
		if(isset($this->request->post['balticodedpdparcelstore_pickup_address_phone'])){
			$this->data['balticodedpdparcelstore_pickup_address_phone'] = $this->request->post['balticodedpdparcelstore_pickup_address_phone'];
		} else {
			$this->data['balticodedpdparcelstore_pickup_address_phone'] = $this->config->get('balticodedpdparcelstore_pickup_address_phone');
		}		
		if(isset($this->request->post['balticodedpdparcelstore_pickup_address_street'])){
			$this->data['balticodedpdparcelstore_pickup_address_street'] = $this->request->post['balticodedpdparcelstore_pickup_address_street'];
		} else {
			$this->data['balticodedpdparcelstore_pickup_address_street'] = $this->config->get('balticodedpdparcelstore_pickup_address_street');
		}
		if(isset($this->request->post['balticodedpdparcelstore_pickup_address_city_county'])){
			$this->data['balticodedpdparcelstore_pickup_address_city_county'] = $this->request->post['balticodedpdparcelstore_pickup_address_city_county'];
		} else {
			$this->data['balticodedpdparcelstore_pickup_address_city_county'] = $this->config->get('balticodedpdparcelstore_pickup_address_city_county');
		}

		$this->load->model('localisation/country');
		$this->data['balticodedpdparcelstore_pickup_address_country_list'] = $this->model_localisation_country->getCountries();

		if(isset($this->request->post['balticodedpdparcelstore_pickup_adress_zip_code'])){
			$this->data['balticodedpdparcelstore_pickup_adress_zip_code'] = $this->request->post['balticodedpdparcelstore_pickup_adress_zip_code'];
		} else {
			$this->data['balticodedpdparcelstore_pickup_adress_zip_code'] = $this->config->get('balticodedpdparcelstore_pickup_adress_zip_code');
		}
		if(isset($this->request->post['balticodedpdparcelstore_pickup_address_country'])){
			$this->data['balticodedpdparcelstore_pickup_address_country'] = $this->request->post['balticodedpdparcelstore_pickup_address_country'];
		} else {
			$this->data['balticodedpdparcelstore_pickup_address_country'] = $this->config->get('balticodedpdparcelstore_pickup_address_country');
		}
/* SHOW IF balticodedpdparcelstore_auto_send_data IS VALUE "1" end */
		if(isset($this->request->post['balticodedpdparcelstore_error_message'])){
			$this->data['balticodedpdparcelstore_error_message'] = $this->request->post['balticodedpdparcelstore_error_message'];
		} else {
			$this->data['balticodedpdparcelstore_error_message'] = $this->config->get('balticodedpdparcelstore_error_message');
		}
		if(isset($this->request->post['balticodedpdparcelstore_ship_to_specific_status'])){
			$this->data['balticodedpdparcelstore_ship_to_specific_status'] = $this->request->post['balticodedpdparcelstore_ship_to_specific_status'];
		} else {
			$this->data['balticodedpdparcelstore_ship_to_specific_status'] = $this->config->get('balticodedpdparcelstore_ship_to_specific_status');
		}

		$this->load->model('localisation/country');
		$this->data['balticodedpdparcelstore_ship_to_specific_list'] = $this->model_localisation_country->getCountries();

		if(isset($this->request->post['balticodedpdparcelstore_ship_to_specific_selected_list'])){
			$this->data['balticodedpdparcelstore_ship_to_specific_selected_list'] = $this->request->post['balticodedpdparcelstore_ship_to_specific_selected_list'];
		} else {
			$this->data['balticodedpdparcelstore_ship_to_specific_selected_list'] = $this->config->get('balticodedpdparcelstore_ship_to_specific_selected_list');
		}
		if(isset($this->request->post['balticodedpdparcelstore_pixels_city'])){
			$this->data['balticodedpdparcelstore_pixels_city'] = $this->request->post['balticodedpdparcelstore_pixels_city'];
		} else {
			$this->data['balticodedpdparcelstore_pixels_city'] = $this->config->get('balticodedpdparcelstore_pixels_city');
		}
		if(isset($this->request->post['balticodedpdparcelstore_pixels_office'])){
			$this->data['balticodedpdparcelstore_pixels_office'] = $this->request->post['balticodedpdparcelstore_pixels_office'];
		} else {
			$this->data['balticodedpdparcelstore_pixels_office'] = $this->config->get('balticodedpdparcelstore_pixels_office');
		}		if(isset($this->request->post['balticodedpdparcelstore_show_one_dropdown_status'])){
			$this->data['balticodedpdparcelstore_show_one_dropdown_status'] = $this->request->post['balticodedpdparcelstore_show_one_dropdown_status'];
		} else {
			$this->data['balticodedpdparcelstore_show_one_dropdown_status'] = $this->config->get('balticodedpdparcelstore_show_one_dropdown_status');
		}		if(isset($this->request->post['balticodedpdparcelstore_update_interval'])){
			$this->data['balticodedpdparcelstore_update_interval'] = $this->request->post['balticodedpdparcelstore_update_interval'];
		} else {
			$this->data['balticodedpdparcelstore_update_interval'] = $this->config->get('balticodedpdparcelstore_update_interval');
		}
		if(isset($this->request->post['balticodedpdparcelstore_population_list_of_list_status'])){
			$this->data['balticodedpdparcelstore_population_list_of_list_status'] = $this->request->post['balticodedpdparcelstore_population_list_of_list_status'];
		} else {
			$this->data['balticodedpdparcelstore_population_list_of_list_status'] = $this->config->get('balticodedpdparcelstore_population_list_of_list_status');
		}
		if (isset($this->request->post['balticodedpdparcelstore_allow_courier_pickup'])) {
			$this->data['balticodedpdparcelstore_allow_courier_pickup'] = $this->request->post['balticodedpdparcelstore_allow_courier_pickup'];
		} else {
			$this->data['balticodedpdparcelstore_allow_courier_pickup'] = $this->config->get('balticodedpdparcelstore_allow_courier_pickup');
		}
		if (isset($this->request->post['balticodedpdparcelstore_enablecod'])) {
			$this->data['balticodedpdparcelstore_enablecod'] = $this->request->post['balticodedpdparcelstore_enablecod'];
		} else {
			$this->data['balticodedpdparcelstore_enablecod'] = $this->config->get('balticodedpdparcelstore_enablecod');
		}
		
		$this->load->model('localisation/tax_class');
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		if (isset($this->request->post['balticodedpdparcelstore_status'])) {
			$this->data['balticodedpdparcelstore_status'] = $this->request->post['balticodedpdparcelstore_status'];
		} else {
			$this->data['balticodedpdparcelstore_status'] = $this->config->get('balticodedpdparcelstore_status');
		}
		
		if (isset($this->request->post['balticodedpdparcelstore_sort_order'])) {
			$this->data['balticodedpdparcelstore_sort_order'] = $this->request->post['balticodedpdparcelstore_sort_order'];
		} else {
			$this->data['balticodedpdparcelstore_sort_order'] = $this->config->get('balticodedpdparcelstore_sort_order');
		}	

		$this->template = 'shipping/balticodedpdparcelstore.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
		
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/balticodedpdparcelstore')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		if( $this->request->post['balticodedpdparcelstore_auto_send_data'] == "1" ){
			if ( empty($this->request->post['balticodedpdparcelstore_pickup_address_name'])  ) {
	            $this->error['balticodedpdparcelstore_pickup_address_name'] = $this->language->get('error_balticodedpdparcelstore_pickup_address_name');
	    	} 
	    	if ( empty($this->request->post['balticodedpdparcelstore_pickup_address_company'])  ) {
	            $this->error['balticodedpdparcelstore_pickup_address_company'] = $this->language->get('error_balticodedpdparcelstore_pickup_address_company');
	    	} 
	    	if ( empty($this->request->post['balticodedpdparcelstore_pickup_address_email'])  ) {
	            $this->error['balticodedpdparcelstore_pickup_address_email'] = $this->language->get('error_balticodedpdparcelstore_pickup_address_email');
	    	} 
	    	if ( empty($this->request->post['balticodedpdparcelstore_pickup_address_phone'])  ) {
	            $this->error['balticodedpdparcelstore_pickup_address_phone'] = $this->language->get('error_balticodedpdparcelstore_pickup_address_phone');
	    	} 
	    	if ( empty($this->request->post['balticodedpdparcelstore_pickup_address_street'])  ) {
	            $this->error['balticodedpdparcelstore_pickup_address_street'] = $this->language->get('error_balticodedpdparcelstore_pickup_address_street');
	    	} 
	    	if ( empty($this->request->post['balticodedpdparcelstore_pickup_address_city_county'])  ) {
	            $this->error['balticodedpdparcelstore_pickup_address_city_county'] = $this->language->get('error_balticodedpdparcelstore_pickup_address_city_county');
	    	} 
	    	if ( empty($this->request->post['balticodedpdparcelstore_pickup_adress_zip_code'])  ) {
	            $this->error['balticodedpdparcelstore_pickup_adress_zip_code'] = $this->language->get('error_balticodedpdparcelstore_pickup_adress_zip_code');
	    	} 
    	}
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>