<?php
/*
	Section: 		PopThumbs
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	Adds columnized thumbnails that lightbox to full size images on click.
	Class Name: 	PLPopThumbs
	Filter: 		gallery
*/


class PLPopThumbs extends PageLinesSection {

	var $default_limit = 4;

	function section_styles(){
		pl_enqueue_script('prettyphoto', 		$this->base_url.'/prettyphoto.min.js', 	array('jquery'));
		pl_enqueue_script('popthumbs', 			$this->base_url.'/pl.popthumbs.js', 	array('jquery'));
		pl_enqueue_style( 'prettyphoto-css', 	$this->base_url.'/prettyPhoto/css/prettyPhoto.css');
		
	}
	

	function section_opts(){
		$options = array();

		$options[] = array(

			'title' => __( 'PopThumb Configuration', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'			=> 'popthumb_cols',
					'type' 			=> 'count_select',
					'count_start'	=> 2,
					'count_number'	=> 6,
					'default'		=> '4',
					'label' 	=> __( 'Number of Columns for Each Thumb (12 Col Grid)', 'pagelines' ),
				),
			)

		);
		
		
		$options[] = array(
			'key'		=> 'popthumb_array',
	    	'type'		=> 'accordion', 
			'title'		=> __('PopThumbs Items', 'pagelines'), 
			'opts'	=> array(
		
				array(
					'key'	=> 'title',
					'label'	=> __( 'Title', 'pagelines' ),
					'type'			=> 'text'
				),
				array(
					'key'	=> 'text',
					'label'	=> __( 'Text', 'pagelines' ),
					'type'			=> 'text'
				),
				
				array(
					'key'	=> 'thumb',
					'label'	=> __( 'Thumb/Image', 'pagelines' ),
					'type'	=> 'image_upload', 
					'size'	=> 'big-thumb'
				),
				
			


			)
	    );

		return $options;
	}


   function section_template( ) { 
	
		
	
	
	?>
	
	<div class="popthumbs-wrap pl-animation-group" data-bind="foreach: popthumb_array">

		<div class="col-sm-%s pl-animation pl-appear fix" data-bind="if: thumb() != '', plclass: [{tag: $root.popthumb_cols(), partial: 'col-sm-'}]">

			<a class="popthumb iframe-ignore-link" href="%s" rel="prettyPhoto[]" data-bind="plhref: thumb">
				<span class="popthumb-thumb ">
					<img src="" data-bind="plimg: thumb" />
				</span>
				<span class="expander"><i class="icon icon-plus"></i></span>
			</a>

			<div class="popthumb-text">
				<h4 data-bind="text: title"></h4>
				<div class="popthumb-desc" data-bind="text: text"></div>
			</div>

		</div>

	</div>

<?php }


}