<div class="wrap">
	<h2><?php _e('Inbox', 'member_mailbox'); ?>&nbsp;&nbsp;<a href="<?php echo esc_attr(admin_url()); ?>admin.php?page=compose">(<?php _e('New Message', 'member_mailbox');?>)</a></h2>
<?php

if(isset($_GET)){
if(isset($_GET["view_1_1_1"]))
$open = htmlspecialchars($_GET["view_1_1_1"]);
if(isset($_GET["delete_1_1_1"]))
$delete = htmlspecialchars($_GET["delete_1_1_1"]);

}


if(!empty($delete)){
global $wpdb;
$wpdb->query( $wpdb->prepare(
	"UPDATE {$wpdb->prefix}membermailboxrecords SET rstatus ='4' WHERE rpoid ='$delete'") );
}

if (!empty($open)){

include("view.php");

}else{ ?>
<?php
  global $wpdb;
  global $current_user;
  $id = $current_user->ID;
  $mailcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*)
	FROM {$wpdb->prefix}membermailboxrecords WHERE rto='$id' and rstatus='1'") );
?>
<h4><?php _e('All Mail','member_mailbox');?></h4>
Maximum inbox messages:25
<br>
Current inbox messages:(<?php echo esc_attr($mailcount);?>)
<br>
<br>
		<table class="wp-list-table widefat fixed media">
	<thead>
	<tr>
		<th scope="col" id="cb" class="manage-column">
		<label>From</label></th>
			<th scope="col" id="cb" class="manage-column">
		<label>Date</label></th>
			<th scope="col" id="cb" class="manage-column">
	<label>Subject</label></th>
			<th scope="col" id="cb" class="manage-column">
		<label>Actions</label></th>
		</tr>
	</thead>
	<tbody id="the-list">
	<?php
      global $wpdb;
      global $current_user;
      $id = $current_user->ID;
      $sender = $current_user->display_name;

     $mail = $wpdb->get_results( $wpdb->prepare(
  "
	SELECT c.rid,c.rsubject,c.rdate,c.rpoid,c.rfrom,c.rto,c.rstatus,d.ID,d.user_nicename
	FROM {$wpdb->prefix}membermailboxrecords c, {$wpdb->prefix}users d WHERE d.ID=c.rfrom and c.rto='$id' and c.rstatus='1' LIMIT 25"
  ) );
  foreach ( $mail as $mail )
 {
  $author = $mail->user_nicename;
  $remove = $mail->rid;
  $rid = $mail->rfrom;
  $link = $mail->rpoid;
  $rsubject = $mail->rsubject;
  $rdate = $mail->rdate;
		echo "<tr class='alternate'>";
		echo "<td class='author'>" . "<a href='" . admin_url() . "admin.php?page=compose&reply_1_1_1=$link' class='edit'>" . $author . "</a></td>";
		echo "<td class='author'>" . $rdate . "</td>";
		echo "<td class='author'>"  .$rsubject. "</td>";
		echo "<td class='author'>" . "<a href='" . admin_url() . "admin.php?page=compose&reply_1_1_1=$link' class='edit'>" . "reply" . "</a>" . $nbsp . "|" . "<a href='" . admin_url() . "admin.php?page=mmail_options&view_1_1_1=$link' class='edit'>" . "view" . "</a>" . $nbsp . "|" . "<a href='" . admin_url() . "admin.php?page=mmail_options&delete_1_1_1=$link' class='delete'>" . "delete" . "</a></td>";

		echo "</tr>";

}
		?>
		
	</tbody>
</table>

<?php } ?>

</div>
