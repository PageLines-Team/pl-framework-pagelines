<?php
/*
	Section: Testimonials
	Author: PageLines
	Author URI: http://www.pagelines.com
	Description: List testimonials with quotes, links and gravatar images.
	Class Name: PLTestimonials
	Filter: social
*/

class PLTestimonials extends PageLinesSection {

	function section_styles(){

		pl_enqueue_script( 'pl-testimonials', $this->base_url . '/pl.testimonials.js', array( 'jquery' ), pl_get_cache_key(), true );
	}
	
	function section_opts(){
		
		$options = array();
		
		$options[] = array(
			'key'		=> 'pl_testimonial_config',
	    	'type'		=> 'multi', 
			'col'		=> 1,
			'title'		=> __('Testimonials Config', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'	=> 'testimonials_mode',
					'label'	=> __( 'Mode', 'pagelines' ),
					'type'	=> 'select',
					'opts'	=> array(
						'theme'		=> array('name' => 'Default "dot" navigation'),
						'avatar'	=> array('name' => 'Use author gravatars'),
					),
				),
				array(
					'key'	=> 'testimonials_disable_auto',
					'label'	=> __( 'Disable Automatic Transition?', 'pagelines' ),
					'type'	=> 'check'
				),
				array(
					'key'	=> 'testimonials_speed',
					'label'	=> __( 'Slide Time in ms (ex: 10000, auto mode only) ', 'pagelines' ),
					'type'	=> 'text_small'
				),
				

			)
	    );
		
		$options[] = array(
			'key'		=> 'pl_testimonial_array',
	    	'type'		=> 'accordion', 
			'title'		=> __('Testimonials Setup', 'pagelines'), 
			'post_type'	=> __('Testimonial', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'		=> 'text',
					'label'		=> __( 'Text', 'pagelines' ),
					'type'		=> 'text', 
					'default' 	=> 'Hello.'
				),
				array(
					'key'		=> 'cite',
					'label'		=> __( 'Citation', 'pagelines' ),
					'type'	 	=> 'text', 
					'default'	=> 'PageLines'
				),
				array(
					'key'		=> 'image',
					'label'		=> __( 'Image (Avatar Mode Only)', 'pagelines' ),
					'type'		=> 'image_upload', 
					'size'		=> 'basic-thumb'

				),
				

			)
	    );

		return $options;

	}


	function section_template() {
	
		?>
		<div class="pl-testimonials-container" 
			data-mode="default" 
			data-auto="true" 
			data-speed="10000"
			data-bind="plattr: {'data-mode': testimonials_mode, 'data-auto': testimonials_disable_auto, 'data-speed': testimonials_speed}" 
		>
			<div class="pl-testimonials" data-bind="plforeach: pl_testimonial_array">

				<div class="the-testimonial">
					<blockquote>
						<p data-bind="plsync: text">"Hello. This is a testimonial."</p>
					</blockquote>
					<cite data-bind="plsync: cite"><a href="http://www.pagelines.com">&mdash; PageLines</a></cite>
				</div>

				
			</div>
			<div class="controls ">
				<ul class="nav-theme list-unstyled" data-bind="plforeach: pl_testimonial_array, plclass: $root.testimonials_mode(), partial: 'nav-', dflt: 'theme' ">
					<li class="nav-switch">
						<span data-bind="visible: $root.testimonials_mode() != 'avatar'"></span>
						<span style="background-image: url(<?php echo pl_default_thumb();?>)" data-bind="visible: $root.testimonials_mode() == 'avatar', plimg: image, flag: 'bg'"></span>
					</li>
				</ul>
			</div>
		</div>
	<?php
	}

}
