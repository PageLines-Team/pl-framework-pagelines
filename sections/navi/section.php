<?php
/*
	Section: 		Navi
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	A stylized navigation bar with multiple modes and styles.
	Class Name: 	PLNavi
	Filter: 		nav
	Levels: 		all
*/


class PLNavi extends PageLinesSection {


	function section_persistent(){
		register_nav_menus( array( 'navi_nav' => __( 'Navi Section', 'pagelines' ) ) );

	}

	function section_opts(){

		$opts = array(
			array(
				'type'	=> 'multi',
				'key'	=> 'navi_content',
				'title'	=> __( 'Logo', 'pagelines' ),
				'col'	=> 1,
				'opts'	=> array(
					array(
						'type'	=> 'image_upload',
						'key'	=> 'navi_logo',
						'label'	=> __( 'Navi Logo', 'pagelines' ),
						'has_alt'	=> true,
						'opts'	=> array(
							'center_logo'	=> 'Center: Logo | Right: Pop Menu | Left: Site Search',
							'left_logo'		=> 'Left: Logo | Right: Standard Menu',
						),
					),
					array(
						'type'		=> 'check',
						'key'		=> 'navi_logo_disable',
						'label'		=> __( 'Disable Logo?', 'pagelines' ),
						'default'	=> false
					)
				)

			),
			array(
				'type'	=> 'multi',
				'key'	=> 'navi_nav',
				'title'	=> 'Navigation',
				'col'	=> 2,
				'opts'	=> array(
					array(
						'key'	=> 'navi_help',
						'type'	=> 'help_important',
						'label'	=> __( 'Using Megamenus (multi column drop down)', 'pagelines' ),
						'help'	=> __( 'Want a full width, multi column "mega menu"? Simply add a class of "megamenu" to the list items using the WP menu creation tool.', 'pagelines' )
					),
					array(
						'key'	=> 'navi_menu',
						'type'	=> 'select_menu',
						'label'	=> __( 'Select Menu', 'pagelines' ),
					),
					array(
						'key'	=> 'navi_search',
						'type'	=> 'check',
						'label'	=> __( 'Hide Search?', 'pagelines' ),
					),
				)
			)
		);

		return $opts;

	}

	/**
	* Section template.
	*/
   function section_template( $location = false ) {

	?>
	<div class="navi-wrap fix">
		<div class="navi-content pl-content">
			<div class="navi-left navi-container">
				<a href="<?php echo home_url('/');?>" data-bind="visible: navi_logo_disable() == 0">
					<?php echo $this->image( 'navi_logo', pl_get_theme_logo(), array(), get_bloginfo('name')); ?>
				</a>
				
			</div>
			<div class="navi-right">

				<?php echo pl_dynamic_nav('navi_menu', $this->opt('navi_menu'), 'inline-list pl-nav sf-menu', 'navi-nav', 'superfish'); ?>

				<div class="navi-search" data-bind="visible: navi_search() == 0">
					<?php pagelines_search_form( true, 'navi-searchform'); ?>
				</div>
			</div>
			<div class="navi-left navi-search" data-bind="visible: navi_search() == 0"></div>
		</div>
	</div>
<?php }

}


