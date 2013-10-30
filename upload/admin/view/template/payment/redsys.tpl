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
	<div class="left"></div>
	<div class="right"></div>
	<div class="heading">
		<h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
		<div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
	</div>
	<div class="content">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		  <div id="tab_general" class="page">
			<table class="form">
			  <tr>
				<td width="25%"><span class="required">*</span> <?php echo $entry_merchantCode; ?></td>
				<td><input type="text" name="redsys_merchantCode" value="<?php echo $redsys_merchantCode; ?>" size="15" /></td>
			  </tr>
			  <tr>
				<td width="25%"><span class="required">*</span><?php echo $entry_terminal; ?></td>
				<td><input type="text" name="redsys_terminal" value="<?php echo $redsys_terminal; ?>" size="3" /></td>
			  </tr>
			  <tr>
				<td width="25%"><span class="required">*</span><?php echo $entry_password; ?></td>
				<td><input type="text" name="redsys_password" value="<?php echo $redsys_password; ?>" size="21" /></td>
			  </tr>
			 <tr>
				<td><?php echo $entry_test; ?></td>
				<td><select name="redsys_test">
					<?php if ($redsys_test) { ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php } else { ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				  </select></td>
			  </tr>
			  <tr>
				<td><?php echo $entry_process_failed; ?></td>
				<td><select name="redsys_process_failed">
					<?php if ($redsys_process_failed) { ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php } else { ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				  </select></td>
			  </tr>
			  <tr>
				<td><?php echo $entry_completed_status; ?></td>
				<td><select name="redsys_completed_status_id">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $redsys_completed_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select></td>
			  </tr>
			  <tr id="failed_status">
				<td><?php echo $entry_failed_status; ?></td>
				<td><select name="redsys_failed_status_id">
					<?php foreach ($order_statuses as $order_status) { ?>
					<?php if ($order_status['order_status_id'] == $redsys_failed_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select></td>
			  </tr>
			  <tr id="mail_customer">
				<td><?php echo $entry_send_mail_to_cutomer; ?></td>
				<td><select name="redsys_send_mail_to_cutomer">
					<?php if ($redsys_send_mail_to_cutomer) { ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php } else { ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				  </select></td>
			  </tr>
			  <tr id="mail_store_owner">
				<td><?php echo $entry_send_mail_to_store_owner; ?></td>
				<td><select name="redsys_send_mail_to_store_owner">
					<?php if ($redsys_send_mail_to_store_owner) { ?>
					<option value="0"><?php echo $text_no; ?></option>
					<option value="1" selected="selected"><?php echo $text_yes; ?></option>
					<?php } else { ?>
					<option value="0" selected="selected"><?php echo $text_no; ?></option>
					<option value="1"><?php echo $text_yes; ?></option>
					<?php } ?>
				  </select></td>
			  </tr>
			  <tr>
				<td><?php echo $entry_geo_zone; ?></td>
				<td><select name="redsys_geo_zone_id">
					<option value="0"><?php echo $text_all_zones; ?></option>
					<?php foreach ($geo_zones as $geo_zone) { ?>
					<?php if ($geo_zone['geo_zone_id'] == $redsys_geo_zone_id) { ?>
					<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
					<?php } ?>
					<?php } ?>
				  </select></td>
			  </tr>
			  <tr>
				<td><?php echo $entry_status; ?></td>
				<td><select name="redsys_status">
					<?php if ($redsys_status) { ?>
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
				<td><input type="text" name="redsys_sort_order" value="<?php echo $redsys_sort_order; ?>" size="1" /></td>
			  </tr>
			</table>
		  </div>
		</form>
	</div>
</div>
<?php echo $footer; ?>