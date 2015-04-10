<?php
/*
	Section: 		Maps
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	Google maps with markers.
	Class Name: 	PLMaps
	Filter: 		localsocial
*/


class PLMaps extends PageLinesSection {


	/**
	 * Load our scripts in the footer
	 */
	function section_styles(){

		/** Maps JS Callback, must come before google maps src */
		pl_enqueue_script( 'pl-maps', $this->base_url.'/maps.js', array( 'jquery' ), pl_get_cache_key(), true );

		pl_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&callback=pl_initialize_maps', NULL, NULL, true );

	}

	function section_opts(){

		$help = 'To find map the coordinates use this easy tool: <a target="_blank" href="http://www.mapcoordinates.net/en">ww.mapcoordinates.net</a>';

		$default = $this->default_location();

		$options = array();

		$options[] = array(
				'type'	=> 'multi',
				'key'	=> 'plmap_config',
				'title'	=> __( 'Google Maps Configuration', 'pagelines' ),
				'col'	=> 1,
				'opts'	=> array(

					array(
						'key'		=> 'center_lat',
						'type'		=> 'text_small',
						'default'	=> $default['lat'],
						'place'		=> $default['lat'],
						'label'		=> __( 'Latitude', 'pagelines' ),
						'help'		=> $help
					),
					array(
						'key'		=> 'center_lng',
						'type'		=> 'text_small',
						'default'	=> $default['lng'],
						'place'		=> $default['lng'],
						'label'		=> __( 'Longitude', 'pagelines' ),
						'help'		=> $help
					),

					array(
						'type'	=> 'select',
						'key'	=> 'map_height',
						'default'	=> '350px',
						'label'	=> __( 'Select Map Height ( default 350px)', 'pagelines' ),
						'opts'	=> array(
							'200px'	=> array( 'name' => '200px'),
							'250px'	=> array( 'name' => '250px'),
							'300px'	=> array( 'name' => '300px'),
							'350px'	=> array( 'name' => '350px'),
							'400px'	=> array( 'name' => '400px'),
							'450px'	=> array( 'name' => '450px'),
							'500px'	=> array( 'name' => '500px'),
						)
					),
					array(
						'key'		=> 'pointer_image',
						'label' 	=> __( 'Pointer Image', 'pagelines' ),
						'type'		=> 'image_upload',
						'help'		=> __( 'For best results use an image size of 64 x 64 pixels.', 'pagelines' )
					),
					array(
						'type'	=> 'count_select',
						'key'	=> 'map_zoom_level',
						'default'	=> '12',
						'label'	=> __( 'Default Map Zoom Level ( default 10)', 'pagelines' ),
						'count_start'	=> 1,
						'count_number'	=> 18,
						'default'		=> '10',
					),
					array(
						'type'	=> 'check',
						'key'	=> 'map_zoom_enable',
						'label'	=> __( 'Enable Zoom Controls', 'pagelines' ),
						'default'		=> true,
						'compile'		=> true,
					),
				)

			);

		$options[] = array(
			'key'		=> 'locations_array',
	    	'type'		=> 'accordion',
			'col'		=> 2,
			'opts_cnt'	=> 1,
			'title'		=> __('Pointer Locations', 'pagelines'),
			'post_type'	=> __('Location', 'pagelines'),
			'opts'	=> array(

				array(
					'key'		=> 'latitude',
					'label'		=> __( 'Latitude', 'pagelines' ),
					'type'		=> 'text_small',
					'place'		=> '51.464382',
					'help'		=> $help,
				),
				array(
					'key'		=> 'longitude',
					'label'		=> __( 'Longitude', 'pagelines' ),
					'type'		=> 'text_small',
					'place'		=> '-0.256505',
					'help'		=> $help,
				),
				array(
					'key'		=> 'text',
					'label'		=> 'Location Description',
					'type'		=> 'textarea',
					'default'	=> $default['desc'],
					'place'		=> $default['desc']
				),

			)
	    );
		return $options;
	}

   function section_template( ) {


		$height = $this->opt( 'map_height', array( 'default' => '350px' ) );

	?>

		<div class="pl-map-wrap pl-animation pl-slidedown" data-bind="style: { height: map_height}">
			<div class="pl-map pl-end-height" id="pl_map_<?php echo $this->meta['unique'];?>"  style="height: <?php echo $height;?>" data-bind="style: { height: map_height}"></div>
			<div class="pl-json-el map-data"  data-id="pl_map_<?php echo $this->meta['unique'];?>" data-json='{}' data-bind="plmap: true, attr: { 'data-json': ko.toJSON($root) }"></div>
		</div>

	<?php


	}




	function default_location(){

		$a = array(
				'lat' 		=> floatval('37.774929'),
				'lng'		=> floatval('-122.419416'),
				'desc'		=> '<a href="http://www.pagelines.com">PageLines</a>',
				'mapinfo'	=> '<a href="http://www.pagelines.com">PageLines</a>',
				'image'		=> $this->base_url.'/marker.png'
			);


		return $a;
	}

}
