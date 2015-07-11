<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
	
	$class = ( is_pagelines_membership() ) ? 'pl-membership' : '';
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
	
	<div class="product-summary row fix">
		<div class="entry-summary span4">
			<div class="entry-summary-pad">
			<?php
					/**
					 * woocommerce_single_product_summary hook
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
				do_action( 'woocommerce_single_product_summary' );
			?>
			</div>
		</div><!-- .summary -->
	
		<div class="span8 single-product-images">
		<?php
			/**
			 * woocommerce_show_product_images hook
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
		?>
		</div>
	</div>
	
	<?php if( ! is_pagelines_membership() ) : ?>
	<div class="pl-product-information row fix">
		<div class="span8 pl-product-desc">
			
			<?php
				
			 	the_content(); 
				?>
		</div>
		<div class="span4 pl-product-meta">
			<h3>Images</h3>
			<?php
				do_action( 'woocommerce_product_thumbnails' );
			
			?>

			<h3>Author</h3>
			<?php 
				ob_start();
					the_author_meta('url');
				$link = ob_get_clean();
			
				printf('<a href="%s" target="_blank">%s</a>', $link, get_the_author() ); 
			?>
			
			<h3>Tags</h3>
			<?php 
			global $product; 
			echo $product->get_tags();
			
			?>
		
			<h3>Support</h3>
			<p>
				Need help? Please be sure to search the <a href="http://forum.pagelines.com/">forum</a>. If you're still stuck you can <a href="http://www.pagelines.com/contact">contact</a> support.
			</p>
			
			<h3>Created On</h3>
			<p><?php the_date(get_option('date_format')); ?></p>
	
			<h3>Last updated</h3>
			<p><?php the_modified_date(get_option('date_format')); ?></p>
		</div>
	</div>
	
	<?php endif; ?>
	
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	
</div><!-- #product-<?php the_ID(); ?> -->


		<?php do_action( 'woocommerce_after_single_product' ); ?>
