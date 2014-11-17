<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=8" />
		<meta http-equiv="X-UA-Compatible" content="IE=7" />
		<title><?php echo $title; ?></title>
		<?php foreach ($styles as $style) { ?>
		<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
		<?php } ?>
	</head>
	<body>
<table class="header_top" cellspacing="0" cellpadding="0">
	<tr>
		<td class="label_company allcaps"><?php echo $label_company; ?></td>
		<td class="label_phone"><?php echo $label_phone; ?></td>
		<td class="value_phone"><?php echo $value_phone; ?></td>
		<td colspan="2" rowspan="4" class="logo"><?php echo $value_logo; ?></td>
	</tr>
	<tr>
		<td class="label_vat label_vat_code allcpas"><?php echo $label_vat; ?> <?php echo $value_vat_code; ?></td>
		<td class="label_fax"><?php echo $label_fax; ?></td>
		<td class="value_fax"><?php echo $value_fax; ?></td>
	</tr>
	<tr>
		<td class="value_street allcaps" colspan="3"><?php echo $value_street; ?></td>
	</tr>
		<tr>
		<td colspan="3"></td>
	</tr>
</table>

<table class="header">
	<tr>
		<td class="line_h15 bold label_manifest_nr"><div class="bottom"><?php echo $label_manifest_nr; ?></div></td>
		<td class="line_h15 value_manifest_nr"><div class="bottom"><?php echo $value_manifest_nr; ?></div></td>
		<td class="line_h15 label_client"><div class="bottom"><?php echo $label_client; ?></div></td>
		<td class="line_h15 line_w160 value_client"><div class="bottom"><?php echo $value_client; ?></div></td>
		<td class="line_h15 label_vat_code"><div class="bottom"><?php echo $label_vat_code; ?></div></td>
		<td class="line_h15 label_sphone"><div class="bottom"><?php echo $label_sphone; ?></div></td>
	</tr>
	<tr>
		<td class="label_done_date"><?php echo $label_done_date; ?></td>
		<td class="value_done_date"><?php echo $value_done_date; ?></td>
		<td class="value_client_id"><?php echo $value_client_id; ?></td>
		<td class="value_client_street allcaps"><?php echo $value_client_street; ?></td>
		<td class="value_client_vat_code allcaps"><?php echo $value_client_vat_code; ?></td>
		<td class="value_client_phone"><?php echo $value_client_phone; ?></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td class="allcaps"><?php echo $value_client_city; ?></td>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td class="allcaps"><?php echo $value_client_post; ?></td>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="6" class="line_h20"></td>
	</tr>
