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
      <h1><img src="http://balticode.com/bclogo.jpg" widh="22" height="22" alt="<?php echo $heading_title; ?>" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button">
        <span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table id="module" class="list">
          <thead>
            <tr>
              <td class="left" colspan="2"><?php echo $text_global_settings_label; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="left"><?php echo $text_global_settings_label_enabled; ?></td>
              <td class="left">
                <select name="balticodedpdlivehandler_status">
                <?php if($this->isset_value($balticodedpdlivehandler_status, "0") == "1"){ ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
              </td>
            </tr>
          </tbody>
          <thead>
            <tr>
              <td class="left" colspan="2"><?php echo $text_admin_order_settings_label; ?></td>
            </tr>
          </thead>
          <tbody>
          <?php /**
            <tr>
              <td class="left"><?php echo $text_admin_order_settings_label_enabled; ?></td>
              <td class="left"><select name="balticodedpdlivehandler_admin_order_enable">
                <?php if( $this->isset_value($balticodedpdlivehandler_admin_order_enable, "0") == "1"){ ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_admin_order_settings_label_open_order_new_window; ?></td>
              <td class="left"><select name="balticodedpdlivehandler_admin_order_new_windows">
                <?php if( $this->isset_value($balticodedpdlivehandler_admin_order_new_windows, "0") == "1"){ ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_admin_order_settings_label_postoffice_send_status; ?></td>
              <td class="left"><select name="balticodedpdlivehandler_admin_order_postoffice_send_status">
                <?php if( $this->isset_value($balticodedpdlivehandler_admin_order_postoffice_send_status,"0") == "1"){ ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            <tr>
              <td class="left"><?php echo $text_admin_order_settings_label_postoffice_print_status; ?></td>
              <td class="left"><select name="balticodedpdlivehandler_admin_order_postoffice_print_status">
                <?php if( $this->isset_value($balticodedpdlivehandler_admin_order_postoffice_print_status,"0") == "1"){ ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
            </tr>
            **/ ?>
            <tr>
              <td class="left"><span class="required">*</span>
                <?php echo $text_admin_order_settings_label_dpdweblabel_login_username; ?></td>
              <td class="left"><input type="text" name="balticodedpdlivehandler_weblabel_user_name" value="<?php echo $this->isset_value($balticodedpdlivehandler_weblabel_user_name); ?>" />
                <?php if (isset($error['balticodedpdlivehandler_weblabel_user_name'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdlivehandler_weblabel_user_name']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td class="left"><span class="required">*</span>
                <?php echo $text_admin_order_settings_label_dpdweblabel_login_userpassword; ?></td>
              <td class="left"><input type="password" name="balticodedpdlivehandler_weblabel_user_password" value="<?php echo $this->isset_value($balticodedpdlivehandler_weblabel_user_password); ?>" />
                <?php if (isset($error['balticodedpdlivehandler_weblabel_user_password'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdlivehandler_weblabel_user_password']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td class="left"><span class="required">*</span>
                <?php echo $text_admin_order_settings_label_dpdweblabel_login_userid; ?></td>
              <td class="left">
                <input type="text" name="balticodedpdlivehandler_weblabel_user_id" value="<?php echo $this->isset_value($balticodedpdlivehandler_weblabel_user_id); ?>" />
                  <?php if (isset($error['balticodedpdlivehandler_weblabel_user_id'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdlivehandler_weblabel_user_id']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td class="left"><span class="required">*</span>
                <?php echo $text_admin_order_settings_label_api_url; ?></td>
              <td class="left"><input type="text" name="balticodedpdlivehandler_api_url" value="<?php echo (isset($balticodedpdlivehandler_api_url))?$balticodedpdlivehandler_api_url:'https://weblabel.dpd.lt/parcel_interface/'; ?>" />
                <?php if (isset($error['balticodedpdlivehandler_api_url'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdlivehandler_api_url']; ?></span>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td class="left"><span class="required">*</span>
                <?php echo $text_admin_order_settings_label_http_request_timeout; ?></td>
              <td class="left"><input type="text" name="balticodedpdlivehandler_http_request_timeout" value="<?php echo (isset($balticodedpdlivehandler_http_request_timeout))?$balticodedpdlivehandler_http_request_timeout:'60'; ?>" />
                  <?php if (isset($error['balticodedpdlivehandler_http_request_timeout'])) { ?>
                  <span class="error"><?php echo $error['balticodedpdlivehandler_http_request_timeout']; ?></span>
                <?php } ?></td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>