<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

class ModelBalticodedpdlivehandlerBalticodedpdlivehandler extends Model {
    const PARCELSTORECODE = 'balticodedpdparcelstore';
    const COURIERCODE = 'balticodedpdcourier';
    
    private function install() {
	$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "dpd_barcodes` (
	  `dpd_barcode_id` int(11) NOT NULL AUTO_INCREMENT,
	  `order_id` int(11) NOT NULL,
	  `dpd_barcode` VARCHAR(50) NOT NULL,
	  PRIMARY KEY (`dpd_barcode_id`)
	)");
    }
    
    public function getOrderBarcode($orderId) {
	$this->install();
	$orderId = (int)$orderId;
	if ($orderId)
	{
	    $request = $this->db->query("SELECT dpd_barcode FROM `" . DB_PREFIX . "dpd_barcodes` WHERE order_id = ".$orderId." ORDER BY dpd_barcode_id DESC LIMIT 1");
	    if ($request->num_rows&&$request->rows[0])
	    {
		return $request->rows[0]['dpd_barcode'];
	    }
	}
	return false;
    }
	private function getOrderIdByBarcode($orderBarcode) {
	$this->install();
	//$orderId = (int)$orderId;
	if ($orderBarcode)
	{
	    $request = $this->db->query("SELECT order_id FROM `" . DB_PREFIX . "dpd_barcodes` WHERE dpd_barcode = ".$orderBarcode." ORDER BY dpd_barcode_id DESC LIMIT 1");
	    if ($request->num_rows&&$request->rows[0])
	    {
		return $request->rows[0]['order_id'];
	    }
	}
	return false;
    }
    
    private function setOrderBarcode($orderId, $barcode) {
	$this->install();
	$orderId = (int)$orderId;
	if ($orderId && $barcode)
	{
	    $this->db->query("INSERT INTO `" . DB_PREFIX . "dpd_barcodes` SET dpd_barcode = '".$barcode."', order_id = ".$orderId);
	}
    }
	
	public function callCourier(array $requestData) {
		$this->load->model('localisation/country');
		$shipCountry = $this->model_localisation_country->getCountry($this->config->get('balticodedpdparcelstore_pickup_address_country'));
        $returnDetails = array(
            'payerName' => $this->config->get('balticodedpdparcelstore_pickup_address_name'),
            'senderName' => $this->config->get('balticodedpdparcelstore_pickup_address_name'),
            'senderAddress' => $this->config->get('balticodedpdparcelstore_pickup_address_street'),
            'senderPostalCode' => $this->config->get('balticodedpdparcelstore_pickup_adress_zip_code'),
            'senderCountry' => ($shipCountry)?strtolower($shipCountry['iso_code_2']):'',
            'senderCity' => $this->config->get('balticodedpdparcelstore_pickup_address_city_county'),
            'senderContact' => $this->config->get('balticodedpdparcelstore_pickup_address_name'),
            'senderPhone' => $this->config->get('balticodedpdparcelstore_pickup_address_phone'),
            'action' => 'dpdis/pickupOrdersSave',
            
        );
        
        foreach ($returnDetails as $key => $returnDetail) {
            $requestData[$key] = $returnDetail;
        }

        
        $requestResult = $this->getRequest($requestData);
        return $requestResult;
    }
    
    
    private function autoSendData(array $requestData) {
		$this->load->model('localisation/country');
		$shipCountry = $this->model_localisation_country->getCountry($this->config->get('balticodedpdparcelstore_pickup_address_country'));
        $returnDetails = array(
            'op' => 'order',
            'Po_name' => $this->config->get('balticodedpdparcelstore_pickup_address_name'),
            'Po_company' => $this->config->get('balticodedpdparcelstore_pickup_address_company'),
            'Po_street' => $this->config->get('balticodedpdparcelstore_pickup_address_street'),
            'Po_postal' => $this->config->get('balticodedpdparcelstore_pickup_adress_zip_code'),
            'Po_country' => ($shipCountry)?strtolower($shipCountry['iso_code_2']):'',
            'Po_city' => $this->config->get('balticodedpdparcelstore_pickup_address_city_county'),
            'Po_contact' => $this->config->get('balticodedpdparcelstore_pickup_address_name'),
            'Po_phone' => $this->config->get('balticodedpdparcelstore_pickup_address_phone'),
            //po-remark
            'Po_email' => $this->config->get('balticodedpdparcelstore_pickup_address_email'),
            'Po_show_on_label' => 'true',//m111$this->config->get('po_show_on_label')?'true':'false',
            'Po_save_address' => 'false',//m111$this->config->get('po_save_address')?'true':'false',
//            'Po_type' => $this->config->get('senddata_service'),
            'LabelsPosition' => null,//m111$this->config->get('label_position'),
            'action' => 'parcel_import',
            
	    
	    
	    
	    /*
	    
	    
	    
	    'name1' => "ST070 Eripo",
            'street' => 'Seskines g.  22',
            'pcode' => '07156',
            'country' => 'LT',
            'city' => 'Vilnius',
            'weight' => 2,
            'phone' => 3,
            'remark' => 4,
            'parcelshop_id' => '409020',
            'num_of_parcel' => 5,
            'order_number' => '222222222222',
            'idm' => 'Y',
            'phone' => '+370/60984640',
            'idm_sms_number' => '+370/60984640',
            'idm_sms_rule' => '902',
            'parcel_type' => 'PS'*/
        );
        
        foreach ($returnDetails as $key => $returnDetail) {
            $requestData[$key] = $returnDetail;
        }
        //if (!isset($requestData['Po_type'])) {
        //    $requestData['Po_type'] = $this->getConfigData('senddata_service');
        //}
        $requestResult = $this->getRequest($requestData);
        return $requestResult;
    }
    
    public function orderSendData(array $orderList) {
	$requestResult = array ();
	$this->load->model('sale/order');
	$this->load->model('catalog/product');
	$this->load->model('balticodedpdlivehandler/dialcodehelper');
	
	$errorText = '';
	
	foreach ($orderList as $orderItem)
	{
	    if (!$this->getOrderBarcode($orderItem))
	    {
		$requestData = array ();
		
		$orderObj = $this->model_sale_order->getOrder($orderItem);
		
		
		
		$products=$this->model_sale_order->getOrderProducts($orderItem);
		$weight = 0;
		$quantity = 0;
		foreach ($products as $product) {
			$product_data = $this->model_catalog_product->getProduct($product['product_id']);
			$weight += $product_data['weight'];
			$quantity += $product['quantity'];
		}
		//print_r($orderObj);
		$returnDetails = array();
		if (strpos($orderObj['shipping_code'], self::PARCELSTORECODE) !== FALSE)
		{
		    $parcelshopinfo = $this->getParcelshop($orderObj['shipping_code']);
		    if ($parcelshopinfo)
		    {
			$returnDetails = array(
			    'name1' => $parcelshopinfo['company'],
			    'street' => $parcelshopinfo['street'],
			    'pcode' => $parcelshopinfo['pcode'],
			    'country' => $parcelshopinfo['country'],
			    'city' => $parcelshopinfo['city'],
			    'weight' => $weight,
			    'phone' => $parcelshopinfo['phone'],
			    'remark' => $orderObj['comment'],
			    'parcelshop_id' => $parcelshopinfo['parcelshop_id'],
			    'num_of_parcel' => $quantity,
			    'order_number' => str_pad($orderItem, 10, '0', STR_PAD_LEFT),
			    'idm' => 'Y',
			    'phone' => $orderObj['telephone'],
			    'idm_sms_number' => $orderObj['telephone'],
			    'idm_sms_rule' => '902',
			    'parcel_type' => 'PS'
			);
			
			$phoneNumbers = $this->model_balticodedpdlivehandler_dialcodehelper->separatePhoneNumberFromCountryCode($orderObj['telephone'], $orderObj['shipping_iso_code_2']);
			$returnDetails['Sh_notify_phone_code'] = $phoneNumbers['dial_code'];
			$returnDetails['Sh_notify_contact_phone'] = $phoneNumbers['phone_number'];
		    }
		    else
		    {
			echo "parcelshop not found: ".$orderObj['shipping_method'];
			$errorText .= 'Bad order with id: '.$orderItem.', ERROR: parcelshop not found: '.$orderObj['shipping_method'].'; ';
		    }
		}
		else if (strpos($orderObj['shipping_code'], self::COURIERCODE) !== FALSE)
		{
		    $returnDetails = array(
			'name1' => $orderObj['shipping_firstname'].' '.$orderObj['shipping_lastname'],
			'company' => $orderObj['shipping_company'],
			'street' => implode(' ', array($orderObj['shipping_address_1'], $orderObj['shipping_address_2'])),
			'pcode' => $orderObj['shipping_postcode'],
			'country' => strtoupper($orderObj['shipping_iso_code_2']),
			'city' => $orderObj['shipping_city'],
			'Sh_contact' => $orderObj['shipping_firstname'].' '.$orderObj['shipping_lastname'],
			'phone' => $orderObj['telephone'],
			'remark' => $orderObj['comment'],
			'num_of_parcel' => $quantity,
			'order_number' => str_pad($orderItem, 10, '0', STR_PAD_LEFT),
			'parcel_type' => $orderObj['payment_code'] == 'cod' ? 'D-COD-B2C' : 'D-B2C'
		    );
		    
		    if ($orderObj['payment_code'] == 'cod') {
			$returnDetails['cod_amount'] = $orderObj['total'];
		    }
		}
		else {
			$errorText .= 'Bad order with id: '.$orderItem.', ERROR: not DPD shipping method; ';
		}
		if ($returnDetails)
		{
		
			
			if ($orderObj['shipping_zone']) {
				$returnDetails['city'] = $orderObj['shipping_city'] . ', ' . $orderObj['shipping_zone'];
			}
			
			
			//print_r($returnDetails);
			foreach ($returnDetails as $key => $returnDetail) {
				$requestData[$key] = $returnDetail;
			}
			$requestResponse = $this->autoSendData($requestData);
			if ($requestResponse&&isset($requestResponse['status'])&&$requestResponse['status']=="ok")
			{
				$dpdBarcodeList = $requestResponse['pl_number'];
				if ($dpdBarcodeList)
				{
				$dpdBarcode = end($dpdBarcodeList);
				if ($dpdBarcode)
				{
					$requestResult[$orderItem] = $dpdBarcode;
					$this->setOrderBarcode($orderItem, $dpdBarcode);
					$this->model_sale_order->addOrderHistory($orderItem, array('order_status_id' => $orderObj['order_status_id'], 'comment' => 'DPD Barcode: '.$dpdBarcode, 'notify' => 0, 'no_send' => 1));
				}
				}
			}
			else if ($requestResponse&&isset($requestResponse['status'])&&$requestResponse['status']=="err")
			{
				//echo "error: "; print_r($requestResponse['errlog']);
				$this->model_sale_order->addOrderHistory($orderItem, array('order_status_id' => $orderObj['order_status_id'], 'comment' => 'ERROR: '.print_r($requestResponse, true), 'notify' => 0, 'no_send' => 1));
				if ($requestResponse['errlog'])
				{
					$errorText .= 'Bad order with id: '.$orderItem.', ERROR: '.$requestResponse['errlog'].'; ';
				}
				//return $requestResponse;
			}
		}
	    }
	}
	if ($errorText!='')
	{
	    return array('status' => 'err', 'errlog' => $errorText);
	}
	return $requestResult;
    }
    
    function getParcelshop($parcelshop_id)
    {
	$responseObj = $this->getRequest();
	if ($responseObj)
	{
		$response = $responseObj['parcelshops'];
		$result = array();
		foreach ($response as $r) {
			if ($r['parcelshop_id'] > 0 && (strpos($parcelshop_id, $r['parcelshop_id']) !== FALSE)) {
			    return $r;
			}
		}
	}
	return false;
    }
    
    
    /*    public function getRequestForAutoSendData($order, $address, $selectedOfficeId) {
        $telephone = $address->phone_mobile;
        if (!$telephone) {
            $telephone = $address->phone;
        }
        
        $requestData = array(
            'name1' => $address->firstname.' '.$address->lastname,
            'company' => $address->company,
            'street' => implode(' ', array($address->address1, $address->address2)),
            'pcode' => $address->postcode,
            'country' => strtoupper(Country::getIsoById($address->id_country)),
            'city' => $address->city,
            'Sh_contact' => $address->firstname.' '.$address->lastname,
            'phone' => $telephone,
            'remark' => $this->_getRemark($order),
            'num_of_parcel' => $this->_getNumberOfPackagesForOrder($order),
            'order_number' => $order->id,
            'parcel_type' => $order->payment == 'Cash on delivery (COD)' ? 'D-COD-B2C' : 'D-B2C'
        );
        if ($order->payment == 'Cash on delivery (COD)') {
            $requestData['cod_amount'] = $order->total_paid;
        }
        if ($address->id_state) {
            $requestData['city'] = $address->city . ', ' . State::getNameById($address->id_state);
        }
        
        
        return $requestData;
        
    } */
    
    
    
    
    public function getPDF(array $orderList) {
		$dpd_send_data = $this->orderSendData($orderList);
		if ($dpd_send_data&&isset($dpd_send_data['status'])&&$dpd_send_data['status']=="err")
		{
			return $dpd_send_data;
		}
        /*if($requestData['manifest']){
            $data=$this->datasend();
            if (!is_array($data) || !isset($data['errlog']) || $data['errlog'] !== '') {
                echo "Can't send data to server";
                die();
            }else{
                return true;
            }
        }else{
            $returnDetails = array(
                'action' => 'parcel_print',
                'parcels' => implode("|",$requestData),
                
            );
        }
        //return $requestData;*/
	//print_r($orderList);
	$requestData = array();
	foreach ($orderList as $orderItem)
	{
	    $orderBarcode = $this->getOrderBarcode($orderItem);
	    if ($orderBarcode)
	    {
		$requestData[] = $orderBarcode;
	    }
	}
	if (!$requestData)
	{
	    return '';
	}
	
	
	$returnDetails = array(
                'action' => 'parcel_print',
                'parcels' => implode("|",$requestData),
                
            );
        
        $requestResult = $this->getRequest($returnDetails);
		$requestResultArray = @json_decode($requestResult, true);
		if ($requestResultArray&&$requestResultArray['status']=="err")
		{
			/*foreach ($requestResultArray[''])
			{
				$this->getOrderIdByBarcode();
			}*/
			return $requestResultArray;
		}
        return $this->getLabelsOutput($requestResult);
    }
    

    private function getLabelsOutput($pdf) {
      $today = date('Y-m-d');
        $name = 'dpdLabels' . '-'.$today. '.pdf';
        if (ob_get_contents()) {
            print_r('Some data has already been output, can\'t send PDF file');
            die();
        }
        header('Content-Description: File Transfer');
        if (headers_sent()) {
            print_r('Some data has already been output to browser, can\'t send PDF file');
            die();
        }
        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        header( "refresh:1;url=".(isset($_SERVER['HTTP_REFERER']))?$_SERVER['HTTP_REFERER']:''."" ); 
        header('Content-Type: application/force-download');
        header('Content-Type: application/octet-stream', false);
        header('Content-Type: application/download', false);
        header('Content-Type: application/pdf', false);
        header('Content-Disposition: attachment; filename="'.$name.'";');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.strlen($pdf));
        echo $pdf;
        
        return '';
    }

    
    function getRequest($params = array('action' => 'parcelshop_info'), $url = null) {
	//print_r($params);
        if (!$url) {
            $url = $this->config->get("balticodedpdlivehandler_api_url");
        }
        $url .= $params['action'].'.php';
        $auth = '';
        if (strpos($url, 'dpd.surflink.ee') > 0) {
            $auth = "Authorization: Basic " . base64_encode("demo:demo") . "\r\n";
        }
        
        $params['username'] = $this->config->get("balticodedpdlivehandler_weblabel_user_name");
        $params['password'] = $this->config->get("balticodedpdlivehandler_weblabel_user_password");
        $logRequest = array(
            'url' => $url,
            'request' => $params,
            'response' => '',
            );



        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => $auth . "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($params),
                'timeout' => $this->config->get("balticodedpdlivehandler_http_request_timeout") > 10 ? $this->config->get("balticodedpdlivehandler_http_request_timeout") : 10,
        ));
        
        
        $context = stream_context_create($options);
        $postRequestResult = null;
        
        $dpdparcelshopstxt = DIR_DOWNLOAD."/dpdparcelshops.txt";
	
	$currenttime = time();
	
        set_error_handler(
            create_function(
                '$severity, $message, $file, $line',
                'throw new ErrorException($message, $severity, $severity, $file, $line);'
            )
        );
        try {
	    
	    if($params['action']=='parcelshop_info'&&file_exists($dpdparcelshopstxt) && (($currenttime - filemtime($dpdparcelshopstxt)) < $this->config->get("balticodedpdparcelstore_update_interval")*60))
	    {
	    }
	    else
	    {
		$postRequestResult = file_get_contents($url, false, $context);
	    }
        }
        catch (Exception $e) {
            //echo $e->getMessage();
        }
        
        restore_error_handler();
        
        if ($params['action']=='parcelshop_info')
	{
	    if ($postRequestResult) {
		file_put_contents($dpdparcelshopstxt, $postRequestResult);
	    }
	    else if(file_exists($dpdparcelshopstxt))
	    {
		$postRequestResult = file_get_contents($dpdparcelshopstxt);
	    }
	    else
	    {
		return "";
	    }
	}
        
        
        if($params['action']=='parcel_print' || $params['action'] == 'parcel_manifest_print'){
            return $postRequestResult;
        }
        $body = @json_decode($postRequestResult, true);
        if ($params['action'] == 'dpdis/pickupOrdersSave') {
            if(strcmp(substr($postRequestResult, 3, 4), "DONE") == 0){
                return "DONE";
            }  
            else {
                return $postRequestResult;
            }
        }
        if (!is_array($body) || !isset($body['errlog']) || $body['errlog'] !== '') {
            //$translatedText = sprintf($this->l('DPD request failed with response: %s'), print_r($postRequestResult, true));
            $logRequest['response'] = $body;
            //$this->_addLogRequest($logRequest);

            //throw new Exception($translatedText);
        }
        $logRequest['response'] = $body;
        //$this->_addLogRequest($logRequest);
        return $logRequest['response'];
    }
}



