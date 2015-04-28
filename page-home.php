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
		'button_primary_theme'	 => 'ol-white',
		'button_secondary'		 => '#',
		'button_secondary_text'	 => 'Framework Demo',
		'button_secondary_theme' => '',
		'effects'				 => 'pl-effect-window-height',
		'theme'					 => 'pl-scheme-dark'

	);

$default_showcase_home = array(

		'posts_count' 	=> 1,

	);


?>

<div class="banner-board">

	<?php echo pl_get_section( array('section' => 'elements', 'id' => 'e987654dasdf', 'settings' => $default_banner ) );?>

</div>

<div class="showcase_featured_grid">

	<?php echo pl_get_section( array('section' => 'showcasefeaturedgrid', 'id' => 'e6274564asdf', 'settings' => $default_showcase_home ) );?>

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


