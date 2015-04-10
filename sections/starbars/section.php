<?php
/*

	Section: 		StarBars
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	Awesome animated stat bars that animate as the user scrolls. Use them to show stats or other information.
	Class Name: 	PageLinesStarBars
	Filter: 		post-format
	Levels: 		all
*/

class PageLinesStarBars extends PageLinesSection {

	var $default_limit = 3;

	function section_styles(){

		pl_enqueue_script( 'starbar', $this->base_url.'/starbar.js', array( 'jquery' ), pl_get_cache_key(), true );

	}

	function section_opts(){

		$options = array();

		$options[] = array(

			'title' => __( 'StarBar Configuration', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'			=> 'starbar_total',
					'type' 			=> 'text',
					'default'		=> 100,
					'label' 		=> __( 'Starbar Total Count (Number)', 'pagelines' ),
					'help' 			=> __( 'This number will be used to calculate the percent of the bar filled. The StarBar values will be shown as a percentage of this value. Default is 100.', 'pagelines' ),
				),

				array(
					'key'			=> 'starbar_modifier',
					'type' 			=> 'text',
					'default'		=> '%',
					'label' 		=> __( 'Starbar Modifier (Text Added to Stats)', 'pagelines' ),
					'help' 			=> __( 'This will be added to the stat number.', 'pagelines' ),
				),
				array(
					'key'			=> 'starbar_container_title',
					'type' 			=> 'text',
					'default'		=> 'StarBar',
					'label' 	=> __( 'StarBar Title (Optional)', 'pagelines' ),
				),
			)

		);

		$options[] = array(
			'key'		=> 'starbar_array',
	    	'type'		=> 'accordion', 
			'title'		=> __('Starbars Setup', 'pagelines'), 
			'opts'	=> array(
				array(
					'key'		=> 'text',
					'label'		=> __( 'Description', 'pagelines' ),
					'type'		=> 'text', 
					'default' 	=> 'Hello.'
				),
				array(
					'key'		=> 'value',
					'label'		=> __( 'Value', 'pagelines' ),
					'type'	 	=> 'text', 
					'default'	=> 'PageLines'
				),

			)
	    );


		return $options;
	}

	function section_template(  ) {

	
		?>

		<div class="starbars-wrap">
			<h3 data-bind="text: starbar_container_title"></h3>
			<ul class="starbars trigger-container list-unstyled" data-bind="plforeach: starbar_array">
				<li>
					<div class="description-container clearfix" data-bind="visible: text != '' || $root.starbar_total()">
						<p class="desc" data-bind="text: text">Ninja Ability</p>
						<p class="total trigger" data-bind="pltext: $root.starbar_total()">100</p>
					</div>
					<div class="bar-wrap pl-contrast">
						<span class="the-bar trigger" data-width="70%" data-bind="plattr: {'data-width': value() / $root.starbar_total()}, unit: 'percent'"><strong data-bind="pltext: value() + $root.starbar_modifier()">70%</strong></span>
					</div>
				</li>
			</ul>
		</div>

		<?php 




	}

}