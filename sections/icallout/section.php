<?php
/*
	Section: 		iCallout
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A quick call to action for your users
	Class Name: 	PLICallout
	Filter: 		component
*/

class PLICallout extends PageLinesSection {

	var $tabID = 'highlight_meta';


	function section_opts(){
		$opts = array(
			array(
				'type' 			=> 'select',
				'title' 		=> 'Select Format',
				'key'			=> 'icallout_format',
				'label' 		=> __( 'Callout Format', 'pagelines' ),
				'opts'=> array(
					'top'			=> array( 'name' => __( 'Text on top of button', 'pagelines' ) ),
					'inline'	 	=> array( 'name' => __( 'Text/Button Inline', 'pagelines' ) )
				),
			),
			array(
				'type' 			=> 'multi',
				'col'			=> 2,
				'title' 		=> __( 'Callout Text', 'pagelines' ),
				'opts'	=> array(
					array(
						'key'			=> 'icallout_text',
						'version' 		=> 'pro',
						'type' 			=> 'text',
						'label' 		=> __( 'Callout Text', 'pagelines' ),
					),
				)
			),
			array(
				'title'			=> __( 'Button', 'pagelines' ),
				'type'			=> 'multi',
				'opts'			=> pl_button_link_options('icallout_link')
			)
			

		);

		return $opts;

	}

	function section_template() {

		$text = $this->opt('icallout_text');
		
		$link = $this->opt('icallout_link');
		
		// $format = ( $this->opt('icallout_format') ) ? 'format-'.$this->opt('icallout_format') : 'format-inline';
		// $link_target = ( $this->opt( 'icallout_target' ) ) ? ' target="_blank"': '';
		// $theme = $this->opt('icallout_btn_theme', array( 'default' => 'btn-primary' ) );
		// $link_text = $this->opt('icallout_link_text', array( 'default' => 'More <i class="icon icon-angle-right"></i>' ) );
		// $text_wrap = ( '' != $this->opt( 'icallout_text_wrap' ) ) ? $this->opt( 'icallout_text_wrap' ) : 'h2';

		if( ! $text && ! $link ){
			$text = __("Hello.", 'pagelines');
		}

		
		?>
		<div class="icallout-container" data-bind="css: { inline: icallout_format() != 'top' }">

			<h2 class="icallout-head" <?php echo pl_bind_text('icallout_text');?> ><?php echo $text;?></h2>

			<?php pl_dynamic_button( 'icallout_link', 'btn-primary icallout-action'); ?>
			

		</div>
	<?php

	}
}
