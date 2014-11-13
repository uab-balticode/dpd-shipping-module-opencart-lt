<?php
/*
* @package		MijoShop
* @copyright	2009-2013 Mijosoft LLC, mijosoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
//defined('_JEXEC') or die('Restricted access');
 
class ModelShippingBalticodedpdcourier extends Model {    
  	public function getQuote($address) {
		$this->language->load('shipping/balticodedpdcourier');
		
		$quote_data = array();
		
		
		$products = $this->cart->getProducts();
		$this->load->model('catalog/product');
		foreach ($products as $product)
		{
			$product_obj = $this->model_catalog_product->getProduct($product['product_id']);
			if ($this->config->get('balticodedpdcourier_disableifhtml'))
			{
				if (strpos($product_obj['description'],'no dpd_ee_module') !== false)
				{
					return array();
				}
			}
			if ($this->config->get('balticodedpdcourier_maxweight')>0)
			{
				if ($product_obj['weight']>$this->config->get('balticodedpdcourier_maxweight'))
				{
					return array();
				}
			}
		}
		

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");
	
		foreach ($query->rows as $result) {
			if ($this->config->get('balticodedpdcourier_' . $result['geo_zone_id'] . '_status')) {
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
				$balticodedpdcourier_cartWeight = $this->cart->getWeight();
				
				if ($this->config->get('balticodedpdcourier_price'))
				{
					$cost = $this->config->get('balticodedpdcourier_price');
				}
				
				if ($this->config->get('balticodedpdcourier_' . $result['geo_zone_id'] . '_baseshippingprice'))
				{
					$cost = $this->config->get('balticodedpdcourier_' . $result['geo_zone_id'] . '_baseshippingprice');
				}
				
				if ($this->config->get('balticodedpdcourier_handlingaction'))
				{
					$cost *= $this->cart->countProducts();
				}
				
				$balticodedpdcourier_count_over_limit = ceil($balticodedpdcourier_cartWeight/10) - 1;
				if (($balticodedpdcourier_count_over_limit>0) && ($this->config->get('balticodedpdcourier_' . $result['geo_zone_id'] . '_priceperadditional')>0))
				{
					$cost += $balticodedpdcourier_count_over_limit * $this->config->get('balticodedpdcourier_' . $result['geo_zone_id'] . '_priceperadditional');
				}
				if ($this->config->get('balticodedpdcourier_enablefreeshipping'))
				{
					$freeshipping_from = '';
					$configFrom = $this->config->get('balticodedpdcourier_freeshippingsubtotal');
					if ($configFrom>0||$configFrom==='0')
					{
						$freeshipping_from = $this->config->get('balticodedpdcourier_freeshippingsubtotal');
					}
					$configFrom = $this->config->get('balticodedpdcourier_' . $result['geo_zone_id'] . '_freeshippingfrom');
					if ($configFrom>0||$configFrom==='0')
					{
						$freeshipping_from = $this->config->get('balticodedpdcourier_' . $result['geo_zone_id'] . '_freeshippingfrom');
					}
					if (($freeshipping_from>=0) && ($this->cart->getSubTotal()>=$freeshipping_from))
					{
						$cost = 0;
					}
				}
				
				
				
				
				if ((string)$cost != '') { 
					$quote_data['balticodedpdcourier_' . $result['geo_zone_id']] = array(
						'code'         => 'balticodedpdcourier.balticodedpdcourier_' . $result['geo_zone_id'],
						'title'        => 'DPD Courier '.$result['name'] . '  (' . $this->language->get('text_balticodedpdcourier') . ' ' . $this->weight->format($balticodedpdcourier_cartWeight, $this->config->get('config_balticodedpdcourier_class_id')) . ')',
						'cost'         => $cost,
						'tax_class_id' => $this->config->get('balticodedpdcourier_tax_class_id'),
						'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('balticodedpdcourier_tax_class_id'), $this->config->get('config_tax')))
					);	
				}
			}
		}
		
		$method_data = array();
	
		if ($quote_data) {
      		$method_data = array(
        		'code'       => 'balticodedpdcourier',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('balticodedpdcourier_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;
  	}
}
?>