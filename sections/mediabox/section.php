<?php
/*
	Section: 		MediaBox
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A simple box for text and HTML.
	Class Name: 	PageLinesMediaBox
	Filter: 		basic
*/

class PageLinesMediaBox extends PageLinesSection {


	function section_opts(){
		$opts = array(
	
			array(
				'title'	=> __( 'MediaBox Media', 'pagelines' ), 
				'type'	=> 'multi',
			
				'opts'	=> array(
					array(
						'type' 			=> 'image_upload',
						'key'			=> 'mediabox_image',
						'label' 		=> __( 'MediaBox Image', 'pagelines' ),
						'has_alt'		=> true
					),
					array(
						'type' 			=> 'text',
						'key'			=> 'mediabox_title',
						'label' 		=> __( 'Title', 'pagelines' ),
					),
					array(
						'type' 			=> 'textarea',
						'key'			=> 'mediabox_html',
						'label' 		=> __( 'Text and Embed HTML', 'pagelines' ),
						'help'			=> __( 'Enter rich media "embed" HTML in this field to add videos, etc.. instead of an image.', 'pagelines' )
					),
					
				)
			),
			
			array(
				'title'	=> 'MediaBox Display', 
				'type'	=> 'multi',
				'col'	=> 2,
				'opts'	=> array(
					array(
						'type' 			=> 'select',
						'key'			=> 'mediabox_align',
						'label' 		=> __( 'Text/Media Alignment', 'pagelines' ),
						'opts'			=> array(
							'center'		=> array('name' => __( 'Align Center (Default)', 'pagelines' )),
							'textleft'		=> array('name' => __( 'Align Left', 'pagelines' )),
							'textright'		=> array('name' => __( 'Align Right', 'pagelines' )),
							'none'			=> array('name' => __( 'None', 'pagelines' )),
						)
					),
					array(
						'type'		=> 'select',
						'key'		=> 'mediabox_height',
						'default'	=> '350px',
						'label'	=> __( 'Select Height ( default 350px)', 'pagelines' ),
						'opts'	=> array(
							''		=> array( 'name' => 'Auto' ),
							'200px'	=> array( 'name' => '200px' ),
							'250px'	=> array( 'name' => '250px' ),
							'300px'	=> array( 'name' => '300px' ),
							'350px'	=> array( 'name' => '350px' ),
							'400px'	=> array( 'name' => '400px' ),
							'450px'	=> array( 'name' => '450px' ),
							'500px'	=> array( 'name' => '500px' ),
						)
					),
					array(
						'type' 			=> 'select_animation',
						'key'			=> 'mediabox_animation',
						'label' 		=> __( 'Viewport Animation', 'pagelines' ),
						'help' 			=> __( 'Optionally animate the appearance of this section on view.', 'pagelines' ),
					)
				
				)
			),
		

		);

		return $opts;

	}

	function section_template(){
		?>

		<div class="mediabox-wrap pl-animation fix"  data-bind="plclass: [{ tag: mediabox_animation(), partial: 'pla-'}], style: {'min-height': mediabox_height }">
			<div class="the-media fitvids pl-centered %s hentry">
				<?php echo $this->image( 'mediabox_image', $this->base_url.'/default.png' );?>
				<h3 data-bind="text: mediabox_title" ></h3>
				<div class="the-media-html" data-bind="html: mediabox_html">
					<?php echo do_shortcode( wpautop( $this->opt('mediabox_html') ) ); ?>
				</div>
			</div>
		</div>

		<?php
	}

	function old_section_template() {

		$image = $this->opt('mediabox_image');
		$media_html = $this->opt('mediabox_html');
		$disable_center = $this->opt('disable_centering');

		$title = ( $this->opt('mediabox_title') ) ? sprintf('<h3 data-sync="mediabox_title">%s</h3>', $this->opt('mediabox_title')) : '';
			
		$set_height = ( $this->opt('mediabox_height') )  ? $this->opt('mediabox_height') : 30;
		$height = sprintf('min-height: %spx', $set_height);
		


		if( $image || $media_html )
			$img = ( $this->opt( 'mediabox_image' ) ) ? $this->image( 'mediabox_image', $this->base_url.'/default.png' ) : '';
		elseif( ! $this->opt('mediabox_background') )
			$img = sprintf('<img data-sync="mediabox_image" src="%s" />', $this->base_url.'/default.png'); // DEFAULT
		else 
			$img = '';
		
		$classes = array(); 
		$align_class = array(); 
		
		$align = $this->opt('mediabox_align');
		
		if($align == 'right')
			$align_class = 'textright alignright';
		elseif($align == 'left')
			$align_class = 'textleft alignleft';
		elseif($align == 'none')
			$align_class = '';
		else
			$align_class = 'center';
		
		
		$classes[] = ($disable_center) ? '' : 'pl-centerer';
		$classes[] = ($this->opt('mediabox_animation')) ? $this->opt('mediabox_animation') : 'pla-fade';
		
		
		
		
		$html = do_shortcode( wpautop( $media_html ) );
		
		printf(
			'<div class="mediabox-wrap %s pl-animation fix" %s style="%s">
				<div class="the-media fitvids pl-centered %s hentry">
					%s %s
					<div class="the-media-html">%s</div>
				</div>
			</div>', 
			join(' ', $classes), 
			$height_sync_data,
			$height, 
			$align_class,
			$img, 
			$title,
			$html
		);
	
		
	}
}


