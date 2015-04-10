<?php
/*
 * Template Name: My Custom Page
 * Description: - - -
 */


$opts = array(
	array(
		'key'		=> 'post_content',
		'col'		=> 1,
		'type'		=> 'edit_post',
		'title'		=> __( 'Edit Post Content', 'pagelines' ),
		'label'		=>	__( '<i class="icon icon-pencil"></i> Edit Post Info', 'pagelines' ),
		'help'		=> __( 'This section uses WordPress posts. Edit post information using WordPress admin.', 'pagelines' ),
		'classes'	=> 'btn-primary'
	),
	);

pl_add_sync_settings( $opts );


get_header(); ?>

<div  class="pl-content">
	<div class="row">
		<div class="col-sm-4">123</div>
		<div class="col-sm-4">123</div>
		<div class="col-sm-4">123</div>
	</div>
</div>

<?php get_footer(); ?>
