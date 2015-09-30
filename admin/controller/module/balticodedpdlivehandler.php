<?php
require_once(DIR_SYSTEM . 'library/cart.php');
require_once(DIR_SYSTEM . 'library/currency.php');
require_once(DIR_SYSTEM . 'library/weight.php');

class ControllerModulebalticodedpdlivehandler extends Controller {
	private $error = array(); 
	const SHIPPING_METHOD_CODE_PARCEL_STORE = 'balticodedpdparcelstore';
	const SHIPPING_METHOD_CODE_COURIER = 'balticodedpdcourier';
/**
 * isset_value function test are isset value
 * If can't find input field value has $default value
 	input $variable is reference of the object
 	$default value is used when variable is not set
 */
	public function isset_value(&$variable, $default = null ){
		if(isset($variable))
			return $variable;
		else
			return $default;
	}
	
	private function pdf($html, $name, $encode = "UTF-8", $size = "A4", $orientation = "portrait") {
		 //    if (count($name) > 1) {
		// 	$name = "Orders";
		// } else {
		// 	$name = 'Order_'.$name[0]['order_id'];
		// }

		$dompdf = new DOMPDF();
		$dompdf->load_html($html,$encode);
		$dompdf->set_paper($size, 'portrait');
		$dompdf->render();



/*
        $font = Font_Metrics::get_font('helvetica', 'normal');
        $size = 9;
        $y = $dompdf->get_height() - 24;
        $x = $dompdf->get_width() - 15 - Font_Metrics::get_text_width('1/1', $font, $size);
        $dompdf->page_text($x, $y, '{PAGE_NUM}/{PAGE_COUNT}', $font, $size);


*/



		$dompdf->stream($name.".pdf");
	}

	public function courier (){
		$this->load->language('module/balticodedpdlivehandler');
		$this->load->model('balticodedpdlivehandler/balticodedpdlivehandler');
		$params = array();
		$params['action'] = 'parcel_datasend';
		$this->model_balticodedpdlivehandler_balticodedpdlivehandler->getRequest($params);

		$orderSendResult = false;

        $orderSendData = array(
            'nonStandard' => isset($_POST['Po_remark']) ? $_POST['Po_remark'] : '',
            'parcelsCount' => $_POST['Po_parcel_qty'],
            'palletsCount' => $_POST['Po_pallet_qty'],
           
        );

		$orderSendResult=$this->model_balticodedpdlivehandler_balticodedpdlivehandler->callCourier($orderSendData);
		if($orderSendResult == 'DONE'){
			$this->session->data['success'] = $this->language->get('text_data_send_success'); //If all OK
		} else {
			echo $this->language->get('text_data_send_faild').$orderSendResult; //if some problems echo heare
		}
	}


