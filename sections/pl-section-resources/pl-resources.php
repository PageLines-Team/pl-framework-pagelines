<?php
/*
  
  Plugin Name:    PL Resources
  Description:    Documentation and resources section

  Author:         PageLines
  Author URI:     http://www.pagelines.com

  Version:        1.0.0
  PageLines:      PL_Resources
  Filter:         advanced

*/


/**
 * Hybrid section/plugin - only run this first class on initial plugin load
 */
if( ! class_exists( 'PL_Resources_Config' )){

  /**
   * PLUGIN
   * Do this if the plugin is activated, whether or not there is a framework
   */


  class PL_Resources_Config {

    public static $post_type  = 'pl_resources';

    public static $taxonomy   = 'resource-chapter';

    function __construct(){

      add_action('init', array( $this, 'create_post_type' ) ); 

      $this->tax  = self::$taxonomy;
      $this->pt   = self::$post_type;

      add_action( $this->tax.'_add_form_fields', array( $this, 'taxonomy_add_new_meta_field'), 10, 2 );
      add_action( $this->tax.'_edit_form_fields', array( $this, 'taxonomy_edit_meta_field' ), 10, 2 );
      add_action( 'edited_'.$this->tax, array( $this, 'save_taxonomy_custom_meta' ), 10, 2 );  
      add_action( 'create_'.$this->tax, array( $this, 'save_taxonomy_custom_meta' ), 10, 2 );
    }

    function create_post_type(){

      register_post_type( self::$post_type,
        array(
          'labels' => array(
            'name'          => __( 'Resources' ),
            'singular_name' => __( 'Resource' )
          ),
          'public'        => true,
          'has_archive'   => true,
          'menu_icon'     => 'dashicons-media-text', 
          'menu_position' => 5,
          'rewrite'       => array( 'slug' => 'resources' )
        )
      );

      // Add new taxonomy, make it hierarchical (like categories)
      $labels = array(
        'name'              => _x( 'Chapters', 'taxonomy general name' ),
        'singular_name'     => _x( 'Chapter', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Chapters' ),
        'all_items'         => __( 'All Chapters' ),
        'parent_item'       => __( 'Parent Chapter' ),
        'parent_item_colon' => __( 'Parent Chapter:' ),
        'edit_item'         => __( 'Edit Chapter' ),
        'update_item'       => __( 'Update Chapter' ),
        'add_new_item'      => __( 'Add New Chapter' ),
        'new_item_name'     => __( 'New Chapter Name' ),
        'menu_name'         => __( 'Chapter' ),
      );

      $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'chapter' ),
      );

      register_taxonomy( self::$taxonomy, array( self::$post_type ), $args );

    }

    function save_taxonomy_custom_meta( $term_id ) {

      if ( isset( $_POST['term_meta'] ) ) {

        $term_meta = get_option( "taxonomy_$term_id" );

        $the_keys = array_keys( $_POST['term_meta'] );

        foreach ( $the_keys as $key ) {

          if ( isset ( $_POST['term_meta'][ $key ] ) ) {

            $term_meta[ $key ] = $_POST['term_meta'][ $key ];
          }

        }

        // Save the option array.
        update_option( "taxonomy_$term_id", $term_meta );
      }

    }  

    function taxonomy_edit_meta_field( $term ) {
     
     
      // retrieve the existing value(s) for this meta field. This returns an array
      $term_meta = get_option( "taxonomy_$term->term_id" ); 

      ?>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[icon_slug]"><?php _e( 'Term Icon Slug', 'pagelines' ); ?></label></th>
        <td>
          <input type="text" name="term_meta[icon_slug]" id="term_meta[icon_slug]" value="<?php echo esc_attr( $term_meta['icon_slug'] ) ? esc_attr( $term_meta['icon_slug'] ) : ''; ?>">
          <p class="description"><?php _e( 'Add the slug for the Font Awesome icon to associate with this taxonomy. Example: "save".','pagelines' ); ?></p>
        </td>
      </tr>
      <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[sort_order]"><?php _e( 'Term Sort Order', 'pagelines' ); ?></label></th>
        <td>
          <input type="text" name="term_meta[sort_order]" id="term_meta[sort_order]" value="<?php echo esc_attr( $term_meta['sort_order'] ) ? esc_attr( $term_meta['sort_order'] ) : ''; ?>">
          <p class="description"><?php _e( 'Enter a number. Lower numbers are listed first.','pagelines' ); ?></p>
        </td>
      </tr>
    <?php
    }

    


    function taxonomy_add_new_meta_field() {
      // this will add the custom meta field to the add new term page
      ?>
      <div class="form-field">
        <label for="term_meta[icon_slug]"><?php _e( 'Term Icon Slug', 'pagelines' ); ?></label>
        <input type="text" name="term_meta[icon_slug]" id="term_meta[icon_slug]" value="">
        <p class="description"><?php _e( 'Add the slug for the Font Awesome icon to associate with this taxonomy. Example: "save".','pagelines' ); ?></p>
      </div>
      <div class="form-field">
        <label for="term_meta[sort_order]"><?php _e( 'Term Sort Order', 'pagelines' ); ?></label>
        <input type="text" name="term_meta[sort_order]" id="term_meta[sort_order]" value="">
        <p class="description"><?php _e( 'Enter a number. Lower numbers are listed first.','pagelines' ); ?></p>
      </div>
    <?php
    }

    public function get_ordered_terms(){

      $terms = get_terms( $this->tax  );

      foreach( $terms as &$term ){

        $term->meta = get_option( "taxonomy_$term->term_id" );

        
      }

      uasort($terms, array( $this, 'cmp' ) );

      return $terms;

    }

    function cmp( $term1, $term2 ) {

        $a = ( isset( $term1->meta['sort_order'] ) && is_numeric( $term1->meta['sort_order'] ) ) ? $term1->meta['sort_order'] : 1000;
        $b = ( isset( $term2->meta['sort_order'] ) && is_numeric( $term2->meta['sort_order'] ) ) ? $term2->meta['sort_order'] : 1000;

        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }
  }

}
global $pl_resources_config;
$pl_resources_config = new PL_Resources_Config(); 

