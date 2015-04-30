<?php
/*
 * Template Name: PageLines Home
 * Description: It's only the beginning.
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


$default_banner = array(

	'header' 				 => 'Build Professional Websites <br />Without Coding', 
	'subheader' 			 => 'Built for WordPress. A Drag and drop editable, high performance design platform.', 
	'button_primary'		 => 'http://www.pagelines.com/club/',
	'button_primary_text'	 => 'View Plans &amp; Pricing',
	'button_primary_style'	 => 'ol-white',
	'button_secondary'		 => '#',
	'button_secondary_text'	 => 'Framework Demo',
	'button_secondary_style' => '',
	'effects'				 => 'pl-effect-window-height',
	'theme'					 => 'pl-scheme-dark'

);

$showcase_home_content = array(

	'posts_count' 	=> 4
);

$showcase_home_heading = array(

	'header' 				 => '', 
	'subheader' 			 => 'Latest from the Showcase...'

);

$showcase_home_cta = array(

	'header' 				 => '',
	'button_primary'		 => 'http://www.pagelines.com/showcase/',
	'button_primary_text'	 => 'View Website Showcase',
	'button_primary_style'	 => 'inverse'	
);	

$framework_home_heading = array(

	'header' 		=> 'Built for Perfectionists...', 
	'subheader' 	=> 'Created with the latest in web technology.'

);

$framework_home_content_left = array(

	'col'			=> 6,
	'ibox_cols' 	=> 12,
	'ibox_format' 	=> 'left',
	'ibox_array' 	=> [
		[
			'title'		=> "Drag &amp; Drop Design", 
			'text'		=> 'Save time and frustration by visually editing your site. Build professional layouts in minutes.',
			'icon'		=> 'random'
		],
		[
			'title'		=> "100% Responsive", 
			'text'		=> 'The design will scale to fit on all browser widths/resolutions and on all mobile devices. Go ahead and scale your browser window and see the results.', 
			'icon'		=> 'mobile'
		],
		[
			'title'		=> "eCommerce", 
			'text'		=> 'Transform your website into an online shop with WooCommerce, fully supported in PageLines.', 
			'icon'		=> 'shopping-cart'
		]
	],

);

$framework_home_content_right = array(

	'col'	=> 6,

);

$framework_home_cta = array(

	'header' 				 => '',
	'button_primary'		 => 'http://www.pagelines.com/showcase/',
	'button_primary_text'	 => 'View Website Showcase',
	'button_primary_style'	 => 'inverse'	
);	


?>

<div class="banner-board">

	<?php echo pl_get_section( array('section' => 'elements', 'id' => 'e987654dasdf', 'settings' => $default_banner ) ); ?>

</div>

<div class="showcase_home">

	<div class="pl-content">

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'e987654dfds', 'settings' => $showcase_home_heading ) ); ?>

		<?php echo pl_get_section( array('section' => 'showcasefeaturedgrid', 'id' => 'e6274564asdf', 'settings' => $showcase_home_content ) ); ?>

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'r18367475jkhg', 'settings' => $showcase_home_cta ) ); ?>

	</div>

</div>

<div class="framework_home">

	<div class="pl-content">

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'r234946484scsv', 'settings' => $framework_home_heading ) ); ?>

		<?php echo pl_get_section( array('section' => 'boxes', 'id' => 'r94757673dho', 'settings' => $framework_home_content_left ) ); ?>

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'r94757663dro', 'settings' => $framework_home_content_right ) ); ?>

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'r1836845jkhg', 'settings' => $framework_home_cta ) ); ?>

	</div>

</div>

<?php //echo pl_get_section( array('section' => 'slider', 'id' => '424242') );?>

<?php //echo pl_get_section( array('section' => 'hero', 'id' => '2222223') );?>

<?php //echo do_shortcode( '[plsection section="slider"]');?>


<div  class="pl-content">
	<div class="row-flex">
		<div class="col-sm-4" data-bind="pltext: header_text">123</div>
		<div class="col-sm-4">123</div>
		<div class="col-sm-4">123</div>
	</div>
</div>


