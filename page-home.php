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

	'post_cols'			=> '3',
	'post_type'			=> 'picasso-showcase',
	'posts_total' 		=> '8',
	'posts_meta_key'	=> 'featured',
	'posts_meta_value'	=> '1'

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

$framework_boxes = array(

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

$framework_videobox = array(

	'col'			=> 6,
	'upload_video'	=> 'http://localhost/pagelines-ten/wp-content/uploads/2015/04/pagelines1.mp4',
	'autoplay'		=> '1',
	'loop'			=> '1',
	'controls'		=> '1'

);

$framework_home_cta = array(

	'header' 				 => '',
	'button_primary'		 => 'http://www.pagelines.com/showcase/',
	'button_primary_text'	 => 'View Framework Demo',
	'button_primary_style'	 => 'inverse'	
);	

$home_testimonials_heading = array(

	'header' 				 => 'What People are Saying', 
	'subheader' 			 => 'We have some of the happiest customers in the business...'

);


?>

<div class="banner-board">

	<?php echo pl_get_section( array('section' => 'elements', 'id' => 'e987654dasdf', 'settings' => $default_banner ) ); ?>

</div>

<div class="home_showcase">

	<div class="pl-content">

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'e987654dfds', 'settings' => $showcase_home_heading ) ); ?>

		<?php echo pl_get_section( array('section' => 'pl-loopgrid', 'id' => 'e3271934asdf', 'settings' => $showcase_home_content ) ); ?>

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'r18367475jkhg', 'settings' => $showcase_home_cta ) ); ?>

	</div>

</div>

<div class="home_framework">

	<div class="pl-content">
		<div class="row-flex">

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'r234946484scsv', 'settings' => $framework_home_heading ) ); ?>

		<?php echo pl_get_section( array('section' => 'boxes', 'id' => 'r94757673dho', 'settings' => $framework_boxes ) ); ?>

		<?php echo pl_get_section( array('section' => 'pl-videobox', 'id' => 'r94753653dro', 'settings' => $framework_videobox) ); ?>

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'r1835845jkhg', 'settings' => $framework_home_cta ) ); ?>

		</div>
	</div>

</div>

<div class="home_testimonials">

	<div class="pl-content">
		<div class="row-flex">

		<?php echo pl_get_section( array('section' => 'elements', 'id' => 'r2349837484scsv', 'settings' => $home_testimonials_heading ) ); ?>

		</div>
	</div>

</div>
