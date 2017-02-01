<?php
/**
 * @package WordPress
 * @subpackage AllAround Theme / Wocommerce Template
 * @author Shindiri Studio (http://www.shindiristudio.com) & http://www.mihajlovicnenad.com/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $post, $product;
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	<p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p>
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>