<?php
/*
	Section: 		RevSlider
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A professional and versatile slider section. Can be customized with several transitions and a large number of slides.
	Class Name: 	plRevSlider
	Filter: 		slider
	Levels: 		0
*/


class plRevSlider extends PageLinesSection {

	function section_styles(){

		pl_enqueue_script( 'revolution-plugins', 	$this->base_url . '/rs-plugin/js/jquery.themepunch.tools.min.js', 	array( 'jquery' ), 		pl_get_cache_key(), true );
		pl_enqueue_script( 'revolution', 			$this->base_url . '/rs-plugin/js/jquery.themepunch.revolution.js', 	array( 'jquery' ), 		pl_get_cache_key(), true );
		pl_enqueue_style(  'revolution', 			sprintf( '%s/rs-plugin/css/settings.css', $this->base_url ), 		null, 					pl_get_cache_key() );
		pl_enqueue_script( 'pagelines-slider', 		$this->base_url . '/pl.slider.js', 									array( 'revolution' ), 	pl_get_cache_key(), true );

		wp_localize_script( 'revolution', 'plRevolution', array( 'videojs' => $this->base_url.'/rs-plugin/videojs/' ));
		
	}

	function section_opts(){

		$options = array();

		$options[] = array(

			'title' => __( 'Slider Configuration', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'			=> 'revslider_delay',
					'type'			=> 'count_select',
					'count_start'	=> 0,
					'count_number'	=> 20000,
					'count_mult'	=> 1000,
					'default'		=> 7000,
					'label' 		=> __( 'Time Per Slide in Milliseconds (e.g. 12000)', 'pagelines' ),
				),
				array(
					'key'			=> 'revslider_height',
					'type' 			=> 'text_small',
					'count_start'	=> 100,
					'count_number'	=> 1000,
					'count_mult'	=> 100,
					'default'		=> 500,
					'label' 		=> __( 'Slider Height in Pixels (e.g. 500)', 'pagelines' ),
				),
				array(
					'key'			=> 'revslider_fullscreen',
					'type' 			=> 'check',
					'label' 		=> __( 'Set to full window height? (Overrides height setting)', 'pagelines' ),
					'help' 			=> __( 'This option will set the slider to the height of the users browser window on load, it will also resize as needed.', 'pagelines' ),
				)
			)

		);

		$options[] = array(
			'key'		=> 'revslider_array',
	    	'type'		=> 'accordion', 
			'title'		=> __('Slides Setup', 'pagelines'), 
			'post_type'	=> __('Slide', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'		=> 'background',
					'label' 	=> __( 'Slide Background Image <span class="badge badge-mini badge-warning">REQUIRED</span>', 'pagelines' ),
					'type'		=> 'image_upload',
					'sizelimit'	=> 2097152, // 2M
					'help'		=> __( 'For high resolution, 2000px wide x 800px tall images. (2MB Limit)', 'pagelines' )
					
				),
				array(
					'key'	=> 'title',
					'label'	=> __( 'Headline', 'pagelines' ),
					'type'	=> 'text'
				),
				array(
					'key'	=> 'text',
					'label'	=> __( 'Text', 'pagelines' ),
					'type'			=> 'text'
				),
				array(
					'key'			=> 'element_color',
					'label' 		=> __( 'Color Scheme', 'pagelines' ),
					'type'			=> 'select',
					'opts'	=> array(
						'element-light'		=> array('name'=> 'Light Text and Elements'),
						'element-dark'		=> array('name'=> 'Dark Text and Elements'),
					)
				),
				array(
					'key'		=> 'location',
					'label'		=> __( 'Slide Text Align', 'pagelines' ),
					'type'		=> 'select',
					'opts'	=> array(
						'left-side'		=> array('name'=> 'Text On Left'),
						'right-side'	=> array('name'=> 'Text On Right'),
						'centered'		=> array('name'=> 'Centered'),
					)
				),
				array(
					'key'			=> 'x_offset',
					'label'			=> __( 'X offset from left', 'pagelines' ),
					'type'			=> 'count_select',
					'count_start'	=> -400,
					'count_number'	=> 600,
					'count_mult'	=> 50,
					'default'		=> '0',
				),
				
				array(
					'key'		=> 'transition',
					'label'		=> __( 'Slide Transition', 'pagelines' ),
					'type'		=> 'select_same',
					'opts'		=> $this->slider_transitions()
				),
				array(
					'title'			=> __( 'Primary Button', 'pagelines' ),
					'type'			=> 'multi',
					'stylize'		=> 'button-config',
					'opts'			=> pl_button_link_options('link')
				),
				array(
					'title'			=> __( 'Secondary Button', 'pagelines' ),
					'type'			=> 'multi',
					'stylize'		=> 'button-config',
					'opts'			=> pl_button_link_options('link_2')
				),
		

			)
	    );


		return $options;
	}

	function section_template( ) {

		$full = ( $this->opt('revslider_fullscreen') ) ? 'on' : 'off';


//<div data-bind="text: ko.toJSON($root)" style="word-wrap: break"></div>
	?>
	
	<div class="pl-area-wrap revslider-wrap">
			<div class="revslider-container pl-slider-container trigger-container" style="display: none;">
				
				<div class="header-shadow"></div>

				<div class="pl-slider revslider-full" 
						data-bind="plattr: {
							'data-delay': revslider_delay, 
							'data-height': revslider_height, 
							'data-fullscreen': revslider_fullscreen
						}" 
						data-delay="<?php echo $this->opt('revslider_delay'); ?>"
						data-height="<?php echo $this->opt('revslider_height'); ?>" 
						data-fullscreen="<?php echo $full;?>">

					<ul class="list-unstyled trigger" data-bind="plforeach: revslider_array">

						<li data-transition="fade" data-slotamount=	"10" class="bg-video-canvas"  data-bind="plattr: {'data-transition': transition}">

							<img class="trigger" src="<?php echo PL_IMAGES.'/default-background.png';?>" alt="" data-bind="plimg: background"
								data-bgposition="center center" 
								data-bgfit="cover" 
								data-bgrepeat="no-repeat" 
								>

							<div class="caption slider-content trigger" 
								data-bind="plcss: {
									'centered': location() == 'centered', 
									'right-side': location() =='right-side', 
									'left-side': location() == 'left-side' || !location
								}, 
								plattr: {
									'data-x': x_offset
								}"
								data-x="0" 
								data-y="center" 
								data-speed="300" 
								data-start="500" 
								data-easing="easeOutExpo">

								<h2 class="slider-text">
									<span class="slide-title trigger" data-bind="plsync: title" >Title</span>
									<span class="slide-desc trigger" data-bind="plsync: text">Text</span>
									<div class="slider-buttons">
										<?php pl_dynamic_button( 'link', 'btn-lg trigger', 'ol-white' ); ?>
										<?php pl_dynamic_button( 'link_2', 'btn-lg trigger', 'ol-white'); ?>
									</div>
								</h2>
								

							</div>

						</li>

					</ul>

					<div class="tp-bannertimer tp-top" data-tween="" ></div>
					
				</div>
			</div>
		</div>
		
	
<?php
	}

	
	function slider_transitions(){

		$transitions = array(
			'boxslide',
			'boxfade',
			'curtain-1',
			'curtain-2',
			'curtain-3',
			'slideleft',
			'slideright',
			'slideup',
			'slidedown',
			'fade',
			'random',
			'slidehorizontal',
			'slidevertical',
			'papercut',
			'flyin',
			'turnoff',
			'cube',
			'3dcurtain-vertical',
			'3dcurtain-horizontal',
		);

		return $transitions;

	}




}