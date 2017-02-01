<?php
/**
 * @package WordPress
 * @subpackage AllAround Theme / Wocommerce Template
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	global $allaround_data, $allaround_sidebar;
	
	if ( is_shop() && !is_product_category() && !is_product_tag() ) {
		if ( $allaround_sidebar['sidebarclass'] == 'no-sidebar' ) $class = 'no-sidebar';
	}
	elseif ( $allaround_data['sidebar-woocommerce'] == 0 && !is_shop() ) $class = 'no-sidebar';
	else $class = '';
	
?>
<div class="content_wrapper <?php echo $class; ?>">
<div class="content">