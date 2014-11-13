<?php echo $header; ?>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div class="vtabs"><a href="#tab-general"><?php echo $tab_general; ?></a>
        <?php foreach ($geo_zones as $geo_zone) { ?>
        <a href="#tab-geo-zone<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></a>
        <?php } ?>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $entry_tax_class; ?></td>
              <td><select name="balticodedpdparcelstore_tax_class_id">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tax_class) { ?>
                  <?php if ($tax_class['tax_class_id'] == $balticodedpdparcelstore_tax_class_id) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="balticodedpdparcelstore_status">
                  <?php if ($balticodedpdparcelstore_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_price; ?></td>
              <td><input type="text" name="balticodedpdparcelstore_price" value="<?php echo $balticodedpdparcelstore_price; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_short_office_names; ?></td>
              <td><select name="balticodedpdparcelstore_short_office_names">
                <?php if($balticodedpdparcelstore_short_office_names){ ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_office_by_priority; ?></td>
              <td><select name="balticodedpdparcelstore_sort_office_by_priority">
                <?php if($balticodedpdparcelstore_sort_office_by_priority){ ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <option value="0"><?php echo $text_no; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_disableifhtml; ?></td>
              <td><select name="balticodedpdparcelstore_disableifhtml">
                  <?php if ($balticodedpdparcelstore_disableifhtml) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_maxweight; ?></td>
              <td><input type="text" name="balticodedpdparcelstore_maxweight" value="<?php echo $balticodedpdparcelstore_maxweight; ?>" />
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_handlingaction; ?></td>
              <td><select name="balticodedpdparcelstore_handlingaction">
                  <?php if ($balticodedpdparcelstore_handlingaction) { ?>
                  <option value="0"><?php echo $balticodedpdparcelstore_handlingactions[0]; ?></option>
                  <option value="1" selected="selected"><?php echo $balticodedpdparcelstore_handlingactions[1]; ?></option>
                  <?php } else { ?>
                  <option value="0" selected="selected"><?php echo $balticodedpdparcelstore_handlingactions[0]; ?></option>
                  <option value="1"><?php echo $balticodedpdparcelstore_handlingactions[1]; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_enablefreeshipping; ?></td>
              <td><select name="balticodedpdparcelstore_enablefreeshipping">
                  <?php if ($balticodedpdparcelstore_enablefreeshipping) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_freeshippingsubtotal; ?></td>
              <td><input type="text" name="balticodedpdparcelstore_freeshippingsubtotal" value="<?php echo $balticodedpdparcelstore_freeshippingsubtotal; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_auto_send_data; ?></td>
              <td><select name="balticodedpdparcelstore_auto_send_data">
                <?php if($balticodedpdparcelstore_auto_send_data){ ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td><?php echo $entry_allow_courier_pickup; ?></td>
              <td><select name="balticodedpdparcelstore_allow_courier_pickup">
                <?php if($balticodedpdparcelstore_allow_courier_pickup){ ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <?php /*<tr class="request_balticodedpdparcelstore_auto_send_data">
              <td>
                <?php echo $entry_send_parcel_data; ?>
              </td>
              <td>
              <select name="balticodedpdparcelstore_send_parcel_data">
                <option value="0"><?php echo $text_none; ?></option>
                <option value="after_checkout" <?php echo (!($balticodedpdparcelstore_send_parcel_data=="after_checkout"))?:'selected="selected"'; ?>><?php echo $text_send_after_checkout; ?></option>
                <option value="after_shipment" <?php echo (!($balticodedpdparcelstore_send_parcel_data=="after_shipment"))?:'selected="selected"'; ?>><?php echo $text_send_after_shipment; ?></option>
                <option value="manual" <?php echo (!($balticodedpdparcelstore_send_parcel_data=="manual"))?:'selected="selected"'; ?>><?php echo $text_send_manual; ?></option>
                </select>
              </td>
            </tr> */ ?>
            
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td>
                <?php echo $entry_order_status_id; ?>
              </td>
              <td>
                <select name="balticodedpdparcelstore_order_status_id">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($balticodedpdparcelstore_order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $balticodedpdparcelstore_order_status_id) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td><span class="required">*</span>
                <?php echo $entry_pickup_address_name; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_pickup_address_name" value="<?php echo $balticodedpdparcelstore_pickup_address_name; ?>" />
                <?php if (isset($error['balticodedpdparcelstore_pickup_address_name'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdparcelstore_pickup_address_name']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td><span class="required">*</span>
                <?php echo $entry_pickup_address_company; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_pickup_address_company" value="<?php echo $balticodedpdparcelstore_pickup_address_company; ?>" />
                <?php if (isset($error['balticodedpdparcelstore_pickup_address_company'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdparcelstore_pickup_address_company']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td><span class="required">*</span>
                <?php echo $entry_pickup_address_email; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_pickup_address_email" value="<?php echo $balticodedpdparcelstore_pickup_address_email; ?>" />
                <?php if (isset($error['balticodedpdparcelstore_pickup_address_email'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdparcelstore_pickup_address_email']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td><span class="required">*</span>
                <?php echo $entry_pickup_address_phone; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_pickup_address_phone" value="<?php echo $balticodedpdparcelstore_pickup_address_phone; ?>" />
                <?php if (isset($error['balticodedpdparcelstore_pickup_address_phone'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdparcelstore_pickup_address_phone']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td><span class="required">*</span>
                <?php echo $entry_pickup_address_street; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_pickup_address_street" value="<?php echo $balticodedpdparcelstore_pickup_address_street; ?>" />
                <?php if (isset($error['balticodedpdparcelstore_pickup_address_street'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdparcelstore_pickup_address_street']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td><span class="required">*</span>
                <?php echo $entry_pickup_address_city_county; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_pickup_address_city_county" value="<?php echo $balticodedpdparcelstore_pickup_address_city_county; ?>" />
                <?php if (isset($error['balticodedpdparcelstore_pickup_address_city_county'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdparcelstore_pickup_address_city_county']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td><span class="required">*</span>
                <?php echo $entry_pickup_adress_zip_code; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_pickup_adress_zip_code" value="<?php echo $balticodedpdparcelstore_pickup_adress_zip_code; ?>" />
                <?php if (isset($error['balticodedpdparcelstore_pickup_adress_zip_code'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdparcelstore_pickup_adress_zip_code']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr class="request_balticodedpdparcelstore_auto_send_data">
              <td>
                <?php echo $entry_pickup_address_country; ?>
              </td>
              <td><?php /* THIS IS EXAMPLE OF Counry list
[21] => Array
        (
            [country_id] => 21
            [name] => Belgium
            [iso_code_2] => BE
            [iso_code_3] => BEL
            [address_format] => {firstname} {lastname}
                                  {company}
                                  {address_1}
                                  {address_2}
                                  {postcode} {city}
                                  {country}
            [postcode_required] => 0
            [status] => 1
        )*/?><select name="balticodedpdparcelstore_pickup_address_country">
                <option value="0"><?php echo $text_none; ?></option>
                <?php foreach ($balticodedpdparcelstore_pickup_address_country_list as $country) { ?>
                  <?php if($country['status']) { ?>
                  <option value="<?php echo $country['country_id']; ?>" <?php echo (!($balticodedpdparcelstore_pickup_address_country==$country['country_id']))?:'selected="selected"'; ?>><?php echo $country['name']; ?></option>
                  <?php } ?>
                <?php } ?>
              </select>
              </td>
            </tr>
            <?php /*<tr class="request_balticodedpdparcelstore_auto_send_data">
              <td>
                <?php echo 'pickup adress on packing label'; ?>
              </td>
              <td>
                yes/no
                </td>
            </tr>*/ ?>
            <?php /*<tr>
              <td>
                <?php echo $entry_error_message; ?>
              </td>
              <td>
                <textarea name="balticodedpdparcelstore_error_message"><?php echo $balticodedpdparcelstore_error_message; ?></textarea>
              </td>
            </tr> */ ?>
<?php /*
            <tr>
              <td>
                <?php echo $entry_ship_to_specific_status; ?>
              </td>
              <td>
                <select name="balticodedpdparcelstore_ship_to_specific_status">
                  <?php if($balticodedpdparcelstore_ship_to_specific_status=="0"){ ?>
                    <option value="0" selected="selected"><?php echo $text_all_allowed_countries; ?></option>
                    <option value="1"><?php echo $text_specific_countries; ?></option>
                  <?php } else { ?>
                    <option value="0"><?php echo $text_all_allowed_countries; ?></option>
                    <option value="1" selected="selected"><?php echo $text_specific_countries; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr class="request_balticodedpdparcelstore_ship_to_specific_status">
              <td>
                <?php echo $entry_ship_to_specific_list; ?>
              </td>
              <td><select name="balticodedpdparcelstore_ship_to_specific_selected_list[]" multiple="multiple" >
                  <?php foreach ($balticodedpdparcelstore_ship_to_specific_list as $country) { ?>
                    <?php if($country['status']) { ?>
                    <option value="<?php echo $country['country_id']; ?>" 
<?php echo (!in_array($country['country_id'],$balticodedpdparcelstore_ship_to_specific_selected_list))?:'selected="selected"'; ?>
                      ><?php echo $country['name']; ?></option>
                    <?php } ?>
                <?php } ?>
                </select>
              </td>
            </tr>
*/ ?>
            <?php /* <tr>
              <td>
                <?php echo $entry_pixels_city; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_pixels_city" value="<?php echo $balticodedpdparcelstore_pixels_city; ?>" />
              </td>
            </tr>
            <tr>
              <td>
                 <?php echo $entry_pixels_office; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_pixels_office" value="<?php echo $balticodedpdparcelstore_pixels_office; ?>" />
              </td>
            </tr>
            <tr>
              <td> 
                <?php echo $entry_show_one_dropdown_status; ?>
              </td>
              <td>
                <select name="balticodedpdparcelstore_show_one_dropdown_status">
                  <?php if($balticodedpdparcelstore_show_one_dropdown_status=="0"){ ?>
                    <option value="0" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="1"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                    <option value="0"><?php echo $text_yes; ?></option>
                    <option value="1" selected="selected"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr> */ ?>
            <tr>
              <td>
                 <?php echo $entry_update_interval; ?>
              </td>
              <td>
                <input type="text" name="balticodedpdparcelstore_update_interval" value="<?php echo $balticodedpdparcelstore_update_interval; ?>" />
              </td>
            </tr>
            <?php /* <tr>
              <td><?php echo $entry_population_list_of_list_status; ?></td>
              <td>
                <select name="balticodedpdparcelstore_population_list_of_list_status">
                  <?php if($balticodedpdparcelstore_population_list_of_list_status=="0"){ ?>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr> */ ?>
            <tr>
              <td><?php echo $entry_enablecod; ?></td>
              <td>
                <select name="balticodedpdparcelstore_enablecod">
                  <?php if ($balticodedpdparcelstore_enablecod) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="balticodedpdparcelstore_sort_order" value="<?php echo $balticodedpdparcelstore_sort_order; ?>" size="1" /></td>
            </tr>
            <?php /* <tr>
              <td>  <?php echo $entry_rebuild_list_status ?></td>
              <td><button><?php echo $text_rebuild; ?></button></td>
            </tr> */ ?>
          </table>
        </div>
        <?php foreach ($geo_zones as $geo_zone) { ?>
        <div id="tab-geo-zone<?php echo $geo_zone['geo_zone_id']; ?>" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $entry_baseshippingprice; ?></td>
              <td><input type="text" name="balticodedpdparcelstore_<?php echo $geo_zone['geo_zone_id']; ?>_baseshippingprice" value="<?php echo ${'balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'}; ?>"/></td>
            </tr>
            <tr>
              <td><?php echo $entry_priceperadditional; ?></td>
              <td><input type="text" name="balticodedpdparcelstore_<?php echo $geo_zone['geo_zone_id']; ?>_priceperadditional" value="<?php echo ${'balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_priceperadditional'}; ?>"/></td>
            </tr>
            <tr>
              <td><?php echo $entry_freeshippingfrom; ?></td>
              <td><input type="text" name="balticodedpdparcelstore_<?php echo $geo_zone['geo_zone_id']; ?>_freeshippingfrom" value="<?php echo ${'balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'}; ?>"/></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="balticodedpdparcelstore_<?php echo $geo_zone['geo_zone_id']; ?>_status">
                  <?php if (${'balticodedpdparcelstore_' . $geo_zone['geo_zone_id'] . '_status'}) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
          </table>
        </div>
        <?php } ?>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('.vtabs a').tabs(); 

function validate_fields(value,name){
    var class_name='request_'+name;
    if(value==1){
        $('.'+class_name).show();
    } else {
        $('.'+class_name).hide();
    }
};

$(function() {
  //test who hide or show by selector name
  $("select").change(function(){
    validate_fields( $( this ).val(), $( this ).attr( "name" )  )
  })

  //test all items who hide or show on load
  $("select").each(function(index, value){
    validate_fields( $( this ).val(), $( this ).attr( "name" )  )    
  });
});

//--></script> 
<?php echo $footer; ?> 