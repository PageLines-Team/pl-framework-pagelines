<?php
/*

	Section: 		Showcase Featured Grid
	Description: 	Display Showcase Featured Elements in a grid. 

	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	
	Class Name: 	PLShowcaseFeaturedGrid
	Filter: 		advanced

*/


class PLShowcaseFeaturedGrid extends PageLinesSection {

	function section_persistent(){

		//  add_filter('pl_binding_[id]', array( $this, '[function name]'), 10, 2); 

		add_filter('pl_binding_showcase', array( $this, 'callback'), 10, 2); 


	}

	function section_opts(){

			$opts = array();

			$opts = array(
				array(
					'key'				=> 'posts_count',
					'default'			=> '8',
					'count_start'		=> '2',
					'count_number'		=> '32',
					'label'				=> __( 'Number of Showcase Featured Posts Displayed', 'pagelines' ),
					'type'				=> 'count_select'
				),
			);

			return $opts;
	}

	function callback( $response, $data ){

		$response['template'] = $this->get_featured_showcase( $data['value'] ); 

		return $response;
	}

	function get_featured_showcase( $value ) {
		$args = array(
	      'orderby' 		=> 'rand',
	      'post_type' 		=> 'picasso-showcase',
	      'posts_per_page' 	=>  $value,
	      'post_status'   	=> 'publish',
	      'meta_query' 		=> array(
	         array(
	            'key' => 'featured',
	            'value' => '',
	            'compare' => '!='
	         )
	      )
	    );
	    // The Query
	    $query = new WP_Query( $args );
	    
	    ob_start();

	    foreach( $query->posts as $k => $post ) {

			$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
			$image = wp_get_attachment_image_src( $post_thumbnail_id, 'full', true );
			$image_src = $image[0];
			$url = get_post_meta( $post->ID, 'siteurl', true );
			$link = get_the_permalink( $post->ID );
			$title = $post->post_title;

			?>
			<div class="col-sm-3 ">
				<div class="image-container">
					<img src="<?php echo $image_src; ?>" alt="<?php echo $title; ?>" />
					<a class="showcase-overlay" href="<?php echo $link; ?>">
						<div class="inner"></div>
					</a>
				</div>
			</div>
			<?php
		}

		return ob_get_clean();
	}

  function section_template( ) {
		
	?>

		<div class="row-flex pl-sc-featured-grid" data-bind="plcallback: posts_count" data-callback="showcase">
			<?php echo $this->get_featured_showcase( $this->opt('posts_count') ); ?>
		</div>

	<?php

	}


}
