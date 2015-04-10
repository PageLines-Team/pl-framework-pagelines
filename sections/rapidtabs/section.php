<?php
/*
	Section: 		RapidTabs
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	Displays your most popular, and latest posts as well as comments and tags in a tabbed format.
	Class Name: 	PLRapidTabs
	Filter: 		wordpress
*/

class PLRapidTabs extends PageLinesSection {

	function section_persistent(){

		$this->show_popular = ( function_exists('get_most_viewed') ) ? true : false;

	}
	
	function section_styles(){
		pl_enqueue_script( 'jquery-ui-tabs' );
		pl_enqueue_script( 'pl-rapidtabs', 	$this->base_url.'/rapidtabs.js', array( 'jquery' ), pl_get_cache_key(), true );
	}
	


	function section_opts(){
	
		$options = array();

		$notify = ( ! $this->show_popular ) ? '<p><div class="alert alert-info">Plugin Not Activated</div></p>' : '';

		$options[] = array(
			'type'		=> 'link',
			'url'		=> 'https://wordpress.org/plugins/wp-postviews/',
			'title'		=> 'Get "WP Postviews"',
			'label'		=>	'<i class="icon icon-external-link"></i> Check out plugin',
			'help'		=> "RapidTabs needs this plugin to show your most popular posts. ".$notify,

		);
		
		return $options;
		
	}

	function list_posts( $posts ){


		foreach( $posts as $p ){

			$thumb_url = (has_post_thumbnail( $p->ID )) ? pl_the_thumbnail_url( $p->ID, 'thumbnail') : pl_default_image('thumbnail');

			$img = sprintf('<div class="img"><a class="the-media" href="%s" style="background-image: url(%s)"></a></div>', get_permalink( $p->ID ), $thumb_url);

			printf(
				'<li class="media fix">%s<div class="bd"><a class="title" href="%s">%s</a><span class="excerpt">%s</span></div></li>', 
				$img,
				get_permalink( $p->ID ), 
				$p->post_title, 
				pl_short_excerpt($p->ID)
			);

		}

	}

   function section_template() {
		
		global $plpg; 
		$pageID = $plpg->id;

		$num_posts = 6;

		$pop_posts = get_posts( array(
					'ignore_sticky_posts' 	=> 1, 
					'orderby' 				=> 'meta_value_num', 
					'meta_key' 				=> 'views', 
					'order' 				=> 'desc',
					'exclude' 				=> $pageID
				) );

		?>
	<div class="widget">
		<div class="widget-pad">
	<div class="the-rapid-tabs">
		<ul class="tabbed-list rapid-nav fix">
			<?php if($this->show_popular && ! empty( $pop_posts )):?>
				<li><a href="#rapid-popular"><?php _e( 'Popular', 'pagelines' ); ?></a></li>
			<?php endif;?>
			<li><a href="#rapid-recent"><?php _e( 'Recent', 'pagelines' ); ?></a></li>
			<li><a href="#rapid-comments"><?php _e( 'Comments', 'pagelines' ); ?></a></li>
			<li><a href="#rapid-tags"><?php _e( 'Tags', 'pagelines' ); ?></a></li>
		</ul>

	<?php if($this->show_popular && !empty( $pop_posts )):?>
		<div id="rapid-popular">	
			<ul class="media-list">
				<?php $this->list_posts( $pop_posts ); ?>
			</ul>
	
		</div>
	<?php endif;?>
		<div id="rapid-recent">
			
				<ul class="media-list">
					<?php

					$posts = get_posts( array(
						'numberposts' 			=> $num_posts, 
						'ignore_sticky_posts' 	=> 1, 
						'orderby'				=> 'post_date', 
						'order' 				=> 'desc',
						'exclude' 				=> $pageID
					) );


					$this->list_posts( $posts );

				?>


				</ul>
		</div>

		<div id="rapid-comments">
			
			<ul class="quote-list">
				<?php  echo pl_recent_comments();  ?>

			</ul>
			
		</div>
		<div id="rapid-tags">
				
				<div class="tags-list">
					<?php

					wp_tag_cloud( array('number'=> 30, 'smallest' => 10, 'largest' => 10) );
					 ?>


				</div>
		
		</div>
				
		</div>
	</div>
</div>
		<?php
		
		


	}



	
}


