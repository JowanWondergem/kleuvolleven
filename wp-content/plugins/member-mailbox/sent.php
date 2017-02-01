<div class="wrap">
	<h2><?php _e('Sent', 'member_mailbox'); ?></h2>
<?php

if(isset($_GET)){
if(isset($_GET["view_1_1_1"]))
$open= htmlspecialchars($_GET["view_1_1_1"]);
}

if (!empty($open)){

include("view.php");

}else{ ?>

<h4><?php _e('All Sent Mail', 'member_mailbox');?> (Limit 25)</h4>
		<table class="wp-list-table widefat fixed media">
	<thead>
	<tr>
		<th scope="col" id="cb" class="manage-column">
		<label>To</label></th>
			<th scope="col" id="cb" class="manage-column">
		<label>Date</label></th>
			<th scope="col" id="cb" class="manage-column">
	<label>Subject</label></th>
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
	FROM {$wpdb->prefix}membermailboxrecords c, {$wpdb->prefix}users d WHERE d.ID=c.rto and c.rfrom='$id' and c.rstatus='1' LIMIT 25"
  ));
  foreach ( $mail as $mail )
 {
  $author = $mail->user_nicename;
  $rid = $mail->rto;
  $link = $mail->rpoid;
  $rsubject = $mail->rsubject;
  $rdate = $mail->rdate;
		echo "<tr class='alternate'>";
		echo "<td class='author'>" . $author . "</td>";
		echo "<td class='author'>" . $rdate . "</td>";
		echo "<td class='author'>"  .$rsubject. "</td>";
		echo "</tr>";

}
		?>
		
	</tbody>
</table>

<?php } ?>

</div>
