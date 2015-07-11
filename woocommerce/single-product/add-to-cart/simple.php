<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product;

if ( ! $product->is_purchasable() ) return;
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>

	 	<?php do_action('woocommerce_before_add_to_cart_button'); ?>

	 	<?php

    if( pl_is_club_product() ) {
      echo '<div class="sub-text"><strong class="pl-sans-bold">Free to Club Members <a href="http://www.pagelines.com/club/"><em>Signup</em></a></strong></div>';
    }



			if( $product->price > 0 )
			 		$text = sprintf( '%s - Buy Now', woocommerce_price( $product->price ) );
			 	else
			 		$text = 'Free! - Get it Now';
      ?>
      <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
      <button type="submit" class="single_add_to_cart_button btn btn-black btn-large"><?php echo $text; ?></button>
      <?php


		do_action('woocommerce_after_add_to_cart_button'); ?>

	</form>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>
