<div class="wrap">
	<h2><?php _e('Notification Settings', 'member_mailbox'); ?></h2>
<?php

if(isset($_POST['mmail_notification'])){
if(isset($_POST['mmail_notify']))
$notify = sanitize_text_field($_POST['mmail_notify']);
global $wpdb;
global $current_user;
$id = $current_user->ID;
$wpdb->query( $wpdb->prepare(
	"UPDATE {$wpdb->prefix}users SET mail='$notify' WHERE ID='$id' LIMIT 1 ") );
}

?>


<br>
<form  name="mmail-notify-form" action="" method="post">
<tr>
<td><h4><?php _e('Receive an email notifing you of new messages?','member_mailbox');?></h4></td>
<td>
<select name="mmail_notify">
<option value="Y">yes</option>
<option value="N">no</option>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="mmail_notification" id="submit" class="button-primary" value="Save Changes">
</td>
</tr>
</tbody>
</table>
</form>


</div>
