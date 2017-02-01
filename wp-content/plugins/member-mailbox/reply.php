<?php

 // WP Global Settings
  global $wpdb;
  $url = site_url();
  $name = get_bloginfo();
  
  // Send REPLY HTML Mail
  if(isset($_POST['mmail_reply'])) {
  if(isset($_POST['senderidreply']))
  $id = intval($_POST['senderidreply']);
  if(isset($_POST['senderreply']))
  $user = sanitize_text_field($_POST['senderreply']);
  if(isset($_POST['sendermailreply']))
  $useremail = sanitize_email($_POST['sendermailreply']);
  if(isset($_POST['mailtoreply']))
  $mailto = sanitize_text_field($_POST['mailtoreply']);
  if(isset($_POST['subjectmailreply']))
  $msubject = sanitize_text_field($_POST['subjectmailreply']);
  if(isset($_POST['templatereply']))
  $template = sanitize_text_field($_POST['templatereply']);
  global $wpdb;
  
  $midreply = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->users WHERE user_nicename='$mailto'") );
  $record =$wpdb->get_var( $wpdb->prepare("SELECT rpoid FROM {$wpdb->prefix}membermailboxrecords WHERE rfrom='$midreply' LIMIT 1"));

  $table = $wpdb->prefix . "membermailboxrecords";
  $wpdb->insert( $table, array('rpoid' => $record, 'rfrom' =>$_POST['senderidreply'] ,'rto' => $midreply, 'rsubject' => $_POST['subjectmailreply'],'rmesg' => $_POST['templatereply'], 'rstatus' => 1  ) );
 
  $getreply = "" . admin_url() . "admin.php?page=compose&reply_1_1_1=$record";

  $mail = $wpdb->get_results( $wpdb->prepare(
  "
	SELECT user_email
	FROM {$wpdb->prefix}users WHERE user_nicename='$mailto' and mail='Y'"
  ) );
  foreach ( $mail as $mail )
 {
  $mailbox = $mail->user_email;
  
  $content ='<html><head>';
$content .= "<body style='margin: 0px; background-color: '#FFF'; font-family: Helvetica, Arial, sans-serif; font-size:12px;' text='#444444' bgcolor='#FFFFFF' link='#21759B' alink='#21759B' vlink='#21759B' marginheight='0' topmargin='0' marginwidth='0' leftmargin='0'>
		<table cellpadding='0' cellspacing='0' width='600' bgcolor='#FFFFFF' border='0'>
			<tr>
				<td style='padding:15px;'>
					<center>
						<table width='550' cellpadding='0' bgcolor='#FFF' cellspacing='0' align='center'>
							<tr>
								<td align='left'>
									<div style='border:solid 1px #d9d9d9;'>
										<table id='header' width='600' border='0' cellpadding='0' bgcolor='#FFF' cellspacing='0' style='broder-top:4px solid #39C;line-height:1.6;font-size:12px;font-family: Helvetica, Arial, sans-serif;border:solid 1px #FFFFFF;color:#444;'>
											<tr>
												<td colspan='2' background='' . admin_url('images/white-grad-active.png') . '' height='30' style='color:#ffffff;' valign='bottom'>.</td>
											</tr>
											<tr>
												<td style='line-height:32px;padding-left:30px;' valign='baseline'><span style='font-size:12px;'>Dear $mailto,
												<br>
												$user has sent a reply to your message.</span></td>
								
											</tr>
										</table>
										 <table width='100%' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
                    <tr>
           <td style='padding:15px 40px;'>
         <table width='550' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
        <tr style='font-family: Helvetica, Arial, sans-serif; font-size:12px;text='#444444;'>
         <td>
  <p style='margin:0 0 30px 100px;background:#DCF0F6;padding:5px 15px 15px 5px;width:50%;text-align:center;'>
  <a href='$getreply'>View/reply to this message</a></p>
  <br><br>
  This message was intended for $mailbox.
  <br>
  <br><br>
  &copy; $name. All rights reserved.
</td></tr></table>
</td>
</tr>
</table>
									</div>
								</td>
							</tr>
						</table>
					</center>
				</td>
			</tr>
		</table>
	</body>
</html>";
  $to = "$mailbox";
  $subject = "$msubject";
  $sender = "$name" ;
  $email = "$user($useremail)";
  $headers = "From: " .$email."\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
  $sent = mail($to, $subject, $content, $headers) ;

 }

}


?>
<div class="wrap">
	<h2><?php _e('Send Reply', 'member-mailbox'); ?></h2>

<form method="post" action="" id="member-mailbox-form">
	
<?php
  $reply = htmlspecialchars($_GET["reply_1_1_1"]);
  global $wpdb;
  global $current_user;
  $id = $current_user->ID;
  $sender = $current_user->display_name;
  $sendermail = $current_user->user_email;
  echo "<input type='hidden' name='senderidreply' value='" .esc_attr($id) ."'>";
  echo "<input type='hidden' name='senderreply' value='" .esc_attr($sender) . "'>";
  echo "<input type='hidden' name='sendermailreply' value='" .esc_attr($sendermail) ."'>";
  
  $receipt =$wpdb->get_results( $wpdb->prepare("SELECT * FROM {$wpdb->prefix}membermailboxrecords WHERE rpoid='$reply' and rto='$id' ORDER BY rid DESC LIMIT 1 "));
   foreach ($receipt as $receipt){
     $to = $receipt->rto;
     $from = $receipt->rfrom;
     $message= $receipt->rmesg;
     $mesg = nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8'));
     $sub= $receipt->rsubject;
  }
  
   $getmail =$wpdb->get_var( $wpdb->prepare("SELECT user_nicename FROM {$wpdb->prefix}users WHERE ID='$from' "));
  

?>
		<input type="hidden" name="mailtoreply" value="<?php echo esc_attr($getmail);?>">
<input type="hidden" name="subjectmailreply" value="<?php echo esc_attr($sub);?>">
<input type="hidden" name="templatereply" value="<?php echo esc_attr($templatereply);?>">

		<!-- Sender options -->
		<table class="form-table" width="600">
			<tr valign="top">
			<th scope="row"><label for="wpma_subject_mail"><?php _e('To:', 'member-mailbox'); ?></label></th>
				<td><?php echo esc_attr($getmail); ?></td>
				</tr>
			<tr valign="top">
				<th scope="row"><label for="wpma_subject_mail"><?php _e('Subject', 'member-mailbox'); ?></label></th>
				<td><?php echo esc_html($sub);?></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="wpma_subject_mail"><?php echo esc_attr($getmail); ?> wrote:</label></th>
				</tr>
				<tr valign="top">
				<td colspan="2">
<!-- Message -->
		<div id="mmail_template_container" style="background:transparent;width:600px;padding:12px;"><?php echo esc_attr($mesg);?>
</div></td>
				</tr>
				</div>
		</table>

		<!-- Template -->
		<p><?php _e('Reply:', 'member_mailbox');?></p>
		<div>
			<textarea id="reply" name="templatereply" cols="68" rows="12">
                        
                         



</textarea>
	
		<p class="submit">
			<input type="submit" name="mmail_reply" class="button-primary" value="<?php _e('Send Reply', 'member-mailbox') ?>" />
		</p>
	</form>
	
	<br>

</td>
</tr>
</tbody>
</table>
