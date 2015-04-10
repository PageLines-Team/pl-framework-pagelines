<?php
/*
	Section: 		ShareBar
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	Adds ways to share content on pages/single posts
	Class Name: 	PageLinesShareBar
	Filter: 		localsocial
*/


class PageLinesShareBar extends PageLinesSection {

	function section_opts(){


		$opts = array(

			array(
				'type'	=> 'multi',
				'title'	=> __( 'Text', 'pagelines' ),
				'opts'	=> array(
					array(
						'type'	=> 'text',
						'key'	=> 'text',
						'label'	=> __( 'Description Text', 'pagelines' ),

					),
				)

			),


		);

		return $opts;

	}


    function section_template() { ?>

        <div class="pl-sharebar">
            <div class="pl-sharebar-pad">
				<?php echo pl_sharebar();?>
				<div class="txt-wrap pla-from-bottom pl-animation subtle" data-bind="visible: text"><div class="txt" data-bind="plsync: text"><?php echo $this->opt($text);?></div></div>
                <div class="clear"></div>
            </div>
        </div>
    <?php }





}