	public function sendShipingDataToServer (){
		if (!isset($_POST['selected'])) {
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->load->model('balticodedpdlivehandler/balticodedpdlivehandler');

		$log = $this->model_balticodedpdlivehandler_balticodedpdlivehandler->orderSendData($_POST['selected']);
		if ($log&&isset($log['status'])&&$log['status'] == 'err'){
			$warning = $this->language->get('text_print_labels_feiled');
			// foreach ($log['errarg'] as $value) {
			
			$warning = $log['errlog'];
			
			// }
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'].'&warning='.$warning, 'SSL'));
		} else {
			$this->session->data['success'] = 'Send is success';
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'));

		}
	}

	public function manifest(){
		if (!isset($_POST['selected'])) {
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->load->model('setting/setting');
		$this->load->language('sale/order_dpd_labels');
		//grab values from POST or GET
		if(isset($_POST['selected']))
			$orders = $this->request->post['selected'];

		/* Increment Manifest */
			$balticodedpdlivehandler_settings = $this->model_setting_setting->getSetting('balticodedpdlivehandler'); //Load balticodedpdlivehandler_settings
			if(array_key_exists('balticodedpdlivehandler_manifest_nr', $balticodedpdlivehandler_settings)) { //Testing are Manifest has been printed?
				$balticodedpdlivehandler_settings['balticodedpdlivehandler_manifest_nr'] += 1; //Manifest nr increment
			} else {
				$balticodedpdlivehandler_settings['balticodedpdlivehandler_manifest_nr'] = 1; //manifest number count by 1
			}
			$balticodedpdlivehandler_settings['balticodedpdlivehandler_manifest_nr'] = 1; //Reset Manifest count!!!
			$this->model_setting_setting->editSetting('balticodedpdlivehandler', $balticodedpdlivehandler_settings); //Set value
		$this->load->model('balticodedpdlivehandler/balticodedpdlivehandler');
		$orders=array();
		$this->data['value_packages_count']=0;
		$this->load->model('sale/order');
		$this->load->model('catalog/product');
		$bad_orders='';
		$value_orders_weight=0;
		foreach ($this->request->post['selected'] as $orderid) {
			$orders[$orderid] = $this->model_sale_order->getOrder($orderid); //Load get Order info
			$orders[$orderid]['tracking_number'] = $this->model_balticodedpdlivehandler_balticodedpdlivehandler->getOrderBarcode($orderid);
			$products=$this->model_sale_order->getOrderProducts($orderid); //Load products of this order
			$weight=0;
			foreach ($products as $product) {
				$product_data=$this->model_catalog_product->getProduct($product['product_id']);
				$weight+=$this->weight->convert($product_data['weight']*$product['quantity'], $product_data['weight_class_id'], $this->config->get('config_weight_class_id'));
				$this->data['value_packages_count'] += $product['quantity'];
			}
			$orders[$orderid]['total_weight'] = $this->weight->format($weight,$this->config->get('config_weight_class_id'));
			$orders[$orderid]['product_package'] = 'product_package';
			$value_orders_weight+=$weight;
			if ( !(!(false===strpos($orders[$orderid]['shipping_code'], self::SHIPPING_METHOD_CODE_PARCEL_STORE)) || !(false===strpos($orders[$orderid]['shipping_code'], self::SHIPPING_METHOD_CODE_COURIER))) ){ $bad_orders.=$orderid.', ';}
			if (!(false===strpos($orders[$orderid]['shipping_code'], self::SHIPPING_METHOD_CODE_PARCEL_STORE))) {
				$orders[$orderid]['parcel_type'] = $this->language->get('value_parcel_shop');
				$parcelshopinfo = $this->model_balticodedpdlivehandler_balticodedpdlivehandler->getParcelshop($orders[$orderid]['shipping_code']);
			    $orders[$orderid]['shipping_address_1'] = $parcelshopinfo['company'].'<br>'.$parcelshopinfo['street'];
			    $orders[$orderid]['shipping_postcode'] = $parcelshopinfo['pcode'];
			    $orders[$orderid]['shipping_zone'] = $parcelshopinfo['city']; 
			} else {
				if ($orders[$orderid]['payment_code'] == 'cod') //This is Cash on delivery?
					$orders[$orderid]['parcel_type'] = $this->language->get('value_parcel_normal').'<br />'.$this->language->get('label_cash_on_delivery_short').', '.$this->language->get('label_delivery_to_private_person_short').'<br><strong>'.$this->currency->format($orders[$orderid]['total'],$orders[$orderid]['currency_code'],$orders[$orderid]['currency_value']).'</strong>';  
				else
					$orders[$orderid]['parcel_type'] = $this->language->get('value_parcel_normal').'<br />'.$this->language->get('label_delivery_to_private_person_short');
			}
		}

		if ( $bad_orders!=='' ){
			$this->load->language('module/balticodedpdlivehandler');
			$warning = $this->language->get('text_bad_order_with_id').': '.$bad_orders.$this->language->get('text_error').': '.$this->language->get('text_not_dpd_shipping_method');
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'].'&warning='.$warning, 'SSL'));
		}
		$this->data['value_orders_weight'] = $this->weight->format($value_orders_weight,$this->config->get('config_weight_class_id'));
		$this->data['orders']=$orders;
		// Load template ans set some vars for PDF generation
		$_today = date('Y-m-d H:i:s');
		$filename = 'DPD_manifest' . '-'.$_today;

		$encode = 'UTF-8';
		$size = 'A4';
		$orientation = "portrait";
		$template = 'sale/order_dpd_labels.tpl';
		$this->template = $template;
		
		// Load and set styles ant scripts
		$this->document->addStyle('view/stylesheet/order_dpd_labels.css','stylesheet','screen');
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = array();

		//Load and set some text's
		
		$this->data['title'] = $this->language->get('title');
		$this->data['label_company'] = $this->language->get('label_company');
		$this->data['label_phone'] = $this->language->get('label_phone');
		$this->data['label_vat'] = $this->language->get('label_vat');
		$this->data['label_fax'] = $this->language->get('label_fax');
		$this->data['label_vat_code'] = $this->language->get('label_vat_code');
		$this->data['label_manifest_nr'] = $this->language->get('label_manifest_nr');
		$this->data['label_vat_code'] = $this->language->get('label_vat_code');
		$this->data['label_sphone'] = $this->language->get('label_sphone');
		$this->data['label_client'] = $this->language->get('label_client');
		$this->data['label_done_date'] = $this->language->get('label_done_date');
		$this->data['label_order_nr'] = $this->language->get('label_order_nr');
		$this->data['label_order_type'] = $this->language->get('label_order_type');
		$this->data['label_order_arrival'] = $this->language->get('label_order_arrival');
		$this->data['label_order_phone'] = $this->language->get('label_order_phone');
		$this->data['label_order_weight'] = $this->language->get('label_order_weight');
		$this->data['label_order_number'] = $this->language->get('label_order_number');
		$this->data['label_order_issn'] = $this->language->get('label_order_issn');
		$this->data['label_total'] = $this->language->get('label_total');
		$this->data['label_orders_count'] = $this->language->get('label_orders_count');
		$this->data['label_packages_count'] = $this->language->get('label_packages_count');
		$this->data['label_additional'] = $this->language->get('label_additional');
		$this->data['label_load'] = $this->language->get('label_load');
		$this->data['label_wait'] = $this->language->get('label_wait');
		$this->data['label_smin'] = $this->language->get('label_smin');
		$this->data['label_sender'] = $this->language->get('label_sender');
		$this->data['label_courier'] = $this->language->get('label_courier');
		$this->data['label_arrived'] = $this->language->get('label_arrived');
		$this->data['label_departure'] = $this->language->get('label_departure');
		$this->data['label_sender_signature'] = $this->language->get('label_sender_signature');
		$this->data['label_name_signature'] = $this->language->get('label_name_signature');
		$this->data['label_name_tour_signature'] = $this->language->get('label_name_tour_signature');
		$this->data['label_date_time'] = $this->language->get('label_date_time');
		$this->data['label_time'] = $this->language->get('label_time');

		$this->data['value_phone'] = $this->language->get('value_phone');
		$this->data['value_vat_code'] = $this->language->get('value_vat_code');
		$this->data['value_street'] = $this->language->get('value_street');
		$this->data['value_fax'] = $this->language->get('value_fax');
		$this->data['value_manifest_nr'] = sprintf("%08s", $balticodedpdlivehandler_settings['balticodedpdlivehandler_manifest_nr'] ); //NOT LOAD FROM CONFIG->GET !!!
		$this->data['value_client'] = $this->language->get('value_client');
		$this->data['value_done_date'] = date("Y m d");
		$this->data['value_client_id'] = $this->config->get('balticodedpdlivehandler_weblabel_user_id');
		$this->data['value_client_street'] = $this->language->get('value_client_street');
		$this->data['value_client_vat_code'] = $this->language->get('value_client_vat_code');
		$this->data['value_client_phone'] = $this->language->get('value_client_phone');
		$this->data['value_client_city'] = $this->language->get('value_client_city');
		$this->data['value_client_post'] = $this->language->get('value_client_post');
		$this->data['value_logo'] = '<img src="view/image/balticode_dpd_parcelstore.png" alt="ParcelStore" title="DPD ParcelStore"/>';

		$this->data['text_notification_title'] = $this->language->get('text_notification_title');
		$this->data['text_notification']['1'] = $this->language->get('text_notification_1');
		$this->data['text_notification']['2'] = $this->language->get('text_notification_2');
		$this->data['text_conditions']['1'] = $this->language->get('text_conditions_1');		
		$this->data['text_conditions']['2'] = $this->language->get('text_conditions_2');		
		$this->data['text_conditions']['3'] = $this->language->get('text_conditions_3');

		$html=$this->render();
		// print_r($html);
		// die();
		$this->pdf($html, $filename, $encode, $size, $orientation);
	}
	
	public function labels(){
		$this->load->language('sale/order_dpd_labels');
		if (!isset($_POST['selected'])) {
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->load->model('balticodedpdlivehandler/balticodedpdlivehandler');
		$barcodes = $_POST['selected'];
		$log = $this->model_balticodedpdlivehandler_balticodedpdlivehandler->getPDF($barcodes);
		if ($log&&isset($log['status'])&&$log['status'] == 'err'){
			$warning = $this->language->get('text_print_labels_feiled');
			// foreach ($log['errarg'] as $value) {
			
			$warning = $log['errlog'];
			
			// }
			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'].'&warning='.$warning, 'SSL'));
		}
	}

	public function index() {   
		$this->load->language('module/balticodedpdlivehandler');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('balticodedpdlivehandler', $this->request->post);		
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['text_global_settings_label'] = $this->language->get('text_global_settings_label');
		$this->data['text_global_settings_label_enabled'] = $this->language->get('text_global_settings_label_enabled');

		$this->data['text_admin_order_settings_label'] = $this->language->get('text_admin_order_settings_label');
		$this->data['text_admin_order_settings_label_enabled'] = $this->language->get('text_admin_order_settings_label_enabled');
		$this->data['text_admin_order_settings_label_open_order_new_window'] = $this->language->get('text_admin_order_settings_label_open_order_new_window');
		$this->data['text_admin_order_settings_label_postoffice_send_status'] = $this->language->get('text_admin_order_settings_label_postoffice_send_status');
		$this->data['text_admin_order_settings_label_postoffice_print_status'] = $this->language->get('text_admin_order_settings_label_postoffice_print_status');
		$this->data['text_admin_order_settings_label_dpdweblabel_login_username'] = $this->language->get('text_admin_order_settings_label_dpdweblabel_login_username');
		$this->data['text_admin_order_settings_label_dpdweblabel_login_userpassword'] = $this->language->get('text_admin_order_settings_label_dpdweblabel_login_userpassword');
		$this->data['text_admin_order_settings_label_dpdweblabel_login_userid'] = $this->language->get('text_admin_order_settings_label_dpdweblabel_login_userid');
		$this->data['text_admin_order_settings_label_api_url'] = $this->language->get('text_admin_order_settings_label_api_url');
		$this->data['text_admin_order_settings_label_http_request_timeout'] = $this->language->get('text_admin_order_settings_label_http_request_timeout');

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['balticodedpdlivehandler_module'] = $this->config->get('balticodedpdlivehandler_module'); //get all module variables

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		if ( $this->error ) {
			$this->data['error'] = $this->error;
		} else {
			$this->data['error'] = array();
		}
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/balticodedpdlivehandler', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/balticodedpdlivehandler', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if(isset($this->request->post['balticodedpdlivehandler_status'])){
			$this->data['balticodedpdlivehandler_status'] = $this->request->post['balticodedpdlivehandler_status'];
		} else {
			$this->data['balticodedpdlivehandler_status'] = $this->config->get('balticodedpdlivehandler_status');
		}
		if(isset($this->request->post['balticodedpdlivehandler_admin_order_enable'])){
			$this->data['balticodedpdlivehandler_admin_order_enable'] = $this->request->post['balticodedpdlivehandler_admin_order_enable'];
		} else {
			$this->data['balticodedpdlivehandler_admin_order_enable'] = $this->config->get('balticodedpdlivehandler_admin_order_enable');
		}
		if(isset($this->request->post['balticodedpdlivehandler_admin_order_new_windows'])){
			$this->data['balticodedpdlivehandler_admin_order_new_windows'] = $this->request->post['balticodedpdlivehandler_admin_order_new_windows'];
		} else {
			$this->data['balticodedpdlivehandler_admin_order_new_windows'] = $this->config->get('balticodedpdlivehandler_admin_order_new_windows');
		}
		if(isset($this->request->post['balticodedpdlivehandler_admin_order_postoffice_send_status'])){
			$this->data['balticodedpdlivehandler_admin_order_postoffice_send_status'] = $this->request->post['balticodedpdlivehandler_admin_order_postoffice_send_status'];
		} else {
			$this->data['balticodedpdlivehandler_admin_order_postoffice_send_status'] = $this->config->get('balticodedpdlivehandler_admin_order_postoffice_send_status');
		}
		if(isset($this->request->post['balticodedpdlivehandler_admin_order_postoffice_print_status'])){
			$this->data['balticodedpdlivehandler_admin_order_postoffice_print_status'] = $this->request->post['balticodedpdlivehandler_admin_order_postoffice_print_status'];
		} else {
			$this->data['balticodedpdlivehandler_admin_order_postoffice_print_status'] = $this->config->get('balticodedpdlivehandler_admin_order_postoffice_print_status');
		}
		if(isset($this->request->post['balticodedpdlivehandler_weblabel_user_name'])){
			$this->data['balticodedpdlivehandler_weblabel_user_name'] = $this->request->post['balticodedpdlivehandler_weblabel_user_name'];
		} else {
			$this->data['balticodedpdlivehandler_weblabel_user_name'] = $this->config->get('balticodedpdlivehandler_weblabel_user_name');
		}
		if(isset($this->request->post['balticodedpdlivehandler_weblabel_user_password'])){
			$this->data['balticodedpdlivehandler_weblabel_user_password'] = $this->request->post['balticodedpdlivehandler_weblabel_user_password'];
		} else {
			$this->data['balticodedpdlivehandler_weblabel_user_password'] = $this->config->get('balticodedpdlivehandler_weblabel_user_password');
		}
		if(isset($this->request->post['balticodedpdlivehandler_weblabel_user_id'])){
			$this->data['balticodedpdlivehandler_weblabel_user_id'] = $this->request->post['balticodedpdlivehandler_weblabel_user_id'];
		} else {
			$this->data['balticodedpdlivehandler_weblabel_user_id'] = $this->config->get('balticodedpdlivehandler_weblabel_user_id');
		}
		if(isset($this->request->post['balticodedpdlivehandler_api_url'])){
			$this->data['balticodedpdlivehandler_api_url'] = $this->request->post['balticodedpdlivehandler_api_url'];
		} else {
			$this->data['balticodedpdlivehandler_api_url'] = $this->config->get('balticodedpdlivehandler_api_url');
		}
		if(isset($this->request->post['balticodedpdlivehandler_http_request_timeout'])){
			$this->data['balticodedpdlivehandler_http_request_timeout'] = $this->request->post['balticodedpdlivehandler_http_request_timeout'];
		} else {
			$this->data['balticodedpdlivehandler_http_request_timeout'] = $this->config->get('balticodedpdlivehandler_http_request_timeout');
		}			
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		
		$this->template = 'module/balticodedpdlivehandler.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/balticodedpdlivehandler')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		

    	if ( empty($this->request->post['balticodedpdlivehandler_weblabel_user_name'])  ) {
            $this->error['balticodedpdlivehandler_weblabel_user_name'] = $this->language->get('error_balticodedpdlivehandler_weblabel_user_name');
    	} 
    	if ( empty($this->request->post['balticodedpdlivehandler_weblabel_user_password'])  ) {
            $this->error['balticodedpdlivehandler_weblabel_user_password'] = $this->language->get('error_balticodedpdlivehandler_weblabel_user_password');
    	} 
    	if ( empty($this->request->post['balticodedpdlivehandler_weblabel_user_id'])  ) {
            $this->error['balticodedpdlivehandler_weblabel_user_id'] = $this->language->get('error_balticodedpdlivehandler_weblabel_user_id');
    	} 
    	if ( empty($this->request->post['balticodedpdlivehandler_api_url'])  ) {
            $this->error['balticodedpdlivehandler_api_url'] = $this->language->get('error_balticodedpdlivehandler_api_url');
    	} 
    	if ( empty($this->request->post['balticodedpdlivehandler_http_request_timeout'])  ) {
            $this->error['balticodedpdlivehandler_http_request_timeout'] = $this->language->get('error_balticodedpdlivehandler_http_request_timeout');
    	} 
    	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>