<?php
/*
	Section:		Docker
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	The easiest way to add docs to WordPress. Docker has a sticky sidebar and can use any registered post type.
	Class Name: 	PLDocker
	Filter: 		advanced
*/

class PLDocker extends PageLinesSection {


	function section_styles(){
		pl_enqueue_script( 'stickysidebar', $this->base_url.'/stickysidebar.js', 	array( 'jquery' ), pl_get_cache_key(), true );
		pl_enqueue_script( 'pl-docker',		$this->base_url.'/pl.docker.js', 		array( 'jquery', 'stickysidebar' ), pl_get_cache_key(), true );
	}

	function section_opts(){

		
		$options = array();

		$options['help'] = array(
			'title' => __( 'Using This Section', 'pagelines' ),
			'type'	=> 'multi',
			'col'	=> 1,
			'opts'	=> array(
				array(
					'key'		=> 'help',
					'type'		=> 'link',
					'label'		=> __( 'Using Docker', 'pagelines' ),
					'help'		=> __( 'Using Docker is simple. Usually, it requires two steps.<p>1. Docker uses a custom post type of your choosing. So you probably want to use a plugin to create a custom post type and select it in Docker options.</p><p>2. You will need to add Docker to both its root page and to the template for the custom post type you have created.</p>', 'pagelines' ),
				),
				array(
					'key'		=> 'nav_title',
					'type'		=> 'text',
					'label'		=> __( 'Nav Title (Optional)', 'pagelines' ),
				),
			)
		);

		
		$options['post'] = array(

			'title' => __( 'Nav Post Type', 'pagelines' ),
			'type'	=> 'get_posts',
			'key'	=> 'nav_posts',
			'opts'	=> pl_get_post_type_options()

		);


		
	


		return $options;
	}


	function section_template(  ) {

		global $post;
		
		$posts = $this->get_posts();

		?>
		<div class="docker-wrapper" data-bind="">
			<div class="docker-sidebar pl-border">
				<div class="docker-mobile-drop pl-contrast">Select <i class="icon icon-caret-down"></i></div>
				<ul class="list-unstyled theme-list-nav">
					<lh data-bind="visible: nav_title() != '', text: nav_title"></lh>
					 <!-- ko foreach: nav_posts -->
			        <li><a href="#" data-bind="href: $data.post_link"><span data-bind="text: $data.post_title"></span></a></li>
				    <!-- /ko -->
			
				</ul>
			</div>
			<div class="docker-content hentry">
				<h2 class="docker-title"><?php the_title(); ?></h2>
				<?php the_content(); ?>
				<?php echo do_shortcode('[post_edit]'); ?>
			</div>
		</div>
		<?php 
	}




}

