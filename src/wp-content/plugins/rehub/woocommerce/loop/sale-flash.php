<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_featured() ) : ?>
        <?php echo apply_filters( 'woocommerce_featured_flash', '<span class="onfeatured">' . esc_html__( 'Featured!', 'woocommerce' ) . '</span>', $post, $product ); ?>
<?php endif; ?>        
<?php if ( $product->is_on_sale() ) : ?>
    <?php 
    $percentage=0;
    $featured = ($product->is_featured()) ? ' onsalefeatured' : '';
    if ($product->regular_price) {
        $percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
    }
    if ($percentage) {
        $sales_html = '<span class="onsale'.$featured.'"><span>- ' . $percentage . '%</span></span>';
    } else {
        $sales_html = apply_filters( 'woocommerce_sale_flash', '<span class="onsale'.$featured.'">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );
    }
    ?>
    <?php echo $sales_html; ?>
<?php endif; ?>