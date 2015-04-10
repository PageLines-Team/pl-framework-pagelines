<?php
/*
	Section: 	Columnizer
	Author: 	PageLines
	Author URI: http://www.pagelines.com
	Description: Place this section wherever you like and use WordPress widgets and a desired number of columns, to create an instant columnized widget section.
	Class Name: PageLinesColumnizer
	Filter: 	widgetized
*/

class PageLinesColumnizer extends PageLinesSection {


	function section_persistent(){

		add_filter('pl_sync_binding_columnizer', array( $this, 'switch_widgets'), 10, 2); 

	}

	function switch_widgets( $response, $data ){

		$response['template'] = $this->pl_get_columnizer( $data['value'] ); 

		return $response;
	}

	function pl_get_columnizer( $area ){

		if( $area ){

			ob_start();

				add_filter('dynamic_sidebar_params', array( $this, 'columnizer_change_markup') );
			
				echo pagelines_draw_sidebar( $area );

				remove_filter('dynamic_sidebar_params', array( $this, 'columnizer_change_markup') );

			return ob_get_clean();

		} else {

			return sprintf ('<ul class="columnizer fix sidebar_widgets" %s>%s</ul>', $area_bind, $this->get_default( $this->opt('columnizer_description') ) );

		}

	
		
	}

	function columnizer_change_markup( $params ){


	
		$params[0]['before_widget'] = sprintf('<div class="col-sm-3 widget-col pl-iso" >%s', $params[0]['before_widget']);

		$params[0]['after_widget'] = sprintf('%s</div>', $params[0]['after_widget']);


		return $params;
	}

	/** 
	 * The default output for the section.
	 */
	function get_default( $desc = false ){

		$default_textwidget = ($desc) 
			? $desc
			: '<p>Lorem ipsum dolor sit amet elit, consectetur adipiscing. Vestibulum luctus ipsum id quam euismod a malesuada sapien euismot. Vesti bulum ultricies elementum interdum. </p><address>PageLines Inc.<br/>200 Brannan St.<br/>San Francisco, CA 94107</address>'; 

		
		$defaults = array(

			array(
				'title'	=>  __('Latest Posts','pagelines'), 
				'cont'	=> pl_recent_posts(), 
				'type' 	=> 'media-list'
			), 
			array(
				'title'	=>  __('Recent Comments','pagelines'), 
				'cont'	=> pl_recent_comments(), 
				'type' 	=> 'quote-list'
			),
			array(
				'title'	=>  __('Top Categories','pagelines'), 
				'cont'	=> pl_popular_taxonomy(), 
				'type' 	=> 'media-list'
			),
			array(
				'title'	=>  __('About','pagelines'), 
				'cont'	=> $default_textwidget, 
				'type' 	=> 'textwidget'
			),
		); 
		ob_start();
		?>

		<?php foreach( $defaults as $widget ):  

			$bind = ( $widget['type'] == 'textwidget') ? 'data-bind="plsync: columnizer_description"' : ''; 

		?>
		<li class="col-sm-3 widget-col pl-iso widget">
			<div class="widget-pad">
				<h3 class="widget-title"><?php echo $widget['title']; ?></h3>
				<ul class="<?php echo $widget['type']; ?>" <?php echo $bind;?>>
					<?php echo $widget['cont']; ?>
				</ul>
			</div>
		</li>
		<?php endforeach;?>
	


	<?php


		return ob_get_clean();
	 }


	function section_opts(){

		$opts = array(
			array(
				'title' => __( 'Columnizer Configuration', 'pagelines' ),
				'type'	=> 'multi',
				'opts'	=> array(
					array(
						'key'			=> 'columnizer_cols',
						'type' 			=> 'select',
						'opts'		=> array(
							'3'			=> array( 'name' => __( '3 of 12 Columns', 'pagelines' ) ),
							'4'			=> array( 'name' => __( '4 of 12 Columns', 'pagelines' ) ),
							'6'			=> array( 'name' => __( '6 of 12 Columns', 'pagelines' ) )
						),
						'default'		=> '3',
						'label' 		=> __( 'Number of Grid Columns for Each Widget (12 Col Grid)', 'pagelines' ),
					),
					array(
						'key'	=> 'columnizer_description',
						'type'	=> 'textarea',
						
						'title'		=> __( 'Column Site Description', 'pagelines' ),
						'label'		=>	__( 'Column Site Description', 'pagelines' ),
						'help'		=> __( "If you use the default display of the columnizer, this field is used as a description of your company. You may want to add your address or links.", 'pagelines' ),
					)
				)
			)
			
		);

		$opts = array_merge( $opts, get_sidebar_section_opts('columnizer_area') ); 


		return $opts;
	}



	/**
	* Section template.
	*/
   function section_template() {

   		$area_bind = 'data-bind="plsync: columnizer_area, sync_mode: \'columnizer\', plclass: [{tag: $data.columnizer_cols(), partial: \'col-sm-\', child: \'.widget-col\'}]"';
   		
   		$area = $this->opt('columnizer_area');

   		printf( '<div class="columnizer-container pl-iso-container row" %s>', $area_bind ); 
		

   		echo $this->pl_get_columnizer( $area ); 


		echo '</div>';
	}

	
}


