<?php
/*
	Section: 		SimpleNav
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	Creates a simple single line navigation. Select menu and alignment.
	Class Name: 	SimpleNav
	Filter: 		nav
*/


class SimpleNav extends PageLinesSection {

	/**
	 * Always load the registered menu
	 */
	function section_persistent(){
		register_nav_menus( array( 'simple_nav' => __( 'Simple Nav Section', 'pagelines' ) ) );

	}

	function section_opts(){
		$opts = array(
			array(
				'key'		=> 'simple_nav_menu_multi',
				'type' 		=> 'multi',
				'title'		=> __( 'Select Menu', 'pagelines' ),
				'help'		=> __( 'The SimpleNav uses WordPress menus. Select one for use.', 'pagelines' ),
				'opts'		=> array(
					array(
							'key'			=> 'simple_nav_menu' ,
							'type' 			=> 'select_menu',
							'label' 	=> __( 'Select Menu', 'pagelines' ),
						),
				),
			),
		);

		return $opts;
	}


   function section_template() {
		echo pl_dynamic_nav('simple_nav_menu', $this->opt('simple_nav_menu'), '', '', 'quicklinks');
	}

}
