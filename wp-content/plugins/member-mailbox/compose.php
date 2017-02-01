<?php

if(isset($_GET)){
if(isset($_GET["reply_1_1_1"]))
$reply = htmlspecialcharS($_GET["reply_1_1_1"]);
}

if(!empty($reply)){
  
  include('reply.php');
}else { ?>

  <div class="wrap">
	<h2><?php _e('Inbox', 'member_mailbox'); ?></h2>
<table width="600">
<tbody>
<tr>
<td>
	<form method="post" action="" id="member-mailbox-form">
		<?php settings_fields('mmail_full_options'); ?>
<?php
global $current_user;
  $id = $current_user->ID;
  $sender = $current_user->display_name;
  $sendermail = $current_user->user_email;
  echo "<input type='hidden' name='senderid' value='" . esc_attr($id) . "'>";
  echo "<input type='hidden' name='sender' value='" . esc_attr($sender) . "'>";
  echo "<input type='hidden' name='sendermail' value='" .esc_attr($sendermail) . "'>";
 
?>
		<input type="hidden" name="mailto" value="<?php echo esc_attr($mailto);?>">
<input type="hidden" name="subject_mail" value="<?php echo esc_attr($subject_mail);?>">
<input type="hidden" name="template" value="<?php echo esc_attr($template);?>">

		<!-- Sender options -->
		<table class="form-table">
			<tr valign="top">
			<th scope="row"><label for="mmail_subject_mail"><?php _e('To:', 'member_mailbox'); ?>(username)</label></th>
				<td><input type="text" id="mmail_mail_to" class="regular-text" name="mailto" value="" placeholder="Type username here." />
				<br>
				Required. Enter username.(Ex.johndoe)</td>
				</tr>
			<tr valign="top">
				<th scope="row"><label for="mmail_subject_mail"><?php _e('Subject', 'member_mailbox'); ?></label></th>
				<td><input type="text" id="mmail_subject_mail" class="regular-text" name="subject_mail" value="" />
				<br>
				Required</td>
		</table>

		<!-- Template -->
		<p><?php _e('Content','member_mailbox');?></p>
		<div id="mmail_template_container" style="width:600px;">
			<textarea id="mmail_template" class="mmail_template" name="template" cols="80" rows="10"></textarea>
		</div>
		<p class="submit">
			
			<input type="submit" name="member_mailbox" class="button-primary" value="<?php _e('Send Mail', 'member_mailbox') ?>" />
		</p>
	</form>
	
	<br>

</td>
</tr>
</tbody>
</table>
<?php } ?>
	<!-- Support -->
	<div id="mmail_support">
		<h3><?php _e('Support & bug report', 'member_mailbox'); ?></h3>
		<p><?php printf(__('If you have any idea to improve this plugin or any bug to report, please email me at : <a href="%1$s">%2$s</a>', 'member_mailbox'), 'mailto:membermailbox@cbfreeman.com?subject=[CbFreeman Mail - Regarding Member Mailbox]', 'membermailbox@cbfreeman.com'); ?></p>
		<?php $donation_link = 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BAZNKCE6Q78PJ'; ?>
		<p><?php printf(__('You like this plugin ? You use it in a business context ? Please, consider a <a href="%s" target="_blank" rel="external">donation</a>.', 'member_mailbox'), $donation_link ); ?></p>
		
	</div>
</div>