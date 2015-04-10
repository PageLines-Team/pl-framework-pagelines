<?php
/*
	Section: 		Highlight
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	Adds a highlight sections with a splash image and 2-big lines of text.
	Class Name: 	PageLinesHighlight
	Filter: 		component
*/

/**
 * Highlight Section
 *
 * @package PageLines DMS
 * @author PageLines
 */
class PageLinesHighlight extends PageLinesSection {

	var $tabID = 'highlight_meta';


	function section_opts(){
		$opts = array(
			array(
				'type' 			=> 'select',
				'title' 		=> __( 'Select Format', 'pagelines' ),
				'key'			=> '_highlight_splash_position',
				'label' 		=> __( 'Highlight Format', 'pagelines' ),
				'opts'=> array(
					'top'			=> array( 'name' => __( 'Image on top of text', 'pagelines' ) ),
					'bottom'	 	=> array( 'name' => __( 'Image on bottom of text' , 'pagelines' )),
					'notext'	 	=> array( 'name' => __( 'No text, just the image', 'pagelines' ) )
				),
			),
			array(
				'type' 			=> 'multi',
				'col'			=> 2,
				'title' 		=> __( 'Highlight Text', 'pagelines' ),
				'opts'	=> array(
					array(
						'key'			=> '_highlight_head',
						'version' 		=> 'pro',
						'type' 			=> 'text',
						'size'			=> 'big',
						'label' 		=> __( 'Highlight Header Text (Optional)', 'pagelines' ),
					),
					array(
						'key'			=> '_highlight_subhead',
						'version' 		=> 'pro',
						'type' 			=> 'textarea',
						'label' 		=> __( 'Highlight Subheader Text (Optional)', 'pagelines' ),
					)

				)
			),
			array(
				'type' 			=> 'multi',
				'col'			=> 3,
				'title' 		=> __( 'Highlight Image and Format', 'pagelines' ),
				'opts'	=> array(

					 array(
						'key'			=> '_highlight_splash',
						'type' 			=> 'image_upload',
						'label'			=> __( 'Upload Splash Image', 'pagelines' )
					),
					 
				)
			)

		);

		return $opts;

	}

	/**
	*
	* @TODO document
	*
	*/
	function section_template() {

		$head 	= $this->opt( '_highlight_head' );

		

		$subhead 	= $this->opt( '_highlight_subhead' );

		$splash 	= $this->opt( '_highlight_splash' );

		$splash_position = $this->opt( '_highlight_splash_position' );

		if( !$head && !$subhead && !$splash ){
			$head 		= __("Hello.", 'pagelines');
			$subhead 		= __("This is your Highlight section. Set up the options to configure.", 'pagelines');
		}

		?>
		<div class="highlight-area">

			<div class="highlight-splash hl-image-top" data-bind="visible: _highlight_splash_position() == 'top'  && _highlight_splash()">
				<img data-bind="plimg: _highlight_splash"  src="<?php echo $splash;?>" alt="" />
			</div>
			
			<div class="highlight-text" data-bind="visible: _highlight_splash_position() != 'notext'">
				<h2 class="highlight-head" <?php echo pl_bind_text('_highlight_head');?> ><?php echo $head; ?></h2>
				<div class="highlight-subhead" <?php echo pl_bind_text('_highlight_subhead');?>  ><?php echo $subhead; ?></div>
			</div>

			<div class="highlight-splash hl-image-bottom" data-bind="visible: _highlight_splash_position() != 'top' && _highlight_splash()">
				<img data-bind="plimg: _highlight_splash"  src="<?php echo $splash;?>" alt="" />
			</div>
		</div>

			<?php

		
	}
}