/*


if (file_exists('../../config.php')) {
	require_once('../../config.php');
}
require_once(DIR_SYSTEM . 'startup.php');

define( 'DS', DIRECTORY_SEPARATOR );
define('POST_OFFICE_TABLE','dpd_parcelshops');
$rootFolder = explode(DS,dirname(__FILE__));
//current level in diretoty structure
$currentfolderlevel = 3;
array_splice($rootFolder,-$currentfolderlevel);

$base_folder = implode(DS,$rootFolder);


if(is_dir($base_folder.DS.'libraries'.DS.'joomla'))   
{
   
   define( '_JEXEC', 1 );
   
   define('JPATH_BASE',implode(DS,$rootFolder));
   
   require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
   require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
}
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$check_if_table = $db->query("SHOW TABLES LIKE '" . DB_PREFIX . POST_OFFICE_TABLE . "'");
if ($check_if_table->num_rows < 1)
{
   $db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . POST_OFFICE_TABLE . " (`parcelshop_id` int(11) NOT NULL AUTO_INCREMENT, `company` varchar(255) NOT NULL, `city` varchar(255) NOT NULL, `pcode` varchar(10) NOT NULL,`street` varchar(255) NOT NULL, `country` varchar(10) NOT NULL, `email` varchar(255) NOT NULL, `phone` varchar(20), `parcelshop_status` varchar(255) NOT NULL, `parcelshop_updated_on` datetime NOT NULL, PRIMARY KEY (`parcelshop_id`));");
}

if(isset($_GET['action']))
{
    switch ($_GET['action'])
    {
        case 'parcelshop_info':
            {
                $url = 'https://weblabel.dpd.lt/parcel_interface/parcelshop_info.php';
                $data = array('username' => 'balticodetest', 'password' => 'balticodetest');
                
                // use key 'http' even if you send the request to https://...
                $options = array(
                    'http' => array(
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data),
                        'timeout' => 60,
                    ),
                );
                $context  = stream_context_create($options);
                $result = file_get_contents($url, false, $context);
                
                $body = @json_decode($result, true);
                echo "<pre>";print_r($body); echo "</pre>";
            } break;
        default:
            {
                
            }break;
    }
}
*/

?>