/**
 * 
 * SECTION
 * Only do the rest of PageLines Framework is activated
 * 
 */
if( ! class_exists( 'PageLinesSection' ) )
  return;



class PL_Resources extends PageLinesSection {

  function section_persistent(){

    $this->pt   = PL_Resources_Config::$post_type;
    $this->tax  = PL_Resources_Config::$taxonomy;

    global $pl_resources_config;
  
    $this->config = $pl_resources_config;
    
  }

  

  function section_styles(){
      
    
    
  }

  function section_template(){

    global $post; 
    
    $pt_name = get_post_type_object( get_post_type( ) )->labels->name;

    ?>

    <div class="pl-resources-mast">
      <div class="pl-content">
        <h4><a href="<?php echo get_post_type_archive_link( get_post_type( ) );?>"><?php echo ( ! is_archive() ) ? $pt_name : 'PageLines Framework';?></a></h4>
        <h1><?php (is_archive()) ? post_type_archive_title() : the_title();?></h1>

        <form class="pl-resources-search" action="<?php echo home_url( '/' ); ?>" method="get">
          <fieldset>
            <button type="submit" class="search-button" onClick="submit()">
              <i class="icon icon-search"></i>
            </button>
            <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" placeholder="Search Documentation..." />
            <?php echo ( pl_is_workarea_iframe() ) ? '<input type="hidden" name="workarea-iframe" value="1"/>' : ''; ?>
            <input type="hidden" value="<?php echo $this->pt;?>" name="post_type" id="post_type" />
          </fieldset>
        </form>
      </div>
    </div>
    <div class="pl-resources-content">
      <div class="pl-content">
        <div class="row">
          <div class="resources-entry col-sm-9">
            <div class="pad docnav-scan"><?php echo $this->get_content();?></div>
          </div>
          <sidebar class="resources-sidebar col-sm-3">
            <div class="pad js-stickaroo"><?php echo $this->get_sidebar();?></div>
          </sidebar>
        </div>
      </div>
    </div>
    <?php 
    
  }

  function get_content(){

    ob_start();

    if( is_search() ){
      $this->get_search();
    }

    else if( is_archive() ){
      $this->get_archive();
     
    }

    else if( is_single() ){
      $this->get_single();
    }

    

    return ob_get_clean();
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

  function get_sidebar(){
    ob_start(); 

    ?>
    <div class="widget">
      <h3 class="widgettitle">On This Page</h3>
      <ul class="resource-nav doclist-nav">

        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
      </ul>
    </div>

    <div class="widget">
      <h3 class="widgettitle">In Chapter</h3>
      <ul class="resource-nav doclist-nav">

        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
        <li><a>Whatever</a></li>
      </ul>
    </div>
    <?php 

    return ob_get_clean();
  }





}
