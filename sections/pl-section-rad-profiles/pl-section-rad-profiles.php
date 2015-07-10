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

    add_filter( 'pl_connect_profile_settings_array',          array( $this, 'add_profile_settings' ) ); 
  }

  function section_opts(){
    $opts = array(
      
      array(
        'type'      => 'multi',
        
        'opts'  => array(
          array(
            'key'       => 'help',
            'type'      => 'help',
            'help'      => sprintf( '<p>This section uses "user profile" options. These are configured on each user profile edit page.<br/> <a href="%s">Visit your user profile page &rarr;</a>.</p>', admin_url('profile.php') ),
          ),

        )
      ),
      

    );

    return $opts;

  }

  function add_profile_settings( $settings ){

    $settings['business'] = array(
      'key'       => 'business',
      'icon'      => 'phone',
      'pos'       => 10, 
      'title'     => __( 'Business Info' , 'pagelines' ),
      'opts'  => array(


        array(
         'key'           => 'picasso_name',
         'type'          => 'text',
         'title'         => __( 'Business Name', 'pagelines' ),
        ),
        array(
         'key'           => 'picasso_city',
         'type'          => 'text',
         'title'         => __( 'Business City', 'pagelines' ),
        ),
        array(
         'key'           => 'picasso_country',
         'type'          => 'text',
         'title'         => __( 'Business Country', 'pagelines' ),
        ),
        array(
         'key'           => 'picasso_twitter',
         'type'          => 'text',
         'title'         => __( 'Business Twitter', 'pagelines' ),
        ),
        array(
         'key'           => 'picasso_bio',
         'type'          => 'textarea',
         'title'         => __( 'Your Business Bio', 'pagelines' ),
        ),
        array(
         'key'           => 'contact_url',
         'type'          => 'text',
         'title'         => __( 'Your Contact URL', 'pagelines' ),
         'label'         => __( 'Add a link for users to contact you?', 'pagelines' ),
        ),
      )
    ); 
    

    return $settings;
  }

  function section_template(){

    global $wp_query;

    /** Only for use on author profile pages. */
    if( ! is_author() ){
      if(current_user_can('edit_themes')){
        printf('<div class="alert">The "Rad Profile" section is used here but is designed for usely solely on author profile pages.</div>'); 
      }
      
      return;
    }

    $author           = get_user_by( 'slug', get_query_var( 'author_name' ) );

    $country          = get_user_meta( $author->ID, 'picasso_country', true );
    $city             = get_user_meta( $author->ID, 'picasso_city', true );


    $user_email       = get_the_author_meta( 'user_email', $author->ID);

    $twitter          = get_user_meta( $author->ID, 'picasso_twitter', true );
    $site             = get_user_meta( $author->ID, 'user_url', true );

    $contact          = get_user_meta( $author->ID, 'contact_url', true );

   
    $user_description = get_the_author_meta( 'picasso_bio', $author->ID);

    
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
        
          <?php if( ! empty( $site) ):?>
          <a itemprop="url" href="<?php echo $site;?>" title="Website" target="_blank"><i class="icon icon-globe"></i> <?php echo $site;?></a>
          <?php endif; ?>

          <?php if( ! empty( $twitter )):?>
          <a href="https://twitter.com/<?php echo $twitter;?>" title="Twitter" target="_blank"><i class="icon icon-twitter"></i> <?php echo $twitter;?></a>
          <?php endif;?>


        </div>

        <?php if( ! empty( $contact )):?>
          <div class="rad-profile-contact">
            <a class="btn btn-primary" href="<?php echo $contact;?>" title="Contact" target="_blank"><i class="icon icon-pencil"></i> Contact Me</a>
          </div>
        <?php endif;?>

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
