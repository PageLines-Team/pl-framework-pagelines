<?php
/*

	Section: 		Video Box
	Description: 	Displays HTML5 Video.

	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	
	Class Name: 	PLVideoBox
	Filter: 		advanced

*/


class PLVideoBox extends PageLinesSection {

	function section_persistent(){

		add_filter('pl_binding_videobox', array( $this, 'callback'), 10, 2); 

	}

	function section_opts(){

			$opts = array();

			$opts = array(
				array(
					'key'	=> 'upload_video',
					'type'	=> 'media_select_video',
					'label'	=> __( 'Upload Video', 'pagelines' ),
				),
				array(
					'key'	=> 'auto_play',
					'type'	=> 'check',
					'label'	=> __( 'Auto Play Video?', 'pagelines' ),
				),
				array(
					'key'	=> 'loop',
					'type'	=> 'check',
					'label'	=> __( 'Loop Video?', 'pagelines' ),
				),
				array(
					'key'	=> 'controls',
					'type'	=> 'check',
					'label'	=> __( 'Show Controls?', 'pagelines' ),
				),
			);

			return $opts;
	}

	/** Standard callback format */
	function callback( $response, $data ){

		$response['template'] = $this->get_videbox( $data['value'] );

		return $response;
	}

	function get_videbox( $value, $auto_play = false, $loop = false, $controls = false ) {

		ob_start();
		?>

	    <video <?php echo $auto_play; ?> loop controls>
		  <source src="<?php echo do_shortcode( $value ); ?>" type="video/mp4" />
		  Your browser does not support html5 video.
		</video>

		<?

		return ob_get_clean();
	}

  function section_template( ) {
		
	?>

		<div class="row-flex pl-video-box" data-bind="plcallback: upload_video, plsync: auto_play , plsync: loop, plsync: controls" data-callback="videobox">
			<?php echo $this->get_videbox( $this->opt('upload_video'), $this->opt('loop'), $this->opt('auto_play'), $this->opt('controls') ); ?>
		</div>

	<?php

	}


}
