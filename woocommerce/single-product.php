<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
	?>

	
		<?php while ( have_posts() ) : the_post();
		
				woocommerce_get_template_part( 'content', 'single-product' );
		
				/*
				global $post,$product;
				$show_alt = false;
				if( $product->has_child() ) {
					$terms = get_the_terms( $post->ID, 'product_cat' );
					foreach( $terms as $k => $d ) {
						if( 'themes' == $d->slug )
							$show_alt = true;
					}
				} 
				
				if( $show_alt )
					woocommerce_get_template_part( 'content', 'single-product-pagelines' );
				else
					woocommerce_get_template_part( 'content', 'single-product' ); ?>
				*/
			
			endwhile; // end of the loop. 
		
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action('woocommerce_sidebar');
	?>

<?php get_footer('shop'); ?>