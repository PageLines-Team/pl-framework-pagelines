<?php
/*
	Section: 		PostAuthor
	Author: 		PageLines
	Author URI: 	http://www.pagelines.com
	Description: 	Adds author information to pages and posts.
	Class Name: 	PageLinesPostAuthor
	Filter: 		wordpress

*/

class PageLinesPostAuthor extends PageLinesSection {

	function section_opts(){
		global $post;

		if(!$post || !is_object($post))
			return '';

		$author_id = $post->post_author;

		$opts = array(
			array(
				'key'		=> 'author_setup',
				'type'		=> 'link',
				'url'		=> admin_url( 'user-edit.php?user_id='.$author_id ),
				'title'		=> __( 'Author Setup', 'pagelines' ),
				'label'		=> '<i class="icon icon-edit"></i> Edit Author Info',
				'help'		=> __( "This section uses the author's profile information.<br/> Set that in your admin.", 'pagelines' ),
			)
		);

		return $opts;
	}

	/**
	* Section template.
	*/
   function section_template() {

	global $post;
	setup_postdata($post);

	ob_start();
		the_author_meta('url');
	$link = ob_get_clean();

		$author_id 			= $post->post_author;
		$default_avatar 	= PL_IMAGES . '/avatar_default.gif';
		$author_email 		= get_the_author_meta('email', $author_id);
		$author_name 		= get_the_author_meta( 'user_nicename' , $author_id);
		$author_desc 		= get_the_author_meta( 'description', $author_id);
		$gplus 				= get_the_author_meta( 'googleplus', $author_id );
		$twitter 			= get_the_author_meta( 'twitter', $author_id );
		$post_url 			= get_author_posts_url( $author_id, $author_name );
		$num_posts 			= count_user_posts( $author_id );
		$edit_user 			= admin_url( 'user-edit.php?user_id='.$author_id );
?>
		<div class="media author-info">
			<div class="media-left author-thumb">
				<a class="thumbnail" href="<?php echo $link; ?>" target="_blank">
					<?php echo get_avatar( $author_email, '120', $default_avatar); ?>
				</a>
			</div>
			<div class="media-body">

				<div class="pl-type-tag author-note"><?php _e('Author', 'pagelines');?></div>
				
				<h2><a href="<?php echo $post_url;?>"><?php echo ucfirst($author_name); ?></a></h2>

				<p><?php echo $author_desc; ?></p>

				<?php if( $num_posts > 0){
					 printf('<p><a href="%s">%s</a> has written %s posts.</p>', $post_url, ucfirst($author_name), count_user_posts($author_id));
				}
				?>

				<p class="author-details">
					<?php

					if( $link != '' )
						printf( '<a href="%s" class="btn btn-primary" target="_blank"><i class="icon icon-external-link"></i> %s</a> ', $link, __( 'Visit Author\'s Website', 'pagelines') );

					if ( $google_profile )
						printf( '<a href="%s" class="btn btn-default" rel="me"><i class="icon icon-google-plus"></i> %s</a>',  $google_profile, __( 'On Google+', 'pagelines' ) );

					if ( $twitter )
						printf( '<a href="%s" class="btn btn-default" rel="me"><i class="icon icon-twitter"></i> %s</a>',  $twitter, __( 'On Twitter', 'pagelines' ) );

					if( current_user_can('edit_theme_options') )
						printf( '<a href="%s" class="btn btn-default" target="_blank"><i class="icon icon-edit"></i> %s</a>',  $edit_user, __( 'Edit Author Profile', 'pagelines' ) );
					?>
				</p>
			</div>

		</div>
		<div class="clear"></div>
<?php	}
}