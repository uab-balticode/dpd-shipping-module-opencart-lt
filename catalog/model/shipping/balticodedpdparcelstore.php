<?php
/*
* @package		MijoShop
* @copyright	2009-2013 Mijosoft LLC, mijosoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
//defined('_JEXEC') or die('Restricted access');
 
class ModelShippingbalticodedpdparcelstore extends Model {    
  	public function getQuote($address) {
		$this->language->load('shipping/balticodedpdparcelstore');
		
		$quote_data = array();
		
		
		$products = $this->cart->getProducts();
		$this->load->model('catalog/product');
		foreach ($products as $product)
		{
			$product_obj = $this->model_catalog_product->getProduct($product['product_id']);
			if ($this->config->get('balticodedpdparcelstore_disableifhtml'))
			{
				if (strpos($product_obj['description'],'no dpd_ee_module') !== false)
				{
					return array();
				}
			}
			if ($this->config->get('balticodedpdparcelstore_maxweight')>0)
			{
				if ($product_obj['weight']>$this->config->get('balticodedpdparcelstore_maxweight'))
				{
					return array();
				}
			}
		}
		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");
	
		foreach ($query->rows as $result) {
			if ($this->config->get('balticodedpdparcelstore_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
				if ($query->num_rows) {
					$status = true;
				} else {
					$status = false;
				}
			} else {
				$status = false;
			}
		
			if ($status) {
				$cost = '';
				$balticodedpdparcelstore_cartWeight = $this->cart->getWeight();
				
				if ($this->config->get('balticodedpdparcelstore_price'))
				{
					$cost = $this->config->get('balticodedpdparcelstore_price');
				}
				
				if ($this->config->get('balticodedpdparcelstore_' . $result['geo_zone_id'] . '_baseshippingprice'))
				{
					$cost = $this->config->get('balticodedpdparcelstore_' . $result['geo_zone_id'] . '_baseshippingprice');
				}
				
				if ($this->config->get('balticodedpdparcelstore_handlingaction'))
				{
					$cost *= $this->cart->countProducts();
				}
				
				$balticodedpdparcelstore_count_over_limit = ceil($balticodedpdparcelstore_cartWeight/10) - 1;
				if (($balticodedpdparcelstore_count_over_limit>0) && ($this->config->get('balticodedpdparcelstore_' . $result['geo_zone_id'] . '_priceperadditional')>0))
				{
					$cost += $balticodedpdparcelstore_count_over_limit * $this->config->get('balticodedpdparcelstore_' . $result['geo_zone_id'] . '_priceperadditional');
				}
				if ($this->config->get('balticodedpdparcelstore_enablefreeshipping'))
				{
					$freeshipping_from = '';
					$configFrom = $this->config->get('balticodedpdparcelstore_freeshippingsubtotal');
					if ($configFrom>0||$configFrom==='0')
					{
						$freeshipping_from = $this->config->get('balticodedpdparcelstore_freeshippingsubtotal');
					}
					$configFrom = $this->config->get('balticodedpdparcelstore_' . $result['geo_zone_id'] . '_freeshippingfrom');
					if ($configFrom>0||$configFrom==='0')
					{
						$freeshipping_from = $this->config->get('balticodedpdparcelstore_' . $result['geo_zone_id'] . '_freeshippingfrom');
					}
					if (($freeshipping_from>=0) && ($this->cart->getSubTotal()>=$freeshipping_from))
					{
						$cost = 0;
					}
				}
				
				
				
				
				if ((string)$cost != '') {
					
					
					
					$checkbox = 'balticodedpdparcelstore.balticodedpdparcelstore_select';
//		print_r($this->session->data['shipping_method']);
		if (isset($this->session->data['shipping_method']) && isset($this->session->data['shipping_method']['id']) && strpos($this->session->data['shipping_method']['id'], 'balticodedpdparcelstore') !== false) {
			$checkbox = $this->session->data['shipping_method']['id'];
		}
					
					$quotes = $this->_quote($address['iso_code_2']);
					if ($quotes) {
						if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], '/admin/') !== FALSE) {
							foreach ($quotes as $q) {
								$quote_data['balticodedpdparcelstore'.$q['id']] = array(
									'id'           => 'balticodedpdparcelstore.balticodedpdparcelstore'.$q['id'],
									'code'           => 'balticodedpdparcelstore.balticodedpdparcelstore'.$q['id'],
									'title'        => 'DPD Siuntų taškai - '.$q['title'],
									'cost'         => $cost,
									'tax_class_id' => $this->config->get('balticodedpdparcelstore_tax_class_id'),
									'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('balticodedpdparcelstore_tax_class_id'), $this->config->get('config_tax')))
								);
							}
							
						}
						else {
							$dropSelect = '';
							$dropSelect .= '</label><select name="balticodeselect" id="balticodeselect" style="width: 250px;" onmousemove="" onclick="this.parentNode.parentNode.getElementsByTagName(\'input\')[0].checked = true;this.parentNode.parentNode.getElementsByTagName(\'input\')[0].value = document.getElementById(\'balticodeselect\').value;" onchange="this.parentNode.parentNode.getElementsByTagName(\'input\')[0].checked = true;this.parentNode.parentNode.getElementsByTagName(\'input\')[0].value = document.getElementById(\'balticodeselect\').value;">';
							$groupsorttext = false;
							foreach ($quotes as $q) {
								if (trim($groupsorttext) != trim($q['group_sort']))
								{
									if ($groupsorttext)
									{
										$dropSelect .= '</optgroup>';
									}
									$groupsorttext = $q['group_sort'];
									$dropSelect .= '<optgroup label="'.$groupsorttext.'">';
								}
								if (isset($this->session->data['shipping_method']) && isset($this->session->data['shipping_method']['id']) && $this->session->data['shipping_method']['id'] == 'balticodedpdparcelstore.balticodedpdparcelstore'.$q['id']) {
									$dropSelect .= "<option value='".'balticodedpdparcelstore.balticodedpdparcelstore'.$q['id']."' selected='selected'>".$q['title']."</option>\r\n";
								} else {
									$dropSelect .= "<option value='".'balticodedpdparcelstore.balticodedpdparcelstore'.$q['id']."'>".$q['title']."</option>\r\n";
								}
							}
							if ($groupsorttext)
							{
								$dropSelect .= '</optgroup>';
							}
				//			print_r($this->cart->getProducts());
							$dropSelect .= "</select>";//.print_r($address, true);iso_code_2
							$dropSelect .= "<label> &nbsp;&nbsp;&nbsp; ";
				//			$dropSelect .= '<script type="text/javascript">jQuery(document).ready( function() {var v = document.getElementById(\'balticodeselect\').parentNode.parentNode.nextSibling; while(v && v.nodeType != 1) {v = v.nextSibling;} v.style.display = \'none\';document.getElementById(\'balticodeselect\').parentNode.parentNode.getElementsByTagName(\'input\')[0].value = document.getElementById(\'balticodeselect\').value;});</script>';
				
				//			$dropSelect .= '<script type="text/javascript">var iuuuuupo = function() {var v = document.getElementById(\'balticodeselect\').parentNode.parentNode.nextSibling; while(v && v.nodeType != 1) {v = v.nextSibling;} v.style.display = \'none\';document.getElementById(\'balticodeselect\').parentNode.parentNode.getElementsByTagName(\'input\')[0].value = document.getElementById(\'balticodeselect\').value;}; iuuuuupo();</script>';
							if (!isset($_POST['country_id'])) {
				
				
								$dropSelect .= '<script type="text/javascript">jQuery(document).ready(function() {var v = document.getElementById(\'balticodeselect\').parentNode.parentNode.nextSibling; while(v && v.nodeType != 1) {v = v.nextSibling;} v.style.display = \'none\';document.getElementById(\'balticodeselect\').parentNode.parentNode.getElementsByTagName(\'input\')[0].value = document.getElementById(\'balticodeselect\').value;});</script>';
					//			$dropSelect .= '<script type="text/javascript">var iuuuuu = function() {var v = document.getElementById(\'balticodeselect\').parentNode.parentNode.nextSibling; while(v && v.nodeType != 1) {v = v.nextSibling;} v.style.display = \'none\';document.getElementById(\'balticodeselect\').parentNode.parentNode.getElementsByTagName(\'input\')[0].value = document.getElementById(\'balticodeselect\').value;}; iuuuuu();</script>';
							}
				
							$quote_data['balticodedpdparcelstore.balticodedpdparcelstore_select'] = array(
								'id'           => $checkbox,
								'code'           => $checkbox,
								'title'        => $dropSelect,
								'cost'         => $cost,
								'tax_class_id' => $this->config->get('balticodedpdparcelstore_tax_class_id'),
								'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('balticodedpdparcelstore_tax_class_id'), $this->config->get('config_tax')))
							);
				
							/* begin start section hack */
							$quote_data['balticodedpdparcelstore.balticodedpdparcelstore_begin'] = array(
								'id'           => 'balticodedpdparcelstore.balticodedpdparcelstore_begin',
								'code'           => 'balticodedpdparcelstore.balticodedpdparcelstore_begin',
								'title'        => '<!--',
								'cost'         => $cost,
								'tax_class_id' => $this->config->get('balticodedpdparcelstore_tax_class_id'),
								'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('balticodedpdparcelstore_tax_class_id'), $this->config->get('config_tax')))
							);
							/* end start section hack */
							
							foreach ($quotes as $q) {
								$quote_data['balticodedpdparcelstore'.$q['id']] = array(
									'id'           => 'balticodedpdparcelstore.balticodedpdparcelstore'.$q['id'],
									'code'           => 'balticodedpdparcelstore.balticodedpdparcelstore'.$q['id'],
									'title'        => 'DPD Siuntų taškai - '.$q['title'],
									'cost'         => $cost,
									'tax_class_id' => $this->config->get('balticodedpdparcelstore_tax_class_id'),
									'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('balticodedpdparcelstore_tax_class_id'), $this->config->get('config_tax')))
								);
							}
							
							
							/* begin end section hack */
							$quote_data['balticodedpdparcelstore.balticodedpdparcelstore_end'] = array(
								'id'           => 'balticodedpdparcelstore.balticodedpdparcelstore_end',
								'code'           => 'balticodedpdparcelstore.balticodedpdparcelstore_end',
								'title'        => '-->',
								'cost'         => $cost,
								'tax_class_id' => $this->config->get('balticodedpdparcelstore_tax_class_id'),
								'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('balticodedpdparcelstore_tax_class_id'), $this->config->get('config_tax')))
							);
							/* end end section hack */
									
									
									
									
									
						
						
						
						/*
						$quote_data['balticodedpdparcelstore_' . $result['geo_zone_id']] = array(
							'code'         => 'balticodedpdparcelstore.balticodedpdparcelstore_' . $result['geo_zone_id'],
							'title'        => $result['name'] . '  (' . $this->language->get('text_balticodedpdparcelstore') . ' ' . $this->weight->format($balticodedpdparcelstore_cartWeight, $this->config->get('config_weight_class_id')) . ')',
							'cost'         => $cost,
							'tax_class_id' => $this->config->get('balticodedpdparcelstore_tax_class_id'),
							'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('balticodedpdparcelstore_tax_class_id'), $this->config->get('config_tax')))
						);*/
						}
					}
				}
			}
		}
		
		$method_data = array();
	
		if ($quote_data) {
      		$method_data = array(
        		'code'       => 'balticodedpdparcelstore',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('balticodedpdparcelstore_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;
  	}
	
	
	
	function getGroupSort($group_name) {
        $group_name = trim(strtolower($group_name));
        $sorts = array(
            //Estonia
            'tallinn' => 20,
            'tartu' => 19,
            'pärnu' => 18,
            //Latvia
            'riga' => 20,
            'daugavpils' => 19,
            'liepaja' => 18,
            'jelgava' => 17,
            'jurmala' => 16,
            //Lithuania
            'vilnius' => 20,
            'kaunas' => 19,
            'klaipeda' => 18,
            'siauliai' => 17,
            'alytus' => 16,
        );
        if (isset($sorts[$group_name])) {
            return $sorts[$group_name];
        }
        return 0;
    }
	
	function groupCmp($a, $b)
	{
		if ($a['group_sort_nr'] == $b['group_sort_nr'])
		{
			return 0;
		}
		return ($a['group_sort_nr'] < $b['group_sort_nr']) ? 1 : -1;
	}
	function groupNameCmp($a, $b)
	{
		if ($a['group_sort'] == $b['group_sort'])
		{
			return 0;
		}
		return ($a['group_sort'] < $b['group_sort']) ? -1 : 1;
	}
	
	function _quote($country = '', $city = '', $state = '') {
	    $city = htmlentities($city);
	    $state = htmlentities($state);
		$this->load->model('balticodedpdlivehandler/balticodedpdlivehandler');
		$responseObj = $this->model_balticodedpdlivehandler_balticodedpdlivehandler->getRequest();
		if ($responseObj)
		{
			$response = $responseObj['parcelshops'];
			$result = array();
			foreach ($response as $r) {
				if ($r['parcelshop_id'] > 0) {
					if ($country == $r['country'])
					{
						if ($this->config->get('balticodedpdparcelstore_short_office_names')) {
							$result[] = array(
							'id' => $this->code."_".$r['parcelshop_id'],
							'code' => $this->code."_".$r['parcelshop_id'],
									'title' => htmlentities($r['company'], ENT_COMPAT, "UTF-8")."",
									'group_sort' => $r['city'],//'',//$r['group_sort'],getGroupSort
									'group_sort_nr' => $this->getGroupSort($r['city']),
									'cost' => $this->cost);
						} else {
							$result[] = array(
							'id' => $this->code."_".$r['parcelshop_id'],
							'code' => $this->code."_".$r['parcelshop_id'],
									'title' => htmlentities($r['company']." (".$r['street']." ".$r['city'].", ".$r['country']." ".$r['phone'].")", ENT_COMPAT, "UTF-8")."",
									'group_sort' => $r['city'],//'',//$r['group_sort'],
									'group_sort_nr' => $this->getGroupSort($r['city']),
									'cost' => $this->cost);
						}
					}
				}
			}
			usort($result, array('ModelShippingbalticodedpdparcelstore', 'groupNameCmp'));
			for ($i = 0; $i < count($result); $i++)
			{
				$result[$i]['group_sort_nr'] = $result[$i]['group_sort_nr'] * 1000 - $i;
			}
			if ($result && $this->config->get('balticodedpdparcelstore_sort_office_by_priority')) {
				usort($result, array('ModelShippingbalticodedpdparcelstore', 'groupCmp'));
			}
		  return $result;

		}
		else
		{
			return null;
		}
	}
}
?>