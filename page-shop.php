<?php
/*
 * Template Name: PageLines Shop
 * Description: It's only the shop
 */


$opts = array(
	array(
		'key'		=> 'header_text',
		'col'		=> 1,
		'type'		=> 'text',
		'title'		=> __( 'Example', 'pagelines' ),
		'label'		=>	__( '...', 'pagelines' ),
	),
);

pl_add_template_settings( $opts );

$header = array(

	'header' 	=> 'Themes &amp; Extensions',
	'theme'		=> 'pl-scheme-dark',
	'alignment' => 'pl-alignment-left'

);

$featured_banner_media = array(

	'col'				=> '6',	
	'post_cols'			=> '12',
	'post_type'			=> 'product',
	'posts_total' 		=> '1',
	'post_sort'			=> 'random',
	'posts_meta_key'	=> '_featured',
	'posts_meta_value'	=> 'yes'

);

$featured_hero_banner = array(

	'post_type'			=> 'product',
	'post_sort'			=> 'rand',
	'post_meta_key'		=> '_featured',
	'post_meta_value'	=> 'yes'
	
);

$featured_posts_head = array(

	'format'				=> 'callout',
	'header' 				=> '',
	'subheader'				=> 'Featured',
	'button_primary'		=> '#',
	'button_primary_text'	=> 'View All <i class="icon icon-chevron-right"></i>',
	'button_primary_style'	=> 'link',

);

$featured_posts = array(

	'post_cols'			=> '4',
	'post_type'			=> 'product',
	'posts_total' 		=> '6',
	'post_sort'			=> 'rand',
	'posts_meta_key'	=> '_featured',
	'posts_meta_value'	=> 'yes'

);

$rated_posts_head = array(

	'format'				=> 'callout',
	'header' 				=> '',
	'subheader'				=> 'Top Rated',
	'button_primary'		=> '#',
	'button_primary_text'	=> 'View All <i class="icon icon-chevron-right"></i>',
	'button_primary_style'	=> 'link',

);

$rated_posts = array(

	'post_cols'			=> '4',
	'post_type'			=> 'product',
	'posts_total' 		=> '6',
	'post_sort'			=> 'rating'

);

$latest_posts_head = array(

	'format'				=> 'callout',
	'header' 				=> '',
	'subheader'				=> 'Latest',
	'button_primary'		=> '#',
	'button_primary_text'	=> 'View All <i class="icon icon-chevron-right"></i>',
	'button_primary_style'	=> 'link',

);

$latest_posts = array(

	'post_cols'			=> '4',
	'post_type'			=> 'product',
	'posts_total' 		=> '6',

);

$more_products = array(

	'format'				=> 'masthead',
	'header' 				=> '',
	'button_primary'		=> '#',
	'button_primary_text'	=> 'View More Products <i class="icon icon-chevron-right"></i>',
	'button_primary_style'	=> 'inverse',

);

$shop_nav = array(

	'taxonomy'				=> 'category',
	//'parent_taxonomies'		=> 'product',
	//'child_taxonomies' 		=> '6',

);

$categories_nav = array(

	'taxonomy'				=> 'product_cat',
	//'parent_taxonomies'		=> 'product',
	//'child_taxonomies' 		=> '6',

);


?>

<div class="shop-header">

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'pl98734dasdf', 'settings' => $header ) ); ?>

</div>

<div class="shop-featured-banner" style="background: #f7f7f7;padding: 20px 0;">

	<div class="pl-content">

		<?php echo pl_get_section( array('section' => 'pl-heropost', 'id' => 'pl3276334asdf', 'settings' => $featured_hero_banner ) ); ?>

	</div>

</div>

<div class="shop-home">

	<div class="pl-content row-flex">


		<div class="col-sm-2">
			
			<?php echo pl_get_section( array('section' => 'pl-multitax', 'id' => 'pl12574594pltb', 'settings' => $shop_nav ) ); ?>

			<?php echo pl_get_section( array('section' => 'pl-multitax', 'id' => 'pl12573594ehyd', 'settings' => $categories_nav ) ); ?>

		</div>


		<div class="col-sm-8">
			
			<?php echo pl_get_section( array('section' => 'elements', 'id' => 'pl987795dasdf', 'settings' => $featured_posts_head ) ); ?>

			<?php echo pl_get_section( array('section' => 'pl-loopgrid', 'id' => 'pl1277894asdf', 'settings' => $featured_posts ) ); ?>

			<?php echo pl_get_section( array('section' => 'elements', 'id' => 'pl987555dasdf', 'settings' => $rated_posts_head ) ); ?>

			<?php echo pl_get_section( array('section' => 'pl-loopgrid', 'id' => 'pl1255894asdf', 'settings' => $rated_posts ) ); ?>

			<?php echo pl_get_section( array('section' => 'elements', 'id' => 'pl987826dasdf', 'settings' => $latest_posts_head ) ); ?>

			<?php echo pl_get_section( array('section' => 'pl-loopgrid', 'id' => 'pl1255835asdf', 'settings' => $latest_posts ) ); ?>

			<?php echo pl_get_section( array('section' => 'elements', 'id' => 'pl9878326dasdf', 'settings' => $more_products ) ); ?>

		</div>

		<div class="col-sm-2">
			Sidebar Right
		</div>


	</div>

</div>



<?php get_footer(); ?>
