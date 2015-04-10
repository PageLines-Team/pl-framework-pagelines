<?php
/*
	Section: 		Flipper
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A great way to flip through posts. Simply select a post type and done.
	Class Name: 	PageLinesFlipper
	Filter: 		carousel
*/

class PageLinesFlipper extends PageLinesSection {


	var $default_limit = 3;


	function section_styles(){
		pl_enqueue_script( 'caroufredsel', 	$this->base_url.'/script.caroufredsel.js',	array( 'jquery' ), pl_get_cache_key(), true );
		pl_enqueue_script( 'touchswipe', 	$this->base_url.'/script.touchswipe.js', 	array( 'jquery' ), pl_get_cache_key(), true );
		pl_enqueue_script( 'flipper', 		$this->base_url.'/script.flipper.js', 		array( 'jquery' ), pl_get_cache_key(), true );
	}

	function section_opts(){

		
		$options = array();

		$options[] = array(

			'title' => __( 'Config', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
		
				array(
					'key'		=> 'flipper_format',
					'type'		=> 'select',
					'label'		=> __( 'Layout Format', 'pagelines' ),
					'opts'			=> array(
						'grid'		=> array('name' => __( 'Grid', 'pagelines' ) ),
						'masonry'	=> array('name' => __( 'Image Only', 'pagelines' ) )
					), 
					'default'	=> 'grid'
				),
				array(
					'key'			=> 'flipper_shown',
					'type' 			=> 'count_select',
					'count_start'	=> 1,
					'count_number'	=> 6,
					'default'		=> 3,
					'label' 		=> __( 'Max Number of Posts Shown', 'pagelines' ),
					'help'		=> __( 'This controls the maximum number of posts shown. A smaller amount may be shown based on layout width.', 'pagelines' ),
				),
				array(
					'key'		=> 'flipper_hide_nav',
					'type'		=> 'check',
					'label'		=> __( 'Hide Nav?', 'pagelines' )
				),
				

			)

		);

		$options[] = array(

			'title' => __( 'Flipper Content', 'pagelines' ),
			'col'	=> 2,
			'type'	=> 'multi',
			'help'		=> __( 'Options to control the text and link in the Flipper title.', 'pagelines' ),
			'opts'	=> array(
				array(
					'key'			=> 'flipper_title',
					'type' 			=> 'text',
					'label' 		=> __( 'Flipper Title Text', 'pagelines' ),
				),
				array(
					'key'			=> 'flipper_hide_title_link',
					'type' 			=> 'check',
					'label' 	=> __( 'Hide Title Link?', 'pagelines' ),

				),
				array(
					'key'			=> 'flipper_show_excerpt',
					'type' 			=> 'check',
					'label' 	=> __( 'Show excerpt?', 'pagelines' ),

				),
				array(
					'key'			=> 'disable_flipper_show_love',
					'type' 			=> 'check',
					'label' 	=> __( 'Disable social button/count?', 'pagelines' ),

				),
				


			)

		);

		$options['post'] = array(

			'title' => __( 'Flipper Post Type', 'pagelines' ),
			'type'	=> 'get_posts',
			'key'	=> 'flipper_posts',
			'opts'	=> pl_get_post_type_options( array( 'post_image_size' => true ))

		);

		return $options;
	}
	

	function section_template(  ) {

		global $post;
		$post_type = ($this->opt('flipper_post_type')) ? $this->opt('flipper_post_type') : 'post';

		$pt = get_post_type_object($post_type);


		
		if( $this->opt('flipper_category') && $this->opt('flipper_category') != '' ){
			$cat = get_category_by_slug( $this->opt('flipper_category') ); 
			$the_query['category'] = $cat->term_id;
		}


		$archive_link = get_post_type_archive_link( $post_type );
		$archive_text = __(' / View All', 'pagelines');

		if ( $post_type == 'post' && get_option( 'page_for_posts') && !is_home() ){

			$archive_link = get_page_uri( get_option( 'page_for_posts') );
			$archive_text = __(' / View Blog', 'pagelines');

		} else {
			$archive_link = get_post_type_archive_link( $post_type );
			$archive_text = __(' / View All', 'pagelines');
		}

		?>
				
		
	<div class="flipper-heading" data-bind="visible: flipper_hide_nav() == 0">
		<div class="flipper-heading-wrap">
			<div class="flipper-title pl-standard-title">
				<span class="the-title" data-bind="plsync: flipper_title"><?php echo $pt->label;?></span>
				<a href="" data-bind="visible: flipper_hide_title_link() == 0" href="<?php echo $archive_link;?>" ><?php echo $archive_text;?></a>
				
			</div>
			<a class="flipper-prev nav-button btn btn-default btn-sm" href="#"><i class="icon icon-angle-left"></i></a>
	    	<a class="flipper-next nav-button btn btn-default btn-sm" href="#"><i class="icon icon-angle-right"></i></a>
		</div>
	</div>
		
	<div class="flipper-wrap ">

		<ul class="flipper-items list-unstyled text-align-center layout-grid flipper" data-bind="attr: { 'data-shown': flipper_shown }, plclass: [{ tag: $root.flipper_format(), partial: 'layout-' }]"  data-scroll-speed="800" data-easing="easeInOutQuart" data-shown="3" >
			<!-- ko foreachTrigger: flipper_posts -->
				<li class="flipper-carousel-item">
					<div class="flipper-item fix">
						<img height="400" width="600" src="<?php echo pl_default_image();?>" alt="Post Image" data-bind="plimg: $data.post_thumb"/>
						
						<div class="flipper-info-bg"></div>
					
						<a class="flipper-info pl-center-inside" href="#" data-bind="href: $data.post_link">

							<div class="pl-center-table">
								<div class="pl-center-cell">
									<div class="hover-text" data-bind="if: $root.flipper_format() == 'masonry'">
							            <h4 data-bind="text: $data.post_title"></h4>
										<div class="metabar" data-bind="text: $data.post_date"></div>
							        </div>
							        <div class="hover-text" data-bind="ifnot: $root.flipper_format() == 'masonry'">
							            <div class="info-text"><i class="icon icon-link"></i></div>
							        </div>

									
								</div>
							</div>
							
						</a>
					</div>
					<div class="flipper-meta"  data-bind="ifnot: $root.flipper_format() == 'masonry'">
						
						<span class="karma" data-bind="visible: $root.disable_flipper_show_love() == 0, html: $data.post_karma"></span>
						
						<h4 class="flipper-post-title" >
							<a href="#" data-bind="text: $data.post_title, href: $data.post_link"></a>
						</h4>
						<div class="flipper-metabar">
							<span class="post-date" data-bind="text: $data.post_date"></span>
							<a href="#" data-bind="visible: $data.post_edit, href: $data.post_edit">[Edit]</a>
							
						</div>
						
						<div class="flipper-excerpt pl-border" data-bind="visible: $root.flipper_show_excerpt() != 0, text: $data.post_excerpt"></div>
						
						
					</div>
					<div class="clear"></div>
				</li>
			<!-- /ko -->
		</ul>
	</div>
<?php 

	}

	




}