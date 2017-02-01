<?php
/**
 * @package WordPress
 * @subpackage AllAround Theme / Wocommerce Template
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; 
global $product, $woocommerce, $woocommerce_loop;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = $woocommerce->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= $columns;

if ( $products->have_posts() ) : ?>
	<div class="upsells products">
		<div class="separator2 margin-bottom24"></div>
		<?php echo do_shortcode('[aa_products rows="2" pagination="no" upsells="yes"]'); ?>
	</div>
<?php endif;

wp_reset_postdata();
?>