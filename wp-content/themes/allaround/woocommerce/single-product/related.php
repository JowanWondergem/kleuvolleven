<?php
/**
 * @package WordPress
 * @subpackage AllAround Theme / Wocommerce Template
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; 
global $product, $woocommerce_loop;

$related = $product->get_related();

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters('woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> $posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related,
	'post__not_in'			=> array($product->id)
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= $columns;

if ( $products->have_posts() ) : ?>
	<div class="related products products_wrapper">
		<div class="separator2 margin-bottom24"></div>
		<?php echo do_shortcode('[aa_products rows="2" pagination="no" related="yes"]'); ?>
	</div>
<?php endif;

wp_reset_postdata();
?>