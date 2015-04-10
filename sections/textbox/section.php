<?php
/*
	Section: 		TextBox
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A simple box for text and HTML.
	Class Name: 	PageLinesTextBox
	Filter: 		basic
	Levels: 		all
*/

class PageLinesTextBox extends PageLinesSection {


	function section_opts(){
		$opts = array(
			array(
				'type'		=> 'multi',
				'key'		=> 'textbox_text', 
				'opts'		=> array(
					array(
						'type' 			=> 'text',
						'key'			=> 'textbox_title',
						'label' 		=> __( 'Title (Optional)', 'pagelines' ),
					),
									
					array(
						'type' 			=> 'textarea',
						'key'			=> 'textbox_content',
						'label' 		=> __( 'Text Content', 'pagelines' ),
					),
					
				)
			),
			
			
			
		);

		return $opts;

	}

	function section_template(){
?>
	<div class="textbox-wrap">
		<h3 data-bind="visible: textbox_title, plsync: textbox_title"><?php $this->opt('textbox_title');?></h3>
		<div class="hentry" data-bind="plsync: textbox_content, sync_mode: 'autop'">
			<?php echo do_shortcode( wpautop( $this->opt( 'textbox_content' ) ) ); ?>
		</div>
	</div>
	


<?php 
	}

}