</table>
<?php if(count($orders)){ ?>
	<table class="orders">
		<tr class="order_head">
			<td class="label_order_nr"><?php echo $label_order_nr; ?></td>
			<td class="label_order_type"><?php echo $label_order_type; ?></td>
			<td class="label_order_arrival"><?php echo $label_order_arrival; ?></td>
			<td class="label_order_phone"><?php echo $label_order_phone; ?></td>
			<td class="label_order_weight"><?php echo $label_order_weight; ?></td>
			<td class="label_order_number"><?php echo $label_order_number; ?></td>
			<td class="label_order_issn"><?php echo $label_order_issn; ?></td>
		</tr>
		<?php $nr=1; ?>
		<?php $value_total=0; ?>
		<?php foreach ($orders as $order) { ?>
			<tr class="order">
				<td><?php echo $nr++; ?></td>
				<td><?php echo $order['parcel_type']; ?></td>
				<td><?php echo $order['shipping_firstname']; ?> <?php echo $order['shipping_lastname']; ?><br />
					<?php echo $order['shipping_address_1']; ?><br />
					<?php echo $order['shipping_postcode']; ?><br />
					<div class="bold"><?php echo $order['shipping_city'];?></div>
				</td>
				<td><?php echo $order['telephone']; ?></td>
				<td><?php echo $order['total_weight']; ?></td>
				<td><?php echo $order['tracking_number']; ?></td>
				<td class="center"><div class="checkbox"></div></td>
			</tr>
		<?php $value_total+=$order['total_weight']; ?>
		<? } ?>
		<tr>
			<td class="bold"><?php echo $label_total; ?></td>
			<td colspan="3">&nbsp;</td>
			<td class="bold"><?php echo $value_orders_weight; ?></td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo $label_orders_count; ?></td>
			<td colspan="6"><?php echo count($orders); ?></td>
		</tr>
		<tr>
			<td><?php echo $label_packages_count; ?></td>
			<td colspan="6"><?php echo $value_packages_count; ?></td>
		</tr>
	</table>
<?php } ?>
<table cellpadding="0" cellspacing="0" width="0" height="0" border="0"><tr><td></td></tr></table>
<table class="extra" style="page-break-inside: avoid;">
	<tr>
		<td class="cell first">



			<table border="0">
				<tr>
					<td colspan="3" class="bold label_additional"><?php echo $label_additional; ?></td>
				</tr>
				<tr>
					<td colspan="3"><div class="line line_w200"></div></td>
				</tr>
				<tr>
					<td class="label_load">
						<div class="checkbox"></div><?php echo $label_load; ?>
					</td>
					<td class="label_wait"><div class="checkbox"></div><?php echo $label_wait; ?>
					</td>
					<td class="label_smin">
						<div class="checkbox_dotted"></div><div class="checkbox_dotted checkbox_middle_box"></div><div class="checkbox_dotted"></div>
						<?php echo $label_smin; ?>
					</td>
				</tr>
			</table>



		</td>
	</tr>
	<tr>
		<td class="cell">


			<table class="issn">
				<tr>
					<td class="bold text_notification_title"><?php echo $text_notification_title; ?></td>
				</tr>
				<tr>
					<td><div class="line line_w350"/></td>
				</tr>
				<?php foreach ($text_notification as $notification) { ?>
				<tr>
					<td class="notification"><?php echo $notification ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td class="value_issn_nr">
						<div class="checkbox line_w685 line_h15"></div>
					</td>
				</tr>
			</table>

		</td>
	</tr>
	<tr>
		<td class="cell last">
						<table border="0" cellspacing="0" cellpadding="0" width="747px">
							<tr>
								<td class="text_conditions"><?php echo $text_conditions['1']; ?></td>
								<td class="label_sender_signature"><?php echo $label_sender_signature; ?></td>
							</tr>
							<tr>
								<td class="text_conditions"><?php echo $text_conditions['2']; ?></td>
								<td class="bottom line_w150"><div class="line line_w100" /></td>
							</tr>
							<tr>
								<td class="text_conditions" colspan="2"><?php echo $text_conditions['3']; ?></td>
							</tr>
						</table>
		</td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" width="0" height="0" border="0"><tr><td></td></tr></table>
<table class="signature"  style="page-break-inside: avoid;">
  <tr >
    <td class="line_w150 center"><?php echo $label_sender; ?></td>
    <td class="line_w150 center"><?php echo $label_courier; ?></td>
    <td class="line_w150 center"><?php echo $label_arrived; ?></td>
    <td class="line_w150 center"><?php echo $label_departure; ?></td>

  </tr>
  <tr class="line_h25">
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr style="text-align:center;">
    <td class="center"><div class="line line_w150"></div></td>
    <td class="center"><div class="line line_w150"></div></td>
    <td class="center"><div class="line line_w150"></div></td>
    <td class="center"><div class="line line_w150"></div></td>
  </tr>
  <tr>
    <td><?php echo $label_name_signature; ?></td>
    <td><?php echo $label_name_tour_signature; ?></td>
    <td><?php echo $label_date_time; ?></td>
    <td><?php echo $label_time; ?></td>
  </tr>
</table>


<script type="text/php">
   $pdf->page_text(-30, -32, "{PAGE_NUM} of {PAGE_COUNT}", Font_Metrics::get_font("serif"), 10, array(0,0,0));
   $pdf->page_text(0, 0, "sdf", Font_Metrics::get_font("dejavu serif"), 12)
</script>

	</body>
	<?php foreach ($scripts as $script) { ?>
	<script type="text/javascript" src="<?php echo $script; ?>"></script>
	<?php } ?>
</html>
