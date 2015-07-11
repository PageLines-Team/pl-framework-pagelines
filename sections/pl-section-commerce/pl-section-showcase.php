<?php
/*
  
  Plugin Name:    PageLines Section Digital Commerce
  Description:    An advanced socialized showcase that allows users to upload submissions to your site. As seen on PageLines.com.

  Author:         PageLines
  Author URI:     http://www.pagelines.com

  Version:        5.0.0
  
  PageLines:      PL_Digital_Commerce

  Filter:         advanced

*/

if( class_exists( 'PageLinesSection' ) ){

class PL_Digital_Commerce extends PageLinesSection {

  function section_persistent(){



    global $plpg;
    $this->page       = $plpg;


    //$this->config     = new PL_Digital_Commerce_Config;



  }

  function section_opts(){
    $opts = array(
      
      array(
        'type'      => 'multi',
        
        'opts'  => array(
          array(
            'key'       => 'help',
            'type'      => 'help',
            'help'      => sprintf( '<p><a href="%s" class="btn btn-xs btn-primary">Admin Settings</a></p><p>This section is designed to operate on different post types related to your showcase. For example, the showcase home, archive, single and category pages. Add it to all of these types and you will see the showcase as designed.<br/> <strong>Note:</strong> This section makes heavy use of permalinks, if you have an issue make sure to regenerate them by saving them on <a href="%s">this page</a>.</p>', admin_url('admin.php?page=pl-connect-settings&settings_tab=picasso-showcase'), admin_url('options-permalink.php') ),
          ),

        )
      ),
      

    );

    return $opts;

  }


  function section_template(){

    global $post; 
    
    $pt_name = get_post_type_object( get_post_type( ) )->labels->name;


    ?>
    
    <?php if( is_page() && ! isset( $_GET['type'] ) ):?>
    <div class="pl-showcase-mast">
      <div class="pl-content">
        <h4><a href="<?php echo get_post_type_archive_link( get_post_type( ) );?>"><?php echo pl_setting('showcase_for', get_bloginfo('name'));?></a></h4>
        <h1><?php echo $this->config->title;?></h1>

        <form class="pl-showcase-search" action="<?php echo home_url( '/' ); ?>" method="get">
          <fieldset>
            <button type="submit" class="search-button" onClick="submit()">
              <i class="icon icon-search"></i>
            </button>
            <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="Search..." />
            <?php echo ( pl_is_workarea_iframe() ) ? '<input type="hidden" name="workarea-iframe" value="1"/>' : ''; ?>
            <input type="hidden" value="<?php echo $this->config->pt;?>" name="post_type" id="post_type" />
          </fieldset>
        </form>
      </div>
    </div>
    
    <?php endif;?>

    <div class="pl-showcase-content">
      <div class="pl-content">
        <div class="row">
          <div class="showcase-sidebar col-sm-2">
            <div class="pad">
              <?php echo $this->showcase_navigation();?>
            </div>
          </div>
          <div class="showcase-entry col-sm-8 top-on-mobile">
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
        <h3 class="widgettitle"><?php echo $this->config->title;?></h3>

        <ul class="nav nav-tabs nav-stacked nav-stacked-special">
         <li class="showcase-all"><a href="<?php echo get_post_type_archive_link( $this->config->pt );?>">All</a></li>
         <li class="showcase-latest"><a href="<?php echo site_url( $this->config->rewrite_base . '?type=latest' ); ?>">Latest</a></li>

         <li class="showcase-popular"><a href="<?php echo site_url( $this->config->rewrite_base . '?type=popular' ); ?>">Popular</a></li>
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
             'taxonomy'     => $this->config->tax_cats,
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

    global $plpg;
    $this->page = $plpg;

    ob_start();

    if( is_search() ){
      echo $this->draw_grid( $this->get_items( array( 'type'  => 'search', 's' => $_GET['s'] ) ) );
    }

    else if( is_page() ){
      $this->get_showcase_page();
     
    }

    else if( is_archive() ){

      echo $this->draw_grid( $this->get_items( array( 'type'  => $this->page->get_current_page_name(), 'use_query' => true ) ) );
     
    }

    else if( is_single() ){
      $this->get_single();
    }

    

    return ob_get_clean();
  }

  function get_showcase_page(){

    

    if( isset($_GET['type']) ){

      echo $this->draw_grid( $this->get_items( array( 'type'  => $_GET['type'],  'posts_per_page' => 30 ) ) );

    } 

    else{
      echo $this->draw_grid( $this->get_items( array( 'type'  => 'featured',  'posts_per_page' => 6 ) ) );
      echo $this->draw_grid( $this->get_items( array( 'type'  => 'popular',   'posts_per_page' => 6 ) ) );
      echo $this->draw_grid( $this->get_items( array( 'type'  => 'new',       'posts_per_page' => 9 ) ) );
    }

   

  }

  function draw_grid( $args ){

    if( empty($args['posts']) ){
      return '';
    }

    ob_start();

    foreach( $args['posts'] as $post ):

    ?>
    
     <div class="col-sm-4">

       <div class="showcase-item">
         <a class="showcase-item-image grid-media aspect pl-bg-cover" href="<?php echo get_the_permalink( $post->ID ); ?>" style="background-image: url(<?php echo pl_the_thumbnail_url( $post->ID );?>)">
           <span class="showcase-item-overlay grid-media-info"><span class="info-text">View</span></span>
         </a>
         <div class="showcase-item-meta showcase-meta-title meta-title">
           <a class="showcase-meta-title" href="<?php echo get_the_permalink( $post->ID ); ?>"><?php echo $post->post_title; ?></a>
         </div>
        
       </div>
         

     </div>

     <?php endforeach; 

     $items_html = ob_get_clean(); 



     return sprintf('<div class="grid-header"><h4>%s</h4></div><div class="row pl-media-grid">%s</div>', ucfirst($args['type']), $items_html);

  }

  function add_to_profile( $author_ID ){
    echo $this->draw_grid( $this->get_items( array( 'type'  => 'On ' . $this->config->title, 'author'=> $author_ID ) ) );
  }

  function get_items( $args = array() ){

    if( isset($args['use_query']) && true == $args['use_query'] ){
      global $wp_query;
      $q = $wp_query->query;
    }
    else {
      $q = array();
    }

    


    $defaults = wp_parse_args( array(
        'post_type'       => 'picasso-showcase',
        'post_status'     => 'publish',
        'posts_per_page'  => 30,
        'type'            => 'new'
      ), $q);

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

    elseif( 'similar' == $args['type'] ){

      global $post;

      $args['tax_query'] = array(
          array(
              'taxonomy'  => $this->config->tax_tags,
              'field'     => 'id',
              'terms'     => wp_get_object_terms($post->ID, $this->config->tax_tags, array('fields'=>'ids'))
          )
      );

    }

    elseif( 'popular' == $args['type'] ){

      /** Return most viewed showcase items */
     return $this->get_trending( -1 );

    }

    

    $query = new WP_Query( $args );

    $args['posts'] = $query->posts;

    return $args;

  }

  
  function get_single(){

    global $wp_query, $post;

    $author_id = get_the_author_meta('ID');
    
    $url      = get_post_meta( $post->ID, 'siteurl', true );
    
    $agency   = get_user_meta( $author_id, 'picasso_name', true );

    $country  = get_user_meta( $author_id, 'picasso_country', true );
    $city     = get_user_meta( $author_id, 'picasso_city', true );
    $author   = get_the_author('');

    $agency = sprintf(' <a href="%s%s">%s</a>', site_url( '/author/' ), get_the_author_meta('user_login'), $agency );

    
    if( $city ){
      $loc = sprintf(' from %s, %s', $city, $country);
    }

    $url = get_post_meta( $post->ID, 'siteurl', true );

    $content = get_the_content();

    if( empty($content) )
      $content = get_the_excerpt();


    $go = pl_setting('pl_go_text', 'Check it out');

    ?>
    <div class="row">
      <div class="col-sm-6">
        <a href="<?php echo $url;?>" class="showcase-item-image grid-media aspect pl-bg-cover" style="background-image: url(<?php echo pl_the_thumbnail_url( $post->ID );?>)">
          <span class="grid-media-info"><?php echo $go;?></span>
        </a>

        
      </div>

      <div class="col-sm-6 pl-flex-vertical">

        <div class="showcase-actions">

          <h2 class="entry-title"><?php echo get_the_title(); ?></h2>
          <div class="metabar showcase-metabar">

          <?php printf( '<span class="panel-author">By <em>%s</em>%s</span>', $agency, $loc ); ?>
          <div class="s-tags">
            Tags: <?php echo get_the_term_list( get_the_ID(), $this->config->tax_tags, "") ?>
          </div>

          </div>
        
          <div class="site-details-cta">
            <?php if($url):?>
              <a href="<?php echo $url;?>" class="btn btn-primary btn-large" target="_blank"><?php echo $go;?></a>
            <?php endif;?>

            <?php if( true == get_the_author_meta( 'picasso_hireme', $author_id ) ):?>
              <a href="<?php echo site_url( '/author/' . get_the_author_meta('user_login'));?>" class="btn btn-default btn-large">About The Designer</a>
            <?php endif;?>

            
          </div>
        </div>

      </div>
    </div>

    <div class="hentry showcase-item-content">
      <?php echo $content; ?>          
    </div>
        
    <div class="similar-sites">
      <?php echo $this->draw_grid( $this->get_items( array( 'type' => 'similar', 'posts_per_page' => 6 ) ) );?>
    </div>
        
        


    <?php

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

    <?php if( ! empty( $trending ) ): ?>
    <div class="widget">
      <h3 class="widgettitle">Trending</h3>
      <ul class="widgetlist">
        <?php foreach( $trending as $post ): ?>
          <li><?php echo $post->post_title;?></li>
        <?php endforeach;?>
      </ul>
    </div>
    <?php endif; ?>
  
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

if( ! class_exists('PL_Digital_Commerce_Config') ){



class PL_Digital_Commerce_Config {


  function __construct() {

    $this->pt         = 'picasso-showcase';
    $this->tax_tags   = 'picasso-tags';
    $this->tax_cats   = 'picasso-genres';

    $this->rewrite_base = pl_setting('base_rewrite_slug', 'showcase');

    $this->title        = pl_setting('showcase_title', 'Showcase');




    add_filter( 'pl_connect_meta_settings_array',             array( $this, 'add_meta_settings' ) ); 

    add_filter( 'pl_connect_profile_settings_array',          array( $this, 'add_profile_settings' ) ); 

    add_filter( 'pl_connect_settings_array',                  array( $this, 'add_global_settings') );

    add_action( 'pagelines_options_showcase_author_details',  array( $this, 'author_details' ) );


    add_action( 'trashed_post',                                     array( $this, 'trash_post_rename' ),1 ,1 );

  }

  function add_global_settings( $settings ){

    $settings[$this->pt] = array(
      'key'       => $this->pt,
      'icon'      => 'cubes',
      'pos'       => 350, 
      'title'     => $this->title,
      'opts'  => array(

        array(
         'key'        => 'showcase_title',
         'type'       => 'text',
         'title'      => __( 'Showcase Title', 'pagelines' ),
         'help'       => __( 'What is the name of your showcase? Maybe just "Showcase" ;)', 'pagelines' ),
         'place'      => 'Showcase'
        ),
        array(
         'key'        => 'showcase_for',
         'type'       => 'text',
         'title'      => __( 'Showcase Subject', 'pagelines' ),
         'help'       => __( 'What are you showcasing? Use singular term. Example: Website, PageLines, Design, etc...', 'pagelines' ),
         'place'      => get_bloginfo('name')
        ),

        array(
         'key'        => 'base_rewrite_slug',
         'type'       => 'text',
         'title'      => __( 'Base Permalink Rewrite Slug', 'pagelines' ),
         'help'       => sprintf(__( 'This section uses custom post types, which operate across several pages in your site. As such, we need a base slug relative to your site url, that you would like to build permalinks on... Note: once changed, you will need to save your <a href="%s">permalink settings</a> for effect.', 'pagelines' ), admin_url('options-permalink.php')),
         'place'      => 'showcase'
        ),


      )
    ); 

    

    return $settings;
  }

  function add_meta_settings( $settings ){

    if( $this->pt == get_current_screen()->post_type ){

      $settings[$this->pt] = array(
          'key'       => $this->pt,
          'icon'      => 'cubes',
          'pos'       => 10, 
          'location'  => $this->pt,
          'title'     => $this->title,
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

    $user_fields = array( 'picasso_name', 'picasso_city', 'picasso_country', 'picasso_twitter', 'contact_url', 'picasso_bio');

    $li = '';
    foreach( $user_fields as $field ){
      $li .= sprintf('<li><strong>%s</strong>: %s</li>', explode('_', $field)[1], get_user_meta( $author, $field , true ));
    }

    printf( '<h4>Profile field values</h4><ul>%s</ul>', $li );

  }



 
}



} /** End Config Class **/
