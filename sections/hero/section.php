<?php
/*
	Section: 		Hero
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A responsive full width image and text area with button.
	Class Name: 	PLheroUnit
	Filter: 		component

*/

class PLheroUnit extends PageLinesSection {

	function section_opts() {

		$opts = array(

			array(
				'title'			=> __( 'Hero Settings', 'pagelines' ),
				'type'			=> 'multi',
				'opts'			=> array(

					array(
						'key'			=> 'pagelines_herounit_title',
						'type'			=> 'text',
						'label'			=> __( 'Heading', 'pagelines' ) 
					),

					array(
						'key'			=> 'pagelines_herounit_tagline',
						'type'			=> 'textarea',
						'label'			=> __( 'Subtext', 'pagelines' ) 
					)
				)
			),

            array(
                'title'			=> __( 'Hero Image', 'pagelines' ),
                'type'			=> 'multi',
                'opts'			=> array(
					array(
						'key'			=> 'pagelines_herounit_image',
						'type'			=> 'image_upload',
						'has_alt'		=> true,
						'label'			=> __( 'Upload Custom Image', 'pagelines' ) 
					),
		            array(
		                'key'			=> 'herounit_reverse',
		                'type'			=> 'check',
		                'default'		=> false,
		                'label'			=> __( 'Reverse the Hero unit (image on left)', 'pagelines' ) 
		            ),
                )
            ),

			array(
				'title'			=> __( 'Content Widths', 'pagelines' ),
				'type'			=> 'multi',
				'opts'			=> array(

					array(
						'label'			=> __( 'Text Area Width', 'pagelines' ),
						'key'			=> 'herounit_left_width',
						'default'		=> '6',
						'type'			=> 'select',
						'opts'			=> array(

							'3'			=> array( 'name' => '3 of 12 Columns' ),
							'4'			=> array( 'name' => '4 of 12 Columns' ),
							'6'			=> array( 'name' => '5 of 12 Columns' ),
							'8'			=> array( 'name' => '6 of 12 Columns' ),
							'9'			=> array( 'name' => '7 of 12 Columns' ),
							'10'		=> array( 'name' => '8 of 12 Columns' )
						)
					),

				)
			),

			array(
				'title'			=> __( 'Hero Button', 'pagelines' ),
				'type'			=> 'multi',
				'opts'			=> pl_button_link_options('herounit_button')
			)
		);
	
		return $opts;
	
	}


	/**
	* Section template.
	*/
   function section_template() {

		$hero_title 		= ( $this->opt( 'pagelines_herounit_title' ) ) 		? $this->opt( 'pagelines_herounit_title' ) 		: __('Hello.', 'pagelines');
		$hero_tag 			= ( $this->opt( 'pagelines_herounit_tagline' ) ) 	?  $this->opt( 'pagelines_herounit_tagline' )	: __('Now just set up your Hero section options', 'pagelines');

			?>

		<div class="pl-hero-wrap row pl-flex-row" data-bind="css: { 'row-reverse': herounit_reverse() != 0 }">
			<div class="pl-hero pl-hero-col col-sm-6 pl-vertical-center" data-bind="plclass: [{tag: herounit_left_width(), partial: 'col-sm-'}]">
				<div class="pl-hero-pad ">
					<h1 class="m-bottom" data-bind="plsync: pagelines_herounit_title"><?php echo $hero_title;?></h1>
					<p data-bind="plsync: pagelines_herounit_tagline"><?php echo $hero_tag;?></p>
					<?php pl_dynamic_button( 'herounit_button', 'btn-primary btn-large');  ?>
				</div>
			</div>

			<div class="pl-hero-image pl-hero-col col-sm-%s pl-vertical-center"  data-bind="plclass: [{tag: 12 - herounit_left_width(), partial: 'col-sm-'}]">
				<div class="hero_image">
					<?php echo $this->image('pagelines_herounit_image' ); ?>
				</div>
		 
			</div>

		</div>
		<?php

	}

}