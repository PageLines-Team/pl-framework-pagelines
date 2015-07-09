<?php
/*
  
  Plugin Name:    PageLines Section Showcase
  Description:    An advanced socialized showcase that allows users to upload submissions to your site. As seen on PageLines.com.

  Author:         PageLines
  Author URI:     http://www.pagelines.com

  Version:        5.0.0
  
  PageLines:      PL_Picasso_Showcase

  Filter:         advanced

*/

if( class_exists( 'PageLinesSection' ) ){

class PL_Picasso_Showcase extends PageLinesSection {

  function section_persistent(){

    $this->pt         = 'picasso-showcase';
    $this->tax_tags   = 'picasso-tags';
    $this->tax_cats   = 'picasso-genres';



    
  }

  


  function section_template(){

    global $post; 
    
    $pt_name = get_post_type_object( get_post_type( ) )->labels->name;

    ?>

    <div class="pl-showcase-mast">
      <div class="pl-content">
        <h4><a href="<?php echo get_post_type_archive_link( get_post_type( ) );?>"><?php echo ( ! is_archive() ) ? $pt_name : 'PageLines Framework';?></a></h4>
        <h1><?php (is_archive()) ? post_type_archive_title() : the_title();?></h1>

        <form class="pl-showcase-search" action="<?php echo home_url( '/' ); ?>" method="get">
          <fieldset>
            <button type="submit" class="search-button" onClick="submit()">
              <i class="icon icon-search"></i>
            </button>
            <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="Search..." />
            <?php echo ( pl_is_workarea_iframe() ) ? '<input type="hidden" name="workarea-iframe" value="1"/>' : ''; ?>
            <input type="hidden" value="<?php echo $this->pt;?>" name="post_type" id="post_type" />
          </fieldset>
        </form>
      </div>
    </div>
    <div class="pl-showcase-content">
      <div class="pl-content">
        <div class="row">
          <div class="showcase-sidebar col-sm-2">
            <div class="pad">
              <?php echo $this->showcase_navigation();?>
            </div>
          </div>
          <div class="showcase-entry col-sm-8">
            <div class="pad">
              <?php echo $this->get_content();?>
            </div>
          </div>
          <sidebar class="showcase-sidebar col-sm-2">
            <div class="pad">
              <?php echo $this->get_sidebar();?>
            </div>
          </sidebar>
        </div>
      </div>
    </div>
    <?php 
    
  }

  function showcase_navigation(){ 
    ?>
    <div class="picasso-stacked-nav">
      <div class="widget">
        <h3 class="widgettitle">Showcase</h3>

        <ul class="nav nav-tabs nav-stacked nav-stacked-special">
         <li class="showcase-all"><a href="<?php echo get_post_type_archive_link( get_post_type( ) );?>">All</a></li>
         <li class="showcase-latest"><a href="<?php echo site_url( '/showcase/sites/latest/' ); ?>">Latest</a></li>
         <li class="showcase-popular"><a href="<?php echo site_url( '/showcase/sites/popular/' ); ?>">Popular</a></li>
        </ul>
      </div>
      <div class="widget">
        <h3 class="widgettitle">Categories</h3>

        <ul class="nav nav-tabs nav-stacked nav-stacked-special">

         <?php
         $args = array(
             'orderby'      => 'name',
             'show_count'   => 0,
             'pad_counts'   => 0,
             'hierarchical' => 0,
             'taxonomy'     => 'picasso-genres',
             'title_li'     => ''
         );
         wp_list_categories($args);
         ?>
       </ul>
      </div>

   </div>
  <?php 
}

  function get_content(){

    ob_start();

    if( is_search() ){
      $this->get_search();
    }

    else if( is_page() ){
      $this->get_showcase_home();
     
    }

    else if( is_archive() ){
      $this->get_archive();
     
    }

    else if( is_single() ){
      $this->get_single();
    }

    

    return ob_get_clean();
  }

  function get_showcase_home(){

    echo $this->draw_grid( $this->get_items( array( 'type'  => 'featured',  'posts_per_page' => 6 ) ) );
    echo $this->draw_grid( $this->get_items( array( 'type'  => 'popular',   'posts_per_page' => 6 ) ) );
    echo $this->draw_grid( $this->get_items( array( 'type'  => 'new',       'posts_per_page' => 6 ) ) );

  }

  function draw_grid( $args ){
     ob_start();

     foreach( $args['posts'] as $post ):

    ?>
    
     <div class="col-sm-4">

       <div class="showcase-item">
         <a class="showcase-item-image pl-bg-cover" href="<?php echo get_the_permalink( $post->ID ); ?>" style="background-image: url(<?php echo pl_the_thumbnail_url( $post->ID );?>)">
           <span class="showcase-item-overlay">View</span>
         </a>
         <div class="showcase-item-meta showcase-meta-title">
           <a class="showcase-meta-title" href="<?php echo get_the_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a>
         </div>
           <?php //echo picasso_showcase_get_likes( $post->ID ); ?>
       </div>
         

     </div>

     <?php endforeach; 

     $items_html = ob_get_clean(); 

     return sprintf('<div class="grid-header"><h4>%s</h4></div><div class="row">%s</div>', ucfirst($args['type']), $items_html);

  }

  function get_items( $args = array() ){


    $defaults = array(
        'post_type'       => 'picasso-showcase',
        'post_status'     => 'publish',
        'posts_per_page'  => 16,
        'type'            => 'new'
      );

    $args = wp_parse_args( $args, $defaults );


    if( 'featured' == $args['type'] ){

      $args['meta_query'] = array(
         array(
            'key'       => 'featured',
            'value'     => '',
            'compare'   => '!='
         )
      );

    }

    $query = new WP_Query( $args );

    $args['posts'] = $query->posts;

    return $args;

  }

  function get_search(){

    while ( have_posts() ) : the_post(); ?>
            
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <?php the_content();?>
         
    <?php endwhile; 

  }

  function get_single(){
?>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php 
    the_content();

  }

  function get_archive(){

     $terms = $this->config->get_ordered_terms();
    
    foreach( $terms as $term ) {

        $term_meta = get_option( "taxonomy_$term->term_id" ); 
     
        // Define the query
        $args = array(
            'post_type'   => $this->pt,
            $this->tax    => $term->slug
        );
        $query = new WP_Query( $args );

        $icon = ( isset($term->meta['icon_slug']) && $term->meta['icon_slug'] != '' ) ? $term->meta['icon_slug'] : 'pagelines';

        $icon = str_replace( 'icon-', '', $icon );

        ?>
        <div class="resource-chapter media fix">
          <div class="chapter-icon img"><i class="icon icon-<?php echo $icon;?>"></i></div>
          
          <div class="chapter-items bd">
          <h3><?php echo $term->name;?></h3>
          <div class="sub"><?php echo $term->description;?></div>
          <ul>
        <?php 

        while ( $query->have_posts() ) : $query->the_post(); ?>
         
            <li class="chapter-list-item" id="post-<?php the_ID(); ?>">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </li>
      
        <?php endwhile; ?>
          </ul>
          </div>
        </div>
 <?php         
    }

  }

  // use wp.com stats to get top 3 trending sites based on views.
  function get_trending( $count = 30 ) {

    $all = array();

    if( function_exists( 'stats_get_csv' ) ){

      $all = stats_get_csv( 'postviews', array( 'days' => 40, 'limit' => $count ) );

      foreach( $all as $k => $post ) {
        if( 'picasso-showcase' !== get_post_type( $post['post_id'] ) )
          unset( $all[$k] );
      }

      
    }

    return $all;
  }


  function get_sidebar(){
    ob_start(); 

    $trending = $this->get_trending();
    $featured = $this->get_items( array( 'type'  => 'featured',  'posts_per_page' => 12 ) );
    ?>
    <div class="widget">
      <h3 class="widgettitle">Trending</h3>
      <ul class="widgetlist">
        <?php foreach( $trending as $post ): ?>
          <li><?php echo $post->post_title;?></li>
        <?php endforeach;?>
      </ul>
    </div>

  
    <div class="widget">
      <h3 class="widgettitle">Featured</h3>
      <ul class="resource-nav doclist-nav">
        <?php foreach( $featured['posts'] as $post ): ?>
          <li><a href="<?php echo get_the_permalink( $post->ID ); ?>"><?php echo $post->post_title;?></a></li>
        <?php endforeach;?>
      </ul>
    </div>
    <?php 

    return ob_get_clean();
  }





}

} /** End Section Class **/

if( ! class_exists('PL_Showcase_Configuration') ){



class PL_Showcase_Configuration {


  function __construct() {

    $this->pt         = 'picasso-showcase';
    $this->tax_tags   = 'picasso-tags';
    $this->tax_cats   = 'picasso-genres';


    $this->create_post_type();

    add_filter( 'pl_connect_meta_settings_array', array( $this, 'add_meta_settings' ) ); 

    add_filter( 'pl_connect_profile_settings_array', array( $this, 'add_profile_settings' ) ); 

    add_action( 'pagelines_options_showcase_author_details', array( $this, 'author_details' ) );


    add_action( 'trashed_post',                                     array( $this, 'trash_post_rename' ),1 ,1 );

  }

  function add_meta_settings( $settings ){

    if( $this->pt == get_current_screen()->post_type ){

      $settings[$this->pt] = array(
          'key'       => 'about',
          'icon'      => 'thumb-tack',
          'pos'       => 10, 
          'location'  => 'post',
          'title'     => __( 'Showcase' , 'pagelines' ),
          'opts'  => array(

            array(
             'key'           => 'featured',
             'type'          => 'checkbox',
             'title'         => __( 'Feature This Item', 'pagelines' ),
             'help'          => __( 'Select to feature this item.', 'pagelines' ),
            ),

            array(
              'key'           => 'siteurl',
              'type'          => 'text',
              'title'         => __( 'Item Site URL', 'pagelines' )
            ),

            array(
              'key'           => 'showcase_author_details',
              'type'          => 'showcase_author_details',
              'title'         => __( 'Author Details', 'pagelines' )
            ),



          )
        ); 

    }

    

    return $settings;
  }

  function add_profile_settings( $settings ){

    $settings[$this->pt] = array(
      'key'       => 'about',
      'icon'      => 'user',
      'pos'       => 10, 
      'location'  => 'post',
      'title'     => __( 'Showcase Info' , 'pagelines' ),
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
         'key'           => 'picasso_hireme',
         'type'          => 'checkbox',
         'title'         => __( 'User Contact', 'pagelines' ),
         'label'         => __( 'Allow users to contact you?', 'pagelines' ),
        ),
      )
    ); 
    

    return $settings;
  }

  function create_post_type(){

    register_post_type( $this->pt,
      array(

        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-media-text', 
        'menu_position' => 5,
        'rewrite'       => array( 'slug' => 'showcase/items' ),
        'query_var'     => true,
        'has_archive'   => true,

        'labels' => array(
          'name'          => __( 'Showcase' ),
          'singular_name' => __( 'Showcase Item' )
        ),
        
        'supports' => array(
          'title',
          'excerpt',
          'editor',
          'author',
          'thumbnail'
        ),
        'capabilities' => array(
          'publish_posts'       => 'manage_options',
          'edit_posts'          => 'manage_options',
          'edit_others_posts'   => 'manage_options',
          'delete_posts'        => 'manage_options',
          'delete_others_posts' => 'manage_options',
          'read_private_posts'  => 'manage_options',
          'edit_post'           => 'manage_options',
          'delete_post'         => 'manage_options',
          'read_post'           => 'manage_options',
        ),
      )
    );

    $tax_defaults = array(
      'hierarchical'      => true,
      'labels'            => array(),
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'showcase/genre' ),
    );



    $args = wp_parse_args( array(
        'labels'  => array(
                      'name'              => __( 'Showcase Genres', 'pagelines' ),
                      'singular_name'     => __( 'Showcase Genre', 'pagelines' )
                    ), 
        'rewrite' => array( 'slug' => 'showcase/genre' )
      ), $tax_defaults );

    register_taxonomy( $this->tax_cats, array( $this->pt ), $args );

    $args = wp_parse_args( array(
        'labels'  => array(
                      'name'              => __( 'Showcase Tags', 'pagelines' ),
                      'singular_name'     => __( 'Showcase Tag', 'pagelines' )
                    ), 
        'rewrite' => array( 'slug' => 'showcase/tags' )
      ), $tax_defaults );

    register_taxonomy( $this->tax_tags, array( $this->pt ), $args );

  }

  /*
    When we trash/reject a site, free up the slug so its available next time they submit.
  */
  function trash_post_rename( $post ) {


    $post = get_post( $post );

    if( $post->post_type === 'picasso-showcase' ) :

      $digits = 8;
      
      $post_name = sprintf( '%s_%s', $post->post_name, rand(pow(10, $digits-1), pow(10, $digits)-1) );
      
      $args = array (
          'ID'        => $post->ID,
          'post_name' => $post_name,
          'post_status' => 'trash'
      );
    
      wp_update_post( $args );
    
    endif;
  }



  function author_details() {

    global $post;
    $author = $post->post_author;

    $default  = '<strong><span style="color:red">&nbsp;&#10008;</span></strong>';
    $good     = '<strong><span style="color:lightgreen">&nbsp;&nbsp;&#10004;</span></strong>';

    $name     = ( get_user_meta( $author, 'picasso_name', true ) )    ? get_user_meta( $author, 'picasso_name', true ) . $good : $default;
    $country  = ( get_user_meta( $author, 'picasso_country', true ) ) ? get_user_meta( $author, 'picasso_country', true ) . $good : $default;
    $city     = ( get_user_meta( $author, 'picasso_city', true ) )    ? get_user_meta( $author, 'picasso_city', true ) . $good : $default;
    $twitter  = ( get_user_meta( $author, 'picasso_twitter', true ) ) ? get_user_meta( $author, 'picasso_twitter', true ) . $good : $default;

    printf( '<p><strong>Name:</strong> %s</p><p><strong>City:</strong> %s</p><p><strong>Country:</strong> %s</p><p><strong>Twitter:</strong> %s</p>',
      $name,
      $city,
      $country,
      $twitter
    );

  }



 
}

new PL_Showcase_Configuration;

} /** End Config Class **/
