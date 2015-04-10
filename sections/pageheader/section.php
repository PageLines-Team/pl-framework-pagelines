<?php
/*
	Section: 		PageHeader
	Author:	 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A dynamic page header area that supports image background and sub navigation.
	Class Name: 	PLPageHeader
	Filter: 		component
*/

class PLPageHeader extends PageLinesSection {

	
	function section_opts(){
		$options = array();
		
		$options['config'] = array(
			'title' => __( 'Header Config', 'pagelines' ),
			'type'	=> 'multi',
			'opts'	=> array(
				
				array(
					'key'			=> 'ph_format',
					'label' 		=> __( 'Format', 'pagelines' ),
					'type'			=> 'select',
					'opts'	=> array(
						'format-standard'	=> array('name'=> 'Text On Left'),
						'format-center'		=> array('name'=> 'Centered'),
					)
				),
			)
		);
		$options['content'] = array(
			'title' => __( 'Header Text', 'pagelines' ),
			'type'	=> 'multi',
			'col'	=> 2,
			'opts'	=> array(
				array(
					'key'			=> 'ph_header',
					'type' 			=> 'text',
					'label' 		=> __( 'Header Text', 'pagelines' ),
				),
				array(
					'key'			=> 'ph_sub',
					'type' 			=> 'text',
					'label' 		=> __( 'Header Sub Text', 'pagelines' ),
				),
			)
		);

		$options['link1'] = array(
				'title'			=> __( 'Link 1', 'pagelines' ),
				'type'			=> 'multi',
				'stylize'		=> 'button-config',
				'opts'			=> pl_button_link_options('ph_link1')
			);

		$options['link2'] = array(
				'title'			=> __( 'Link 2', 'pagelines' ),
				'type'			=> 'multi',
				'stylize'		=> 'button-config',
				'opts'			=> pl_button_link_options('ph_link2')
			);
		

		return $options;

	}


	function section_template() {
		
		$title = ( $this->opt('ph_header') ) ? $this->opt('ph_header') : pl_smart_page_title();
		$text = ( $this->opt('ph_sub') ) ? $this->opt('ph_sub') : pl_smart_page_subtitle();
		
		?>
		<div class="pl-ph-container pl-area-wrap  pl-animation pl-slidedown fix " >
			<div class="pl-end-height pl-content fix pl-flex-row format-standard" data-bind="plclass: ph_format, partial: 'format-'">
				<div class="ph-text">
					<h2 class="ph-head" data-bind="plsync: ph_header"><?php echo do_shortcode($title); ?></h2>
					<div class="ph-sub" data-bind="plsync: ph_sub"><?php echo do_shortcode($text); ?></div>
				</div>
				<div class="ph-meta pl-vertical-center pl-flex-right">
					<div class="buttons">
					<?php 
					
						echo pl_dynamic_button('ph_link1'); 
						echo pl_dynamic_button('ph_link2'); 
					
						
					 ?>
					 </div>
				</div>
			</div>
		</div>
	<?php

	}
}
