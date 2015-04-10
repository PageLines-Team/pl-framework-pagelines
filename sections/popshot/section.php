<?php
/*
	Section: 		PopShot
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	An animated image shelf that pops up the images when the user scrolls them on page.
	Class Name: 	PLPopShot
	Filter: 		gallery
*/


class PLPopShot extends PageLinesSection {

	function section_opts(){


		$options = array();
		
		$options[] = array(
				'type'	=> 'multi',
				'key'	=> 'popshot_config', 
				'title'	=> 'Popshot Configuration',
				'col'	=> 1,
				'opts'	=> array(
					
					array(
						'type'	=> 'select',
						'key'	=> 'popshot_format', 
						'label'	=> 'Select Image Style',
						'opts'	=> array(
							'shadow'	=> array( 'name' => 'Images w/ Drop Shadows'),
							'nostyle'	=> array( 'name' => 'No Style'),
							'frame'		=> array( 'name' => 'Images with Frame'),
							'browser'	=> array( 'name' => 'Faux Browser Wrap (for screenshots)'),
						), 
					),
					array(
						'key'			=> 'stage_height',
						'label'			=> __( 'Popshot Stage Height', 'pagelines' ),
						'type'			=> 'select_pixels',
						'count_start'	=> 100,
						'count_number'	=> 500,
						'default'		=> '300px',
						'help'			=> __( 'Select the height of the Popshot staging area.', 'pagelines' ),
					),
				)
				
			);
		
		
		$options[] = array(
			'key'		=> 'popshot_array',
	    	'type'		=> 'accordion', 
			'title'		=> __('PopShot Setup', 'pagelines'), 
			'post_type'	=> __('PopShot', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'			=> 'image',
					'label' 		=> __( 'PopShot Image <span class="label label-warning">REQUIRED</span>', 'pagelines' ),
					'type'			=> 'image_upload',
				),
				array(
					'key'			=> 'offset',
					'label'			=> __( 'Offset from center', 'pagelines' ),
					'type'			=> 'select_pixels',
					'count_start'	=> -500,
					'count_number'	=> 500,
					'help'			=> __( 'Left edge offset from center. For example -100px  would move the left edge of the image 100 pixels left from center.', 'pagelines' ),
				),
				array(
					'key'			=> 'width',
					'label'			=> __( 'Maximum Width', 'pagelines' ),
					'type'			=> 'select_pixels',
					'default'		=> '400px',
					'help'			=> __( 'Max width of image.', 'pagelines' ),
				),
				array(
					'key'			=> 'height',
					'label'			=> __( 'Maximum Height', 'pagelines' ),
					'type'			=> 'select_pixels',
					'default'		=> '250px',
					'help'			=> __( 'Max height from bottom in pixels.', 'pagelines' ),
				),
				array(
					'key'			=> 'index',
					'label'			=> __( 'Z-Index (Stacking order)', 'pagelines' ),
					'type' 			=> 'count_select',
					'count_start'	=> 1,
					'count_number'	=> 20,
					'help'			=> __( 'Higher numbers will be placed higher in the stack.', 'pagelines' ),
				),
				
				

			)
	    );
	
		
		return $options;

	}



   function section_template( ) { 

	?>

	<script type="text/html" id="popshot-template">

		<div class="pl-animation pla-from-bottom popshot" data-bind="css: 'popshot-' + $index(), visible: image() != '', style: {marginLeft: offset, zIndex: index, maxWidth: width, maxHeight: height}">

			<div class="browser-btns" data-bind="visible: $root.popshot_format() == 'browser'">
				<span class="bbtn-red"></span><span class="bbtn-orange"></span><span class="bbtn-green"></span>
			</div>

			<img src="%s" alt="" data-bind="plimg: image" />

		</div>
			
	</script>
	
	<div class="the-popshot-wrap " data-bind="plclass: popshot_format, partial: 'format-', style:{height: stage_height} ">
		<div class="pl-animation-group" data-bind="template: {name: 'popshot-template', foreach:popshot_array()}">

		</div>
		<div class="shelf-shadow"></div>
	</div>

<?php }


}