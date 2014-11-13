<?php
/*
* @package		MijoShop
* @copyright	2009-2013 Mijosoft LLC, mijosoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
//defined('_JEXEC') or die('Restricted access');

// Heading
$_['heading_title']    = 'BaltiCode DPD Siuntų taškai';

// Text
$_['text_shipping']    = 'Shipping';
$_['text_success']     = 'Success: You have modified weight based shipping!';
$_['text_send_after_checkout']    = 'After successful checkout';
$_['text_send_after_shipment']    = 'After successful shipment creation';
$_['text_send_manual']    = 'I will send data myself by clicking on the button';
$_['text_all_allowed_countries'] = 'All Allowed Countries';
$_['text_specific_countries'] = 'Specific Countries';
$_['text_rebuild'] = 'Rebuild postoffices for this carrier';
// Entry
$_['entry_baseshippingprice']  = 'Base shipping price:';
$_['entry_priceperadditional']  = 'Price per additional 10kg over base 10kg:';
$_['entry_freeshippingfrom']  = 'Free shipping from price:';
$_['entry_price']  = 'Price:';
$_['entry_short_office_names'] = 'Show short office names:';
$_['entry_sort_office_by_priority'] = 'Sort offices by priority:';

$_['entry_disableifhtml']  = 'Disable this carrier if product\'s description contains HTML comment &lt;!-- no dpd_ee_module --&gt;:';
$_['entry_maxweight']  = 'Maximum allowed package weight for this carrier (kg):';
$_['entry_handlingaction']  = 'Handling action:';
$_['entry_perorder']  = 'Per order';
$_['entry_perpackage']  = 'Per package';
$_['entry_enablefreeshipping']  = 'Enable free shipping:';
$_['entry_freeshippingsubtotal']  = 'Free shipping subtotal:';
$_['entry_auto_send_data'] = 'Auto send sata to DPD server:';
	/* SHOW IF balticodedpdparcelstore_auto_send_data IS VALUE "1" start */
$_['entry_send_parcel_data'] = 'When to send parcel data:';
$_['entry_pickup_address_name']='Pickup address name';
$_['entry_pickup_address_company']='Pickup address company';
$_['entry_pickup_address_email']='Pickup address e-mail';
$_['entry_pickup_address_phone']='Pickup address phone';
$_['entry_pickup_address_street']='Pickup address street';
$_['entry_pickup_address_city_county']='Pickup address city, county';
$_['entry_pickup_adress_zip_code']='Pickup address zip code';
$_['entry_pickup_address_country']='Pickup address country';
	/* SHOW IF balticodedpdparcelstore_auto_send_data IS VALUE "1" end */
$_['entry_error_message'] = 'Error message displayed to the user';

$_['entry_ship_to_specific_status'] = 'Ship to applicable countries';
$_['entry_ship_to_specific_list'] = 'Ship to Specific countries';
$_['entry_pixels_city'] = 'Width in pixels for city select menu';
$_['entry_pixels_office'] = 'Width in pixels for office select menu';
$_['entry_show_one_dropdown_status'] = 'Show customer one dropdown instead of two';
$_['entry_update_interval'] = 'Update interval for the postoffice list in minutes';
$_['entry_population_list_of_list_status'] = 'Disable populating list of last selected';
$_['entry_rebuild_list_status'] = 'Rebuild Postoffice List';


$_['entry_allow_courier_pickup'] = 'Allow courier pickup';
$_['entry_enablecod']  = 'Enable cash on delivery:';
$_['entry_tax_class']  = 'Tax Class:';
$_['entry_geo_zone']   = 'Geo Zone:';
$_['entry_status']     = 'Status:';
$_['entry_sort_order'] = 'Sort Order:';

// Error
$_['error_permission'] = 'Warning: You do not have permission to modify weight based shipping!';
$_['error_balticodedpdparcelstore_pickup_address_name'] = '^This field is required';
$_['error_balticodedpdparcelstore_pickup_address_company'] = '^This field is required';
$_['error_balticodedpdparcelstore_pickup_address_email'] = '^This field is required';
$_['error_balticodedpdparcelstore_pickup_address_phone'] = '^This field is required';
$_['error_balticodedpdparcelstore_pickup_address_street'] = '^This field is required';
$_['error_balticodedpdparcelstore_pickup_address_city_county'] = '^This field is required';
$_['error_balticodedpdparcelstore_pickup_adress_zip_code'] = '^This field is required';


$_['entry_order_status_id'] = 'Which order status to use for auto send:';


?>