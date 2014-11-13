<?php echo $header; ?>
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
              <td><select name="balticodedpdcourier_tax_class_id">
                  <option value="0"><?php echo $text_none; ?></option>
                  <?php foreach ($tax_classes as $tax_class) { ?>
                  <?php if ($tax_class['tax_class_id'] == $balticodedpdcourier_tax_class_id) { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="balticodedpdcourier_status">
                  <?php if ($balticodedpdcourier_status) { ?>
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
              <td><input type="text" name="balticodedpdcourier_price" value="<?php echo $balticodedpdcourier_price; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_disableifhtml; ?></td>
              <td><select name="balticodedpdcourier_disableifhtml">
                  <?php if ($balticodedpdcourier_disableifhtml) { ?>
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
              <td><input type="text" name="balticodedpdcourier_maxweight" value="<?php echo $balticodedpdcourier_maxweight; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_handlingaction; ?></td>
              <td><select name="balticodedpdcourier_handlingaction">
                  <?php if ($balticodedpdcourier_handlingaction) { ?>
                  <option value="0"><?php echo $balticodedpdcourier_handlingactions[0]; ?></option>
                  <option value="1" selected="selected"><?php echo $balticodedpdcourier_handlingactions[1]; ?></option>
                  <?php } else { ?>
                  <option value="0" selected="selected"><?php echo $balticodedpdcourier_handlingactions[0]; ?></option>
                  <option value="1"><?php echo $balticodedpdcourier_handlingactions[1]; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_enablefreeshipping; ?></td>
              <td><select name="balticodedpdcourier_enablefreeshipping">
                  <?php if ($balticodedpdcourier_enablefreeshipping) { ?>
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
              <td><input type="text" name="balticodedpdcourier_freeshippingsubtotal" value="<?php echo $balticodedpdcourier_freeshippingsubtotal; ?>" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_enablecod; ?></td>
              <td><select name="balticodedpdcourier_enablecod">
                  <?php if ($balticodedpdcourier_enablecod) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="balticodedpdcourier_sort_order" value="<?php echo $balticodedpdcourier_sort_order; ?>" size="1" /></td>
            </tr>
          </table>
        </div>
        <?php foreach ($geo_zones as $geo_zone) { ?>
        <div id="tab-geo-zone<?php echo $geo_zone['geo_zone_id']; ?>" class="vtabs-content">
          <table class="form">
            <tr>
              <td><?php echo $entry_baseshippingprice; ?></td>
              <td><input type="text" name="balticodedpdcourier_<?php echo $geo_zone['geo_zone_id']; ?>_baseshippingprice" value="<?php echo ${'balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_baseshippingprice'}; ?>"/></td>
            </tr>
            <tr>
              <td><?php echo $entry_priceperadditional; ?></td>
              <td><input type="text" name="balticodedpdcourier_<?php echo $geo_zone['geo_zone_id']; ?>_priceperadditional" value="<?php echo ${'balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_priceperadditional'}; ?>"/></td>
            </tr>
            <tr>
              <td><?php echo $entry_freeshippingfrom; ?></td>
              <td><input type="text" name="balticodedpdcourier_<?php echo $geo_zone['geo_zone_id']; ?>_freeshippingfrom" value="<?php echo ${'balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_freeshippingfrom'}; ?>"/></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="balticodedpdcourier_<?php echo $geo_zone['geo_zone_id']; ?>_status">
                  <?php if (${'balticodedpdcourier_' . $geo_zone['geo_zone_id'] . '_status'}) { ?>
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
//--></script> 
<?php echo $footer; ?> 