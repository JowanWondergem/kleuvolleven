<?php
if ( !defined('WP_UNINSTALL_PLUGIN') ) {
    exit();
}
delete_option('mmail_options');
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}membermailboxrecords");
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}membermailbox");

?>
