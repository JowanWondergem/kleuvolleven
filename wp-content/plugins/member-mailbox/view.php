<?php
 global $current_user;
  $id = $current_user->ID;
  $sender = $current_user->display_name;
  $sendermail = $current_user->user_email;
 global $wpdb;
  $receipt =$wpdb->get_results( $wpdb->prepare("SELECT * FROM {$wpdb->prefix}membermailboxrecords WHERE rpoid='$open' and rto='$id' ORDER BY rid DESC LIMIT 1 "));
  foreach ($receipt as $receipt){
     $to = $receipt->rto;
     $from = $receipt->rfrom;
     $mesg= $receipt->rmesg;
     $sub= $receipt->rsubject;
     $message= $receipt->rmesg;
     $mesg = nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8'));
  }
  
   $getmail =$wpdb->get_var($wpdb->prepare("SELECT user_nicename FROM {$wpdb->prefix}users WHERE ID='$from' "));

?>
  <div class="wrap">
<table width="600">
<tbody>
<tr>
<td>

		<!-- View options -->
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><label for="mmail_subject_mail"><?php _e('From:', 'member-mailbox'); ?></label></th>
				<td><?php echo esc_attr($getmail);?></td>
				</tr>
			<tr valign="top">
				<th scope="row"><label for="mmail_subject_mail"><?php _e('Subject', 'member-mailbox'); ?></label></th>
				<td><?php echo esc_attr($sub);?></td>
</tr>
<tr valign="top">
<th scope="row"><label for="mmail_subject_mail"><?php _e('Message', 'member-mailbox'); ?></label></th>
<td></td>
		</table>

		<!-- Message -->
		<div id="mmail_template_container" style="background:#FFF;width:600px;padding:12px;">
			<?php echo esc_attr($mesg);?>
<br><br><br>
<?php echo "<a href='" . admin_url() . "admin.php?page=compose&reply_1_1_1=$open' class='button-primary'>" . "Send Reply" . "</a>"; ?>
		</div>
		
	<br>

</td>
</tr>
</tbody>
</table>
<br>
<br>
<br>
	<!-- Support -->
	<div id="mmail_support">
		<h3><?php _e('Support & bug report', 'member-mailbox'); ?></h3>
		<p><?php printf(__('If you have any idea to improve this plugin or any bug to report, please email me at : <a href="%1$s">%2$s</a>', 'member-mailbox'), 'mailto:membermailbox@cbfreeman.com?subject=[member-mailbox]', 'membermailbox@cbfreeman.com'); ?></p>
		
	</div>
</div>