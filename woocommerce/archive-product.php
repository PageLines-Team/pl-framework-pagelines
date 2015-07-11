<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	get_header('shop');

		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');

		do_action( 'woocommerce_archive_description' );

		?>


		<?php
		if( shortcode_exists( 'woocommerce_product_search' ) )
			echo do_shortcode('[woocommerce_product_search]');
		?>

		<?php if( ! is_search() && ! is_author() ) : ?>
		<?php
		// get nav links...

		$prod_cat = get_term_by( 'slug', 'pl-extensions', 'product_cat' );
		$pl_ext_link = get_term_link( $prod_cat, 'product_cat' );

		$prod_cat = get_term_by( 'slug', 'third-party-extensions', 'product_cat' );
		$third_party_link = get_term_link( $prod_cat, 'product_cat' );

		$store = get_permalink( woocommerce_get_page_id( 'shop' ) );

		// work out active states...
		$pl_ext_tab = '';
		$pl_themes_tab = '';
		$pl_party_tab = '';

		if( is_shop() ) {
			$pl_themes_tab = 'active';
		}

		if( is_product_category( 'third-party-extensions') ) {
			$pl_party_tab = 'active';
		}

		if( is_product_category( 'pl-extensions') ) {
			$pl_ext_tab = 'active';
		}

		?>
		<div class="store-content-wrapper">


		<div class="picasso-tabs-content">
			<?php if( !is_search() && is_product_category( 'pl-extensions' ) && ! is_author() && ! isset($_GET['orderby']) ) : ?>
				<?php
				global $wp_query;
				$paged = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;
				$old_query = $wp_query;
				$the_query = array(
					'posts_per_page' 	=> 24,
					'post_type' 		=> 'product',
					'product_cat' 	=> 'pl-extensions',
					'paged'					=> $paged
				);
				add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
				$the_query['meta_query'] = WC()->query->get_meta_query();

				$wp_query = new WP_Query( $the_query );

				?>
		   	<div id="pl-extensions-tab">

		   	<?php shop_pl_extensions(); ?>
				<?php do_action( 'woocommerce_after_shop_loop' ); ?>
				<?php
				remove_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
				$wp_query = $old_query;
				?>
		   	</div><!-- End .pl-extensions -->

			<?php elseif( !is_search() && is_shop() && ! is_author() && ! isset($_GET['orderby']) ) : ?>

				<div id="pl-themes-tab">

					<?php shop_pl_themes(); ?>
					<?php // do_action( 'woocommerce_after_shop_loop' ); ?>
				</div><!-- End .pl-themes -->

			<?php elseif( !is_search() && is_product_category() && ! is_author()  && ! isset($_GET['orderby']) ) : ?>
				<div id="other-extensions-tab">

					<?php shop_3rd_party_extensions();  ?>
					<?php do_action( 'woocommerce_after_shop_loop' ); ?>
				</div><!-- End .other-extensions -->

			<?php endif; ?>
		</div>
	</div>

<?php endif; ?>

<?php // show author/search results.. ?>
		<div class="store-content-wrapper">
			<div id="other-extensions-tab">
		<?php if( is_author() && ! is_search() ) : ?>

			<?php
			global $wp_query;
			$author = get_query_var('author');
			$old_query = $wp_query;
			$the_query = array(
				'posts_per_page' 	=> -1,
				'post_type' 		=> 'product',
				'author' 	=> $author,
			);

			add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
			$the_query['meta_query'] = WC()->query->get_meta_query();

			$wp_query = new WP_Query( $the_query ); ?>


			<?php shop_author_archive(); ?>

			<?php do_action( 'woocommerce_after_shop_loop' ); ?>
			<?php
			remove_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
			$wp_query = $old_query; ?>
			</div><!-- End .other-extensions -->
		<?php endif; ?>
		</div>

<?php
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
