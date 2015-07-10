<?php
/*
  
  Plugin Name:    PageLines Section Rad Profiles
  Description:    An advanced user profile that can be extended. As seen on PageLines.com.

  Author:         PageLines
  Author URI:     http://www.pagelines.com

  Version:        5.0.0
  
  PageLines:      PL_Rad_Profiles

  Filter:         advanced

*/

if( class_exists( 'PageLinesSection' ) ){

class PL_Rad_Profiles extends PageLinesSection {

  function section_persistent(){


  }

  function section_template(){

    global $wp_query;

    $author           = get_user_by( 'slug', get_query_var( 'author_name' ) );
    $country          = get_user_meta( $author->ID, 'picasso_country', true );
    $city             = get_user_meta( $author->ID, 'picasso_city', true );
    $user_url         = get_the_author_meta( 'user_url', $author->ID);
      
    $user_email       = get_the_author_meta( 'user_email', $author->ID);

   
    $user_description = get_the_author_meta( 'picasso_bio', $author->ID);

    if( true == get_the_author_meta( 'picasso_hireme', $author->ID) )
      $hire_me = '<a href="#fancyboxID-1" class="hire-me btn btn-primary">Hire Me</a>';

    
    ?>
  <div class="pl-content" itemscope itemtype="schema.org/Person">
    <div class="rad-profile">
      <div class="avatar" itemprop="image" >
        <?php echo get_avatar( $user_email, '120', $this->base_url . '/avatar_default.gif');?>
      </div>
      <div class="rad-profile-details">
        <h2 class="user_name"><span itemprop="name"><?php echo get_user_meta( $author->ID, 'picasso_name', true );?></span></h2>
        <div class="user-details metabar">
          <?php echo sprintf( '<a class="" href="#" title="%s, %s"><i class="icon icon-map-marker"></i> %s, %s</a>', $city, $country, $city, $country );?>
          <a itemprop="url" href="%s" title="Website" target="_blank"><i class="icon icon-globe"></i> <?php echo get_user_meta( $author->ID, 'user_url', true );?></a>
          <a href="https://twitter.com/%s" title="Twitter" target="_blank"><i class="icon icon-twitter"></i> <?php echo get_user_meta( $author->ID, 'picasso_twitter', true );?></a>
        </div>



        <div class="hentry">
         <?php echo get_the_author_meta( 'picasso_bio', $author->ID);?>
        </div>
      </div>
      <div class="rad-author-additions">
        <?php do_action( 'pl_rad_profile_additions', $author->ID );?>
      </div>
      <div class="rad-author-posts">
        <?php echo $this->draw_grid( $this->get_author_posts($author->ID));?>
      </div>
    </div>
  </div>
<?php
  }

  function draw_grid( $posts ){

    $list = '';
    foreach( $posts as $post ){

      $list .= sprintf('<div class="col-sm-4"><h4><a href="%s">%s</a></h4><div class="exc">%s</div></div>', get_permalink( $post->ID ), $post->post_title, pl_excerpt_by_id( $post->ID  ) );

    }

    return sprintf('<div class="row">%s</div>', $list);
  }

  function get_author_posts( $id ){


    $args = array( 
      'author' =>  $id, 
      'posts_per_page' => 15 
    ); 

    $q = new WP_Query( $args );

    return $q->posts;

  }

}

} /** End Section Class **/
