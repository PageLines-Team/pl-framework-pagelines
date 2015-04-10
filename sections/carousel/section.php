<?php
/*
	Section: 		QuickCarousel
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A fast way to create an animated image carousel.
	Class Name: 	PLQuickCarousel
	Filter: 		carousel
*/


class PLQuickCarousel extends PageLinesSection {

	function section_styles(){

		/** http://kenwheeler.github.io/slick/ */
		pl_enqueue_script( 'caroufredsel', 		$this->base_url.'/carousel.slick.js', 	array( 'jquery' ), pl_get_cache_key(), true );

		pl_enqueue_script( 'pl-quickcarousel', 	$this->base_url.'/pl.quickcarousel.js', array( 'jquery' ), pl_get_cache_key(), true );

	}

	function section_opts(){


		$options = array();
		
		$options[] = array(
				'type'	=> 'multi',
				'key'	=> 'config', 
				'title'	=> 'Config',
				'col'	=> 1,
				'opts'	=> array(
					array(
						'type'		=> 'select',
						'key'		=> 'max', 
						'label'		=> 'Max Items In View',
						'default'	=> 6,
						'opts'		=> array(
							'2'			=> array('name' => '2 Items'),
							'3'			=> array('name' => '3 Items'),
							'4'			=> array('name' => '4 Items'),
							'6'			=> array('name' => '6 Items')
						),
					),
					
					array(
						'type'		=> 'select',
						'key'		=> 'speed', 
						'label'		=> 'Transition Speed',
						'default'	=> 5000,
						'opts'		=> array(
							'500'			=> array('name' => '.5 Seconds'),
							'1000'			=> array('name' => '1 Seconds'),
							'2000'			=> array('name' => '2 Seconds'),
							'5000'			=> array('name' => '5 Seconds'),
							'10000'			=> array('name' => '10 Seconds'),
							'20000'			=> array('name' => '20 Seconds')
						),
					),
					array(
						'type' 			=> 'check',
						'key'			=> 'anim_disable',
						'label' 		=> __( 'Disable Animation', 'pagelines' ),
						'help' 			=> __( 'Disable the animation on pageload?.', 'pagelines' ),
					),
				)
				
			);
		
		
		$options[] = array(
			'key'		=> 'array',
	    	'type'		=> 'accordion', 
			'opts_cnt'	=> 6,
			'title'		=> __('Image Setup', 'pagelines'), 
			'post_type'	=> __('Image', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'		=> 'image',
					'label' 	=> __( 'Carousel Image <span class="badge badge-mini badge-warning">REQUIRED</span>', 'pagelines' ),
					'type'		=> 'image_upload',
					'size'		=> 'aspect-thumb'
				),
				array(
					'key'	=> 'link',
					'label'	=> __( 'Image Link', 'pagelines' ),
					'type'	=> 'text',
				),

			)
	    );
	
		
		return $options;

	}



	function section_template(){
		?>
		<div class="qcarousel-container">

			<div class="pl-quickcarousel" style="display: none;" data-max="2" data-disable="" data-speed="5000" data-bind="plforeach: array, plattr: { 'data-max': max, 'data-disable': anim_disable, 'data-speed': speed}">
				<li class="carousel-item">
					<div class="carousel-item-pad">
						<a href="" data-bind="plhref: link">
							<img src="<?php echo pl_default_image();?>" data-bind="plimg: image, trigger: '.pl-quickcarousel'" />
						</a>
					</div>
				</li>
			</div>
		
		</div>
		

		<?php

	}



}