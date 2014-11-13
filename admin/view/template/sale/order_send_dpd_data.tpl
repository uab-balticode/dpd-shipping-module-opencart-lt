<script>
  function makePOSTRequest(url, parameters) {
    http_request = false;
      if (window.XMLHttpRequest) { // Mozilla, Safari,...
        http_request = new XMLHttpRequest();
        if (http_request.overrideMimeType) {
          // set type accordingly to anticipated content type
            //http_request.overrideMimeType('text/xml');
            http_request.overrideMimeType('text/html');
        }
      } else if (window.ActiveXObject) { // IE
        try {
          http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
          try {
            http_request = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e) {}
        }
      }
      if (!http_request) {
        alert('Cannot create XMLHTTP instance');
        return false;
      }
      
   //   http_request.onreadystatechange = alertContents;
      http_request.open('POST', url, false);
      http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http_request.setRequestHeader("Content-length", parameters.length);
      http_request.setRequestHeader("Connection", "close");
      http_request.send(parameters);
      return http_request.responseText;
  }

    function send_data(url){
    var parameters = "Po_parcel_qty="+document.getElementById('Po_parcel_qty').value+"&Po_pallet_qty="+document.getElementById('Po_pallet_qty').value+"&Po_remark="+document.getElementById('Po_remark').value;
      document.getElementById("warning").value = makePOSTRequest(url, parameters).replace('<p>',' ').replace(/<\/?[^>]+(>|$)/g, "");
      document.getElementById('balticode_courier').submit();
    }
</script>
<style type="text/css">
.balticodelivehandler_call_courier_popup {
  display:none; 
  position: absolute; 
  background-color:#FFF; 
  margin-top:40px;  
  padding: 5px;
  border: 1px solid #000000;
}
.simple_input {
  width: 55px;
}
</style>
<div id="balticodelivehandler_call_courier" class="balticodelivehandler_call_courier_popup">
  <form method="POST" action="<?php echo $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL') ?>" id="balticode_courier">
    <div class="button_box" id="balticode_dpdlt__button_courier_box"><div class="shipment_info">
      <label for="Po_parcel_qty"><input name="Po_parcel_qty" id="Po_parcel_qty" value="1" class="simple_input" type="text"><?php echo $text_parcels_label; ?></label>
      <label for="Po_pallet_qty"><input name="Po_pallet_qty" id="Po_pallet_qty" value="0" class="simple_input" type="text"><?php echo $text_pallets_label; ?></label>
    </div>
    <div class="shipment_comment">
      <textarea name="Po_remark" id="Po_remark" cols="40" rows="5" title="Comment to courier"></textarea>
    </div>
    <input name="order_ids" id="balticode_dpdlt_order_ids" value="dummy" type="hidden"></div>
    <button type="button" onclick="send_data('<?php echo $balticodedpdlivehandler_dpd_courier; ?>')" value="Submit"><?php echo $text_button_send; ?></button>
    <button type="reset" value="Reset"><?php echo $text_button_reset; ?></button>
    <button type="button" onclick="jQuery('#balticodelivehandler_call_courier').hide()"><?php echo $text_button_close; ?></button>
    <input type="hidden" id="warning" name="warning" value="" />
  </form>
</div>