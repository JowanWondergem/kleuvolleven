<?php
/*
Plugin Name: Member Mailbox
Plugin URI: http://cbfreeman.com/downloads/member-mailbox/
Description: An internal email(messaging/inbox) solution that sends real mail.
Version: 2.1
Author: cbfreeman
Author URI: http://cbfreeman.com
License: GPLv2
 */

/*
  Copyright (c) 2014 Craig Freeman (email :ceo@cbfreeman.com)

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 3
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


  /**
  * Add Global WP
  *
  * create mail table
  * get general settings
  * mailform
  * unsubscribe message & link
  */
  global $wpdb, $wp_version;
  define("MEMBER_MAILBOX_USERS_TABLE", $wpdb->prefix . "users");
  define("MEMBER_MAILBOX_TABLE", $wpdb->prefix . "membermailbox");
  define("MEMBER_MAILBOX_RECORDS_TABLE", $wpdb->prefix . "membermailboxrecords");
  
  function mail_install()
{
    global $wpdb, $wp_version;
    
   
    $wpdb->query("
            ALTER TABLE `". MEMBER_MAILBOX_USERS_TABLE . "`
              ADD COLUMN `mail` char(3) NOT NULL default 'Y'
            ");
    
     if(strtoupper($wpdb->get_var( $wpdb->prepare("show tables like '". MEMBER_MAILBOX_TABLE . "'"))) != strtoupper(MEMBER_MAILBOX_TABLE))
    {
        $wpdb->query("
            CREATE TABLE IF NOT EXISTS `". MEMBER_MAILBOX_TABLE . "` (
              `id` int(11) NOT NULL auto_increment,
              `poid` char(250) NOT NULL ,
              `pfrom` char(250) NOT NULL ,
              `pto` char(250) NOT NULL default '',
              `psubject` char(250) NOT NULL default '',
              `pmesg` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
              `pstatus` char(3) NOT NULL default '1',
              `pdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              UNIQUE KEY  (`id`) )
            ");
        
       
    if(strtoupper($wpdb->get_var( $wpdb->prepare("show tables like '". MEMBER_MAILBOX_RECORDS_TABLE . "'"))) != strtoupper(MEMBER_MAILBOX_RECORDS_TABLE))
    {
        $wpdb->query("
            CREATE TABLE `". MEMBER_MAILBOX_RECORDS_TABLE . "` (
              `rid` int(11) NOT NULL auto_increment,
              `rpoid` int(11) NOT NULL,
              `rfrom` char(250) NOT NULL ,
              `rto` char(250) NOT NULL ,
              `rsubject` char(250) NOT NULL default '',
              `rmesg` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
              `rstatus` char(3) NOT NULL default '',
              `rdate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
              UNIQUE KEY  (`rid`) )
            ");
            
    }
  
}

}

           
  // WP Global Settings
  $url = site_url();
  $name = get_bloginfo();
  
  // Send HTML Mail
  if(isset($_POST['member_mailbox'])) {
  if(isset($_POST['senderid']))
  $id = sanitize_text_field($_POST['senderid']);
  if(isset($_POST['sender']))
  $user = sanitize_text_field($_POST['sender']);
  if(isset($_POST['sendermail']))
  $useremail = strtolower($_POST['sendermail']);
  if(isset($_POST['mailto']))
  $mailto = sanitize_text_field($_POST['mailto']);
  if(isset($_POST['subject_mail']))
  $msubject = sanitize_title($_POST['subject_mail']);
  if(isset($_POST['template']))
  $mesg = sanitize_text_field($_POST['template']);
  $template = nl2br(htmlentities($mesg, ENT_QUOTES, 'UTF-8'));
  global $wpdb;
  $list = mt_rand();
  $mid = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->users WHERE user_nicename='$mailto'") );
  
  $table_name = $wpdb->prefix . "membermailbox";
  $wpdb->insert( $table_name, array( 'poid' => $list,'pfrom' =>$_POST['senderid'] ,'pto' => $mid, 'psubject' => $_POST['subject_mail'],'pmesg' => $_POST['template'], 'pstatus' => 1  ) );
  
  $table_name2 = $wpdb->prefix . "membermailboxrecords";
  $wpdb->insert( $table_name2, array( 'rpoid' =>$list,'rfrom' =>$_POST['senderid'] ,'rto' => $mid, 'rsubject' => $_POST['subject_mail'],'rmesg' => $_POST['template'], 'rstatus' => 1  ) );
  
  
  $reply = "" . admin_url() . "admin.php?page=compose&reply_1_1_1=$list";

 

  $mail = $wpdb->get_results( $wpdb->prepare(
  "
	SELECT user_email
	FROM {$wpdb->prefix}users WHERE user_nicename='$mailto' and mail='Y'"
  ) );
  foreach ( $mail as $mail )
 {
  $mailbox = $mail->user_email;
 
  $content ='<html><head>';
$content .= "<body style='margin: 0px; background-color: '#F4F3F4'; font-family: Helvetica, Arial, sans-serif; font-size:12px;' text='#444444' bgcolor='#FFFFFF' link='#21759B' alink='#21759B' vlink='#21759B' marginheight='0' topmargin='0' marginwidth='0' leftmargin='0'>
		<table cellpadding='0' cellspacing='0' width='600' bgcolor='#FFFFFF' border='0'>
			<tr>
				<td style='padding:15px;'>
					<center>
						<table width='550' cellpadding='0' bgcolor='#FFFFFF' cellspacing='0' align='center'>
							<tr>
								<td align='left'>
									<div style='border:solid 1px #d9d9d9;'>
										<table id='header' width='600' border='0' cellpadding='0' bgcolor='#ffffff' cellspacing='0' style='broder-top:4px solid #39C;line-height:1.6;font-size:12px;font-family: Helvetica, Arial, sans-serif;border:solid 1px #FFFFFF;color:#444;'>
											<tr>
												<td colspan='2' background='' . admin_url('images/white-grad-active.png') . '' height='30' style='color:#ffffff;' valign='bottom'>.</td>
											</tr>
											<tr>
												<td style='line-height:32px;padding-left:30px;' valign='baseline'><span style='font-size:32px;'>$name</span></td>
								
											</tr>
											<tr>
												<td style='line-height:32px;padding-left:30px;' valign='baseline'><span style='font-size:12px;'>Dear $mailto,
												<br>
												$user has sent you a new message.</span></td>
								
											</tr>
										</table>
										 <table width='100%' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
                    <tr>
           <td style='padding:15px 40px;'>
         <table width='550' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
        <tr style='font-family: Helvetica, Arial, sans-serif; font-size:12px;text='#444444;'>
         <td>
  <p style='margin:0 0 30px 100px;background:#DCF0F6;padding:5px 15px 15px 5px;width:50%;text-align:center;'>
  <a href='$reply'>View/reply to this message</a></p>
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


   
   //Start
  if ( ! class_exists( 'Member_Mailbox' ) ) {

	if ( ! defined( 'MMAIL_JS_URL' ) )
		define( 'MMAIL_JS_URL', plugin_dir_url( __FILE__ ) . 'js' );

	if ( ! defined( 'MMAIL_CSS_URL' ) )
		define( 'MMAIL_CSS_URL', plugin_dir_url( __FILE__ ) . 'css' );
		
		class member_mailbox {

		var $options = array();
		var $page = '';

		/**
		 * Construct function
		 *
		 * @since 0.2
		 */
		function __construct() {
			global $wp_version;

			$this->get_options();
			

			if ( ! is_admin() )
				return;

			// Load translations
			load_plugin_textdomain( 'member_mailbox', null, basename( dirname( __FILE__ ) ) . '/langs/' );

			// Actions
			add_action( 'admin_init',           array( $this, 'init' ) );
			add_action( 'admin_menu',           array( $this, 'admin_menu' ) );
                        
	
			if ( version_compare( $wp_version, '3.2.1', '<=' ) )
				add_action( 'admin_head', array( $this, 'load_wp_tiny_mce' ) );

			if ( version_compare( $wp_version, '3.2', '<' ) && version_compare( $wp_version, '3.0.6', '>' ) )
				add_action( 'admin_print_footer_scripts', 'wp_tiny_mce_preload_dialogs' );

			// Filters
			add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'settings_link' ) );
			register_activation_hook(__FILE__, 'mail_install');

		}
		

		/**
		 * Get recorded options
		 *
		 * @since 0.2
		 */
		function get_options() {
			$this->options = get_option( 'mmail_options' );
		}


		/**
		 * Init plugin options to white list our options & register our script
		 *
		 * @since 0.1
		 */
		function init() {
			register_setting( 'mmail_full_options', 'mmail_options', array( $this, 'validate_options' ) );
			wp_register_script( 'mmail-admin-script', MMAIL_JS_URL . '/mmail-admin-script.js', array( 'jquery', 'thickbox' ), null, true );
			wp_register_style( 'mmail-admin-style', MMAIL_CSS_URL . '/mmail-admin-style.css' );
		}


                  /**
		 * Register main page styles
		 *
		 * @since 0.1
		 *
		 */
		 
   	
		/**
		 * Settings link in the plugins page
		 *
		 * @since 0.1
		 *
		 * @param array   $links Plugin links
		 * @return array Plugins links with settings added
		 */
		function settings_link( $links ) {
			$links[] = '<a href="options-general.php?page=mmail_options">' . __( 'Settings', 'member_mailbox' ) . '</a>';

			return $links;
		}
		

		

		/**
		 * Record options on plugin activation
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		function install() {
			global $wp_version;
			// Prevent activation if requirements are not met
			// WP 2.8 required
			if ( version_compare( $wp_version, '3.0', '<=' ) ) {
				deactivate_plugins( __FILE__ );

				wp_die( __( 'Member Mailbox requires WordPress 3.0 or newer.', 'member_mailbox' ), __( 'Upgrade your Wordpress installation.', 'member_mailbox' ) );
			}

			
		}

		/**
		 * Option page to the built-in settings menu
		 *
		 * @since 0.1
		 */
		 
		function admin_menu() {
				$this->page = add_menu_page( __( 'Inbox', 'member_mailbox' ), __( 'Mailbox', 'member_mailbox' ), 'read', 'mmail_options',       array( $this, 'admin_page' ), '', plugins_url( 'member-mailbox/mailbox.png' ),6);
    	
    	// Add a submenu to the Member Mailbox menu:
    add_submenu_page('mmail_options', __( 'mmail', 'member_mailbox' ), __( 'New Messages', 'member_mailbox' ), 'read', 'compose', array($this, 'compose_page'));
    
    // Add a submenu to the Member Mailbox menu:
    add_submenu_page('mmail_options', __( 'mmail', 'member_mailbox' ), __( 'Sent Messages', 'member_mailbox' ), 'read', 'sent', array($this, 'sent_page'));
    
     	// Add a submenu to the Member Mailbox menu:
    add_submenu_page('mmail_options', __( 'mmail', 'member_mailbox' ), __( 'Archive Messages', 'member_mailbox' ), 'read', 'archive', array($this, 'archive_page'));
    
    // Add a submenu to the Member Mailbox menu:
    add_submenu_page('mmail_options', __( 'mmail', 'member_mailbox' ), __( 'Trash', 'member_mailbox' ), 'read', 'trash', array($this, 'trash_page'));
    
    
    // Add a submenu to the Member Mailbox menu:
    add_submenu_page('mmail_options', __( 'mmail', 'member_mailbox' ), __( 'Notifications', 'member_mailbox' ), 'read', 'notify', array($this, 'notify_page'));
 
			
			add_action( 'admin_print_styles-' . $this->page, array( $this, 'admin_print_style' ) );
		}


		/**
		 * Check if we're on the plugin page
		 *
		 * @since 0.2
		 * @global type $page_hook
		 * @return type
		 */
		function is_mmail_page() {
			global $page_hook;

			if ( $page_hook === $this->page )
				return true;

			return false;
		}


		/**
		 * Enqueue the style to display it on the compose page
		 *
		 * @since 0.1
		 */
		function admin_print_style() {
			wp_enqueue_style( 'mmail-admin-style' );
			wp_enqueue_style( 'thickbox' );
		}

		/**
		 * Include admin options page
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		function admin_page() {
			global $wp_version;

			require 'mmail-options.php';
		}

     /**
		 * Include compose page
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		function compose_page() {
			global $wp_version;

			require 'compose.php';
		}

     /**
		 * Include sent page
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		function sent_page() {
			global $wp_version;

			require 'sent.php';
		}
		
		 /*
		 * Include archive page
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		function archive_page() {
			global $wp_version;

			require 'archive.php';
		}
		
		 /**
		 * Include trash page
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		function trash_page() {
			global $wp_version;

			require 'trash.php';
		}
		
		
		/**
		 * Include notification page
		 *
		 * @since 0.1
		 * @global $wp_version
		 */
		function notify_page() {
			global $wp_version;

			require 'notify.php';
		}
		
		
		/**
		 * Sanitize each option value
		 *
		 * @since 0.1
		 * @param array   $input The options returned by the options page
		 * @return array $input Sanitized values
		 */
		function validate_options( $input ) {

			$subject_email = strtolower( $input['subject_email'] );
				$input['subject_email'] = esc_html( $input['subject_email'] );

			return $input;
		}

	

		/**
		 * Always set content type to HTML
		 *
		 * @since 0.1
		 * @param string $content_type
		 * @return string $content_type
		 */
		function set_content_type( $content_type ) {
			// Only convert if the message is text/plain and the template is ok
			if ( $content_type == 'text/plain' && $this->check_template() === true ) {
				$this->send_as_html = true;
				return $content_type = 'text/html';
			} else {
				$this->send_as_html = false;
			}
			return $content_type;
		}


		/**
		 * Process the HTML version of the message
		 *
		 * @since 0.2.7
		 * @param string $content
		 * @return string
		 */
		function process_email_html( $content ) {

			// Clean < and > around text links in WP 3.1
			$content = $this->esc_textlinks( $content );

			// Convert line breaks & make links clickable
			$content = nl2br( make_clickable( $content ) );

			// Replace variables in email
			$content = apply_filters( 'mmail_html_body', $this->template_vars_replacement( $content ) );

			return $content;

		}

		/**
		 * Replaces the < & > of the 3.1 email text links
		 *
		 * @since 0.1.2
		 * @param string $body
		 * @return string
		 */
		function esc_textlinks( $body ) {
			return preg_replace( '#<(https?://[^*]+)>#', '$1', $body );
		}

		
		}

	}


if ( class_exists( 'Member_Mailbox' ) ) {
	$member_mailbox = new member_mailbox();
	register_activation_hook( __FILE__, array( $member_mailbox, 'install' ) );
}