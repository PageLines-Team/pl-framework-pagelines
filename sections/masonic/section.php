<?php
/*
	Section: 		Masonic Gallery
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A robust gallery section that includes sorting and lightboxing.
	Class Name: 	PLMasonic
	Filter: 		grid
	Levels:			all
*/

class PLMasonic extends PageLinesSection {


	function section_persistent(){

		/** Add a custom binding callback */
		add_filter('pl_sync_binding_masonic_nav', array( $this, 'sync_masonic_nav'), 10, 2); 

	}

	function section_styles(){
		
		pl_enqueue_script( 'pl-masonic', $this->base_url.'/pl.masonic.js', array( 'jquery' ), pl_get_cache_key(), true );
		
	}

	function sync_masonic_nav( $response, $data ){

		$response['template'] = $this->masonic_nav( $data['value'] );

		return $response;
	}


	/**
	 * Gets the filtered navigation
	 * @param  string $filter_tax taxonomy slug
	 * @return template             string template
	 */
	function masonic_nav( $filter_tax = 'category' ){

	
		$posts = pl_section_posts( $this );
		$out = '';
		$filters = array();

		foreach( $posts as $post ){
			$terms = wp_get_post_terms( $post['id'], $filter_tax );


			foreach( $terms as $t ){
				$filters[ $t->slug ] = $t->name;
			}

		}

		$list = get_categories( array('taxonomy' => $filter_tax) );

		/** Remove if no posts have this filter */
		if( is_array( $list ) && ! empty( $list ) ){
			foreach( $list as $key => $l ){

				if( ! isset( $filters[$l->slug] ) )
					unset( $list[$key] );

			}
		}

		
		ob_start();
		?>

		<lh><?php _e( 'Sort', 'pagelines' ); ?>:</lh>
		<li class="pl-link"><a href="#" data-filter="*"><?php _e( 'All', 'pagelines' ); ?></a></li>

		<?php
		if( is_array( $list ) && ! empty( $list ) ){
			foreach( $list as $key => $l ){
				printf('<li><a href="#" data-filter="%s">%s</a></li>', $l->slug, ucwords($l->name) );
			}
		}

		?>

		<?php 
		

		return ob_get_clean();
	}

	

	function section_opts(){


		$options = array();

		$options[] = array(

			'title' => __( 'Config', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				array(
					'key'		=> 'masonic_format',
					'type'		=> 'select',
					'label'		=> __( 'Gallery Format', 'pagelines' ),
					'opts'			=> array(
						'grid'		=> array('name' => __( 'Grid Mode', 'pagelines' ) ),
						'masonry'	=> array('name' => __( 'Image/Masonry', 'pagelines' ) )
					)
				),
				array(
					'key'			=> 'masonic_excerpt',
					'type' 			=> 'check',
					'default'		=> false,
					'label' 		=> __( 'Display Post Excerpt In Grid Mode', 'pagelines' ),
				), 
				array(
					'key'			=> 'default_title',
					'type' 			=> 'text',
					'label' 		=> __( 'Default Title', 'pagelines' ),
				),


			)

		);

	
		$options['post'] = array(

			'title' => __( 'Post Items', 'pagelines' ),
			'type'	=> 'get_posts',
			'key'	=> 'posts',
			'opts'	=> pl_get_post_type_options( array( 'post_image_size' => true ))

		);


		return $options;
	}



	

	function section_template() {

?>


		<div class="masonic-wrap">
			<div class="masonic-header pl-area-ui-element">
				<div class="masonic-header-wrap">
					<div class="masonic-header-content-pad fix">
						<div class="masonic-title" data-bind="plsync: default_title"><?php echo $this->opt('default_title'); ?></div>
						<ul class="masonic-nav inline-list list-unstyled" data-bind="plsync: post_tax, sync_mode: 'masonic_nav'">
							<?php echo $this->masonic_nav( $this->opt('post_tax') ); ?>
						</ul>
					</div>
				</div>
			</div>


			<script type="text/html" id="masonry-item-template">
				<li class="response-item pl-iso" data-bind="plclass: $data.post_filters, partial: 'filter-'">
					<div class="pl-iso-wrap pl-media-grid">
						<div class="grid-media fix">
							<img height="400" width="600" src="<?php echo pl_default_image();?>" alt="Post Image" data-bind="plimg: $data.post_thumb"/>

							<div class="grid-media-hover"></div>

							<a class="grid-media-info" href="#" data-bind="href: $data.post_link">

								<div class="pl-center-table"><div class="pl-center-cell">

									<div class="hover-text" data-bind="if: $root.masonic_format() == 'masonry'">
							            <h4 data-bind="text: $data.post_title"></h4>
										<div class="metabar" data-bind="text: $data.post_date"></div>
							        </div>
							        <div class="hover-text" data-bind="ifnot: $root.masonic_format() == 'masonry'">
							            <div class="info-text"><i class="icon icon-link"></i> VIEW</div>
							        </div>
								</div></div>

							</a>
						</div>
						
						<div class="pl-grid-content fix" data-bind="ifnot: $root.masonic_format() == 'masonry'">
							<div class="fix">
								<div class="pl-grid-meta">
									<span class="karma" data-bind=" html: $data.post_karma"></span>
								</div>
								<div class="pl-grid-text">
									<h4 class="post-title" >
										<a href="#" data-bind="text: $data.post_title, href: $data.post_link"></a>
									</h4>
									<div class="metabar">
										<span class="post-date" data-bind="text: $data.post_date"></span>
										<a href="#" data-bind="visible: $data.post_edit, href: $data.post_edit" target="_blank">[Edit]</a>
										
									</div>
									<!-- <span data-bind="text: ko.toJSON($data.post_edit)"></span> -->
									<div class="the-excerpt pl-border" data-bind=" text: $data.post_excerpt"></div>
									
								</div>
							</div>
							
							<div class="pl-grid-excerpt pl-border">
								<div class="the-excerpt pl-border" data-bind=" text: $data.post_excerpt"></div>
							</div>
							
							
						</div>
						

						<div class="clear"></div>
					</div>

				</li>
			</script>

			<ul class="masonic-gallery response-row list-unstyled no-transition pl-iso-container clearfix" data-bind="pltemplate: {name: 'masonry-item-template', foreach:posts()}, plcss: {'with-gutter': $root.masonic_format() != 'masonry' }, attr: {'data-format': $root.masonic_format()}">
				Test static content
			</ul>	
	


			</div>
<?php
	
	}






}
