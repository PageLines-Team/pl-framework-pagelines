<?php



// ------------------------------------------
// SINGLE PRODUCT PAGE
// ------------------------------------------

add_filter('wp_enqueue_scripts', 'pl_woo_add_jquery_tabs');
function pl_woo_add_jquery_tabs(){

  $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );

  if ( is_page( $myaccount_page_id )) {
    wp_enqueue_script( 'jquery-ui-tabs' );
  }
}

// ------------------------------------------
// ADDITIONAL SORTING OPTIONS
// ------------------------------------------

add_filter( 'woocommerce_get_catalog_ordering_args', 'pl_get_catalog_ordering_args' );
function pl_get_catalog_ordering_args( $args ) {

  $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

  if ( 'random_list' == $orderby_value ) {
    $args['orderby'] = 'rand';
    $args['order'] = '';
    $args['meta_key'] = '';
  }

  if ( 'featured' == $orderby_value ) {
    $args['orderby'] = 'desc';
    $args['order'] = '';
    $args['meta_key'] = '_featured';
    $args['meta_value'] = 'yes';
  }

  return $args;
}

// add_filter( 'woocommerce_default_catalog_orderby_options', 'pl_woocommerce_catalog_orderby' );

// Modify the default WooCommerce orderby dropdown
function picasso_catalog_orderby( $orderby ) {
    unset($orderby["price"]);       //Remove price: low to high option
    unset($orderby["price-desc"]);  //Remove price: high to low option
    return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "picasso_catalog_orderby", 20 );

add_filter( 'gettext', 'picasso_sort_change', 20, 3 );
function picasso_sort_change( $translated_text, $text, $domain ) {

    if ( function_exists('is_woocommerce') && is_woocommerce() ) {

        switch ( $translated_text ) {

          case 'Sort by popularity' :

                $translated_text = __( 'Popular', 'theme_text_domain' );
                break;

            case 'Sort by newness' :

                $translated_text = __( 'Latest', 'theme_text_domain' );
                break;

            case 'Sort by average rating' :

                $translated_text = __( 'Rating', 'theme_text_domain' );
                break;
        }

    }

    return $translated_text;
}

// ------------------------------------------
// MY ACCOUNT PAGE
// ------------------------------------------

// remove the actions tying these plugin panels to my-account page.
// instead we are going to call the templates directly (more formatting control)
remove_action( 'woocommerce_before_my_account', 'woocommerce_points_rewards_my_points' );
remove_action( 'woocommerce_before_my_account', 'WC_Subscriptions::get_my_subscriptions_template' );


add_action( 'woocommerce_my_account_my_subscriptions_actions', 'pagelines_edit_subsciption_actions', 10, 2 );
function pagelines_edit_subsciption_actions( $all_actions, $subscriptions ) {

  foreach( $all_actions as &$actions ){
    unset( $actions['suspend'] );

    $actions['cancel']['name'] = 'Delete';
  }

  unset($actions); // set by reference ^^

  return $all_actions;

}

// No shipping
//add_filter('woocommerce_shipping_fields', '__return_false');

add_filter('pl_flipper_meta', 'store_flipper_meta', 10, 3);
function store_flipper_meta($meta, $ID, $type_slug){

  if($type_slug == 'product_archive'){
//    $post = get_post($ID);
    ob_start(); ?>
    <a href="<?php echo get_permalink();?>"><?php woocommerce_get_template( 'loop/price.php' ); ?></a>
    <?php
    return ob_get_clean();
  } else
    return $meta;

}

// dont output thumb on shop page
function woocommerce_template_loop_product_thumbnail(){

    global $post;
    $image_src  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) , 'landscape-thumb' );
    printf('<div class="product-image"><img src="%s" /></div>', $image_src[0] );

}

// No more ratings on loop page
function woocommerce_template_loop_rating() {
  return;
}

add_filter( 'single_product_small_thumbnail_size', 'pl_woo_thumbnail_size');
add_filter( 'single_product_large_thumbnail_size', 'pl_woo_thumbnail_size');
function pl_woo_thumbnail_size( $size ) {

  $size = 'aspect-thumb';

  return $size;

}

function is_pagelines_membership(){
  global $post;
  return has_term( 'membership', 'product_cat', $post );
}

add_filter('woocommerce_product_tabs', 'remove_woocommerce_tabs', 100);
function remove_woocommerce_tabs($tabs){
  return false;
}

// Get Core Themes
function pl_get_store_products( $category = 'core'){

  global $wp_query;


  $number = 30;

  $page = (get_query_var('paged')) ? get_query_var('paged') : 1;

  $the_query = array(
    'posts_per_page'  => $number,
    'post_type'     => 'product',
    'product_cat'   => $category,
    'paged'       => $page
  );

  $wp_query = new WP_Query( $the_query );


  $posts = $wp_query->posts;

  $count = 1;

  ?>

  <div class="featured-products fix">
    <?php

    foreach( $posts as $feature):

      $item_cols = ( count( $posts ) <= 2 ) ? 6 : 4;

      // if it has an admin category, remove from listing.
      $admin = (has_term( 'admin', 'product_cat', $feature)) ? true : false;

      if( $admin )
        continue;

      global $product;
      $product = get_product( $feature->ID );

      echo pl_grid_tool( 'row_start', $item_cols, $count, $number );

      $image_src  = wp_get_attachment_image_src( get_post_thumbnail_id( $feature->ID ) , 'aspect-thumb' );

      ?>
      <div class="<?php echo pl_grid_tool( 'item_class', $item_cols ); ?>">

        <a class="featured-product"  href="<?php echo get_permalink($feature->ID) ;?>">
          <div class="featured-image"><?php printf('<img src="%s" />', $image_src[0] ); ?></div>
          <h3><?php echo $feature->post_title; ?></h3>
          <p>
            <?php echo custom_trim_excerpt( $feature->post_excerpt, 20); ?>

          </p>

        </a>
      </div>
    <?php
      echo pl_grid_tool( 'row_end', $item_cols, $count, $number );
      $count++;
    endforeach;

    ?>
  </div>

  <?php
  woocommerce_pagination();
  wp_reset_query(); // reset that
}

function pl_featured_products(){

  $featured_number = 6;
  $item_cols = 4;

  $the_query = array(
    'posts_per_page'  => $featured_number,
    'post_type'     => 'product',
    'orderby'     => 'random'
  );
  $the_query['meta_key'] = '_featured';
  $the_query['meta_value'] = 'yes';

  $featured_posts = get_posts( $the_query );
  $count = 1;

  ?>
  <div class="featured-products fix">
    <?php

    foreach( $featured_posts as $feature):
      global $product;
      $product = get_product( $feature->ID );
      echo pl_grid_tool( 'row_start', $item_cols, $count, $featured_number );

      $image_src  = wp_get_attachment_image_src( get_post_thumbnail_id( $feature->ID ) , 'aspect-thumb' );

      ?>
      <div class="<?php echo pl_grid_tool( 'item_class', $item_cols ); ?>">

        <a class="featured-product"  href="<?php echo get_permalink($feature->ID) ;?>">
          <div class="featured-image"><?php printf('<img src="%s" />', $image_src[0] ); ?></div>
          <h3><?php echo $feature->post_title; ?></h3>
          <p>
            <?php echo custom_trim_excerpt( $feature->post_excerpt, 20); ?>

          </p>

        </a>
      </div>
    <?php
      echo pl_grid_tool( 'row_end', $item_cols, $count, $featured_number );
      $count++;
    endforeach;

    ?>
  </div>
<?php }

function get_pl_product_image_src( $id, $size = 'aspect-thumb' ) {
  $image_src  = wp_get_attachment_image_src( get_post_thumbnail_id( $id ) , $size );
  if( ! $image_src )
    return pl_default_image();
  else
    return $image_src[0];
}


function shop_pl_trending(){

  ?>

  <div class="span2">
    <div class="picasso-shop-trending">

            <div class="row">

                <h3 class="showcase-header pl-sans-bold">Trending Products</h3>

            </div>

            <div class="row">

                <div class="span12 image-container">

                  <img src="http://localhost/pagelines/wp-content/uploads/pl-multimenu.jpg" alt="loop leather co" scale="0">

                  <a class="showcase-overlay" href="http://www.pagelines.com/showcase/sites/loop-leather-co/">
                      <div class="pl-center-table">
                        <div class="pl-center-cell">

                        </div>
                      </div>
                  </a>

                </div>

            </div>

            <div class="row">

                <div class="span12 image-container">

                  <img src="http://localhost/pagelines/wp-content/uploads/pl-multimenu.jpg" alt="loop leather co" scale="0">

                  <a class="showcase-overlay" href="http://www.pagelines.com/showcase/sites/loop-leather-co/">
                      <div class="pl-center-table">
                        <div class="pl-center-cell">

                        </div>
                      </div>
                  </a>

                </div>

            </div>

            <div class="row">

                <div class="span12 image-container">

                  <img src="http://localhost/pagelines/wp-content/uploads/pl-multimenu.jpg" alt="loop leather co" scale="0">

                  <a class="showcase-overlay" href="http://www.pagelines.com/showcase/sites/loop-leather-co/">
                      <div class="pl-center-table">
                        <div class="pl-center-cell">

                        </div>
                      </div>
                  </a>

                </div>

            </div>

       </div>
  </div>


<?php }


function shop_pl_get_child_cats( $catname ) {
    $parentcat = get_cat_ID( '$catname' );
    $subcat = get_categories( array('child_of' => $parentcat ) );
    $cat_array = array();
    array_push($cat_array, $parentcat); // add the parent cat to the array
    foreach ($subcat as $sc) {
        array_push($cat_array, $sc->cat_ID);
    }
    return $cat_array;
}


function shop_pl_nav(){
  $prod_cat = get_term_by( 'slug', 'pl-extensions', 'product_cat' );
  $pl_ext_link = get_term_link( $prod_cat, 'product_cat' );

  $prod_cat = get_term_by( 'slug', 'third-party-extensions', 'product_cat' );
  $third_party_link = get_term_link( $prod_cat, 'product_cat' );

  $store = get_permalink( woocommerce_get_page_id( 'shop' ) );

  // work out active states...
  $pl_ext_tab = '';
  $pl_themes_tab = '';
  $pl_party_tab = '';

  $pl_ext_cat = is_product_category( 'pl-extensions' );

  if( is_shop() && !$pl_ext_cat) {
    $pl_themes_tab = 'active';
  }

  if( is_product_category( 'third-party-extensions' ) ) {
    $pl_party_tab = 'active';
  }

  if( $pl_ext_cat ) {
    $pl_ext_tab = 'active';
  } ?>


  <h3 class="pl-sans-bold picasso-shop-header">Shop</h3>

     <ul class="nav nav-tabs nav-stacked">

      <?php //echo woocommerce_catalog_ordering(); ?>

    <li class="<?php echo $pl_themes_tab; ?>"><a href="<?php echo $store; ?>">Themes</a></li>
    <li class="<?php echo $pl_ext_tab; ?>"><a href="<?php echo $pl_ext_link; ?>">Extensions</a></li>
      <li class="<?php echo $pl_party_tab; ?>"><a href="<?php echo $third_party_link; ?>">3rd Party</a></li>

     </ul>

<?php }

function shop_pl_themes(){

  $item_cols = 6;
  global $wp_query;

  $themes_posts = $wp_query->posts;
  $count = 1;
  $themes_number = count( $wp_query->posts );

  ?>
  <div class="row">

    <div class="span2 picasso-stacked-nav">
      <?php shop_pl_nav(); ?>
    </div>

    <div class="span10">
      <div class="pl-themes-tab-content">

        <div class="row">
          <h3 class="pl-sans-bold picasso-shop-header"><a href="<?php echo site_url( '/product-category/pl-themes/' ); ?>">PageLines Themes</a></h3>
        </div>
        <?php

        foreach( $themes_posts as $theme):
          global $product;
          $product = get_product( $theme->ID );
          echo pl_grid_tool( 'row_start', $item_cols, $count, $themes_number );

          $image_src  = get_pl_product_image_src( $theme->ID );

          ?>
          <div class="<?php echo pl_grid_tool( 'item_class', $item_cols ); ?>">
            <div class="shop-pl-theme-browser">
              <i class="icon icon-circle"></i>
              <i class="icon icon-circle"></i>
              <i class="icon icon-circle"></i>
            </div>
            <a class="shop-pl-theme"  href="<?php echo get_permalink($theme->ID) ;?>">

              <?php printf('<img src="%s" />', $image_src ); ?>

              <div class="content theme-content">

                <div class="pl-center-table">
                  <div class="pl-center-cell">

                  </div>
                </div>

              </div>

            </a>
            <div class="pull-left">
                          <h3 class="pl-sans picasso-shop-product-header">
                <a href="<?php echo get_permalink($third_party->ID) ;?>">
                  <?php echo $theme->post_title; ?>
                </a>
              </h3>
                        </div>

          </div>
        <?php
          echo pl_grid_tool( 'row_end', $item_cols, $count, $themes_number );
          $count++;
        endforeach;

        ?>
      </div>
    </div>

    <?php //shop_pl_trending(); ?>


<?php }


function shop_pl_extensions(){

  global $wp_query;

  $item_cols = 4;

  $extensions_posts = $wp_query->posts;
  $extensions_number = count( $wp_query->posts );
  $count = 1;

  ?>
  <div class="row">

    <div class="span2 picasso-stacked-nav">
      <?php shop_pl_nav(); ?>
    </div>

    <div class="span10 pl-extensions-tab-content">
      <div class="row">
        <h3 class="pl-sans-bold picasso-shop-header"><a href="<?php echo site_url( '/product-category/pl-extensions/' ); ?>">PageLines Extensions</a></h3>
      </div>
      <?php

      foreach( $extensions_posts as $extension):
        global $product;
        $product = get_product( $extension->ID );

        echo pl_grid_tool( 'row_start', $item_cols, $count, $extensions_number );

        $image_src  = get_pl_product_image_src( $extension->ID );

        ?>
        <div class="<?php echo pl_grid_tool( 'item_class', $item_cols ); ?>">
          <a class="shop-pl-extension"  href="<?php echo get_permalink($extension->ID) ;?>">

            <div class="content extension-content">

                <div class="pl-center-table">
                  <div class="pl-center-cell">

                  </div>
                </div>

            </div>

            <?php printf('<img src="%s" />', $image_src ); ?>
          </a>

          <div class="row">
            <div class="span8">
              <h3 class="pl-sans picasso-shop-product-header">
                <a href="<?php echo get_permalink($extension->ID) ;?>">
                  <?php echo $extension->post_title; ?>
                </a>
              </h3>
            </div>
            <div class="span4 pull-right shop-rating">
              <?php echo pl_shop_get_star_rating( $product ); ?>
            </div>

          </div>

        </div>
      <?php
        echo pl_grid_tool( 'row_end', $item_cols, $count, $extensions_number );
        $count++;

      endforeach;
      ?>
    </div>

    <?php //shop_pl_trending(); ?>

    </div>

<?php }


function shop_3rd_party_extensions(){

  global $wp_query;

  $item_cols = 4;

  $third_party_posts = $wp_query->posts;
  $third_party_number = count( $wp_query->posts );

  $count = 1;

  ?>

  <div class="row">

    <div class="span2 picasso-stacked-nav">

      <?php shop_pl_nav(); ?>

      <h3 class="pl-sans-bold picasso-shop-header">Categories</h3>

         <ul class="nav nav-tabs nav-stacked">

            <?php

          $IDbyNAME = get_term_by('slug', 'third-party-extensions', 'product_cat');

          $product_cat_ID = $IDbyNAME->term_id;
          $args = array(
            'hierarchical' => 1,
            'show_option_none' => '',
            'hide_empty' => 0,
            'parent' => $product_cat_ID,
            'taxonomy' => 'product_cat'
          );
          $sub_cats = get_categories($args);
          $parent = get_term_link( $product_cat_ID, 'product_cat' );
          $all_active = 'active';
          ob_start();

          ?>

          <?php
          foreach($sub_cats as $sub_category) {
            $link = get_term_link( $sub_category, 'product_cat' );

            $active = '';
            if(  $wp_query->queried_object_id == $sub_category->term_id ) {
              $active = 'active';
              $all_active = '';
            }
            ?>
            <li class="<?php echo $active; ?>">
              <a href="<?php echo $link; ?>"><?php echo $sub_category->name; ?></a>
            </li>
            <?php
          }

          $cats = ob_get_clean();

            ?>
            <li class="<?php echo $all_active; ?>">
              <a href="<?php echo $parent; ?>">All</a>
            </li>
            <?php

          echo $cats;

            ?>
        </ul>
    </div>

        <div class="span10 third-party-tabs-content">

          <div class="row">
        <h3 class="pl-sans-bold picasso-shop-header"><a href="<?php echo site_url( '/product-category/third-party-extensions/' ); ?>">Third Party Extensions</a></h3>
      </div>



         <div class="tab-pane fade in active" id="sliders">

              <?php

          foreach( $third_party_posts as $third_party):
            $third_party = get_post( $third_party );

            $third_party_product = get_product( $third_party->ID );
            echo pl_grid_tool( 'row_start', $item_cols, $count, $third_party_number );

            $image_src  = get_pl_product_image_src( $third_party->ID );

            ?>
            <div class="<?php echo pl_grid_tool( 'item_class', $item_cols ); ?>">
              <a class="shop-pl-third-party"  href="<?php echo get_permalink($third_party->ID) ;?>">

                <div class="content third-party-content">

                    <div class="pl-center-table">
                      <div class="pl-center-cell">

                      </div>
                    </div>

                </div>

                <?php printf('<img src="%s" />', $image_src ); ?>

              </a>

              <div class="row">
                <div class="span8">
                  <h3 class="pl-sans picasso-shop-product-header">
                    <a href="<?php echo get_permalink($third_party->ID) ;?>">
                      <?php echo $third_party->post_title; ?>
                    </a>
                  </h3>
                </div>
                <div class="span4 pull-right shop-rating">
                  <?php echo pl_shop_get_star_rating( $third_party_product ); ?>
                </div>
              </div>

            </div>
          <?php
            echo pl_grid_tool( 'row_end', $item_cols, $count, $third_party_number );
            $count++;
          endforeach;

          ?>

         </div>

    </div>

<?php }

function shop_author_archive(){

  global $wp_query;

  $item_cols = 4;

  $third_party_posts = $wp_query->posts;
  $third_party_number = count( $wp_query->posts );

  $count = 1;

  ?>

  <div class="row">
      <div class="author-products-page">

        <?php
        $author = get_user_by( 'id', get_query_var( 'author' ) );
        $author_name = $author->user_nicename;
        $default_avatar = PL_IMAGES . '/avatar_default.gif';

        ob_start();
        the_author_meta('url');
        $author_link = ob_get_clean();
        $author_email = get_the_author_meta('email', $author->ID);
        $author_avatar = get_avatar( $author_email, '100', $default_avatar );
        $author_bio = get_the_author_meta( 'description', $author->ID);

        ?>
        <div class="author-info row">
          <div class="span2">
            <?php if ($author_link != ''){ ?>
              <a class="thumbnail" href="<?php echo $author_link; ?>" target="_blank">
                <?php echo $author_avatar; ?>
              </a>
            <?php } else {
              echo $author_avatar;
            }
            ?>
          </div>
          <div class="span8">
            <h2>Products by <?php echo $author_name; ?></h2>
            <p><?php echo $author_bio; ?></p>
          </div>
        </div>


        <div class="author-products">

              <?php

          foreach( $third_party_posts as $third_party):
            $third_party = get_post( $third_party );

            $third_party_product = get_product( $third_party->ID );
            echo pl_grid_tool( 'row_start', $item_cols, $count, $third_party_number );

            $image_src  = get_pl_product_image_src( $third_party->ID );

            ?>
            <div class="<?php echo pl_grid_tool( 'item_class', $item_cols ); ?>">
              <a class="author-product"  href="<?php echo get_permalink($third_party->ID) ;?>">

                <div class="content author-product-content">

                    <div class="pl-center-table">
                      <div class="pl-center-cell"></div>
                    </div>

                </div>

                <?php printf('<img src="%s" />', $image_src ); ?>

              </a>

              <div class="row">
                <div class="span8">
                  <h3 class="pl-sans">
                    <a href="<?php echo get_permalink($third_party->ID) ;?>">
                      <?php echo $third_party->post_title; ?>
                    </a>
                  </h3>
                </div>
                <div class="span4 pull-right shop-rating">
                  <?php echo pl_shop_get_star_rating( $third_party_product ); ?>
                </div>
              </div>

            </div>
          <?php
            echo pl_grid_tool( 'row_end', $item_cols, $count, $third_party_number );
            $count++;
          endforeach;

          ?>


        </div>

      </div>

  </div>

<?php }


// Remove stock availability
add_filter('woocommerce_stock_html', '__return_empty_string');


// Redirect to cart page when new product is added.
add_filter ('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');

function redirect_to_checkout() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}

//add_action('woocommerce_after_add_to_cart_button', 'pl_add_demo_button', 35);
function pl_add_demo_button(){
  global $post;
  $link = get_post_meta( $post->ID, '_pl_woo_product_demolink', true );
  if( '' != $link ) {

    ?>
    &nbsp;<a href="<?php echo $link; ?>" class="btn" target="_blank"><i class="icon icon-picture"></i> View Demo</a>
    <?php

  }

}

//add_action('woocommerce_after_shop_loop_item_title', 'custom_woo_product_rating', 20);
//add_action('woocommerce_single_product_summary', 'custom_woo_product_meta', 35);
function custom_woo_product_meta() {

    global $product;
    global $post;

  if(!is_pagelines_membership()){

    $average = $product->get_average_rating();
    $demo = '';

    if( is_product() ){

      $link = get_post_meta( $post->ID, '_pl_woo_product_demolink', true );
      if( '' != $link ) {
        ob_start();
        ?>
        <div class="pl-product-meta product-demo">
          <h4>Demo &amp; Info <i class="icon icon-ok"></i></h4>

          <div class="pl-meta-field">
            <div class="top-caret"></div>
            <a href="<?php echo $link; ?>" class="btn btn-primary"><i class="icon icon-ok"></i> Demo</a>

          </div>
        </div>
        <?php
        $demo = ob_get_clean();
      }
        ?>

      <?php echo $demo; ?>

      <div class="pl-product-meta product-tags">
        <h4>Tags <i class="icon icon-tag"></i></h4>

        <div class="pl-product-tags pl-meta-field">
          <div class="top-caret"></div>
          <?php
            echo $product->get_tags( '', '', '' );
          ?>

        </div>
      </div>
      <div class="pl-product-meta product-author">
        <h4>Developer <i class="icon icon-smile"></i></h4>

        <div class="pl-meta-field product-author">
          <div class="top-caret"></div>
          <div class="media fix">
            <?php
            ob_start();
              the_author_meta('url');
            $link = ob_get_clean();
              $default_avatar = PL_IMAGES . '/avatar_default.gif';
              $author_email = get_the_author_meta('email', $post->post_author);
              $author_name = get_the_author();
              $author_desc = get_the_author_meta('description', $post->post_author);
            ?>
            <div class="img">
              <a class="thumbnail" href="<?php echo $link; ?>" target="_blank">
                <?php echo get_avatar( $author_email, '120', $default_avatar); ?>
              </a>
            </div>
            <div class="bd">
              <h4>
                <?php echo $author_name ?>
              </h4>
              <p><?php echo $author_desc; ?></p>
              <?php
              if( $link != '' )
                printf( '<a href="%s" class="btn btn-mini btn-primary" target="_blank">%s <i class="icon icon-external-link"></i></a> ', $link, __( 'View Site', 'pagelines') );
              ?>
            </div>
          </div>


        </div>
      </div>
      <div class="pl-product-meta product-info">
        <h4>Information <i class="icon icon-info"></i></h4>

        <div class="pl-product-tags pl-meta-field">
          <div class="top-caret"></div>
          <table><tbody>
            <tr>
              <td>Created on</td>
              <td><?php the_date(get_option('date_format')); ?></td>
            </tr>
            <tr>
              <td>Last updated</td>
              <td><?php the_modified_date(get_option('date_format')); ?></td>
            </tr>
          </tbody></table>

        </div>
      </div>
    <?php

    } else {

      pl_get_star_rating( $average );

    }
  }

}

function pl_get_star_rating( $average ){?>
  <div class="star-rating" title="<?php printf(__( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
    <span style="width:<?php echo ( ( $average / 5 ) * 100 );  ?>%">
      <strong itemprop="ratingValue" class="rating"><?php echo $average; ?></strong> out of 5
    </span>
  </div>
<?php }



add_action('template_redirect', 'pl_remove_actions' );
function pl_remove_actions(){

  if ( function_exists( 'is_shop' ) && is_shop() )
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

  //remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
  add_action( 'insert_title_before_breadcrumbs', 'woocommerce_template_single_title', 2 );
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
  remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
  remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

  remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

  if( is_pagelines_membership() ){
    if( false === TWO_RELEASED )
      remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
  }
}

function pl_show_tickets() {
  if( shortcode_exists( 'uservoice_tickets' ) ):
    ob_start();
    echo do_shortcode( '[uservoice_tickets]');
    $tickets = ob_get_clean();

    if( false === strpos( $tickets, 'to retrieve your tickets from UserVoice.' ) ) {
      // we have tickets.. so show them
      echo '<div class="myaccount-tickets"><h2>HelpDesk Tickets</h2>';
      echo preg_replace( '#(\/my-account\/\?ticket\=[0-9]+)#', '$1#tabs-5', $tickets );
      echo '</div>';
    } else {
      // show the SSO button, were making our own cos the plugins text is unfilterable.
      printf( '<a href="%s/my-account/?uv_auth=true&amp;callback=%s/my-account/%s" class="btn btn-primary">Click here retrieve your tickets from the helpdesk.</a>', site_url(), site_url(), '#tabs-5');
    }

  endif;
}

function pl_woo_get_club_downloads() {

  global $pl_expired_subs, $current_user, $woocommerce, $old_dms,$old_personal,$dms_products,$standalone_dev,$standalone_pro,$updater,$pro_tools;

  $active_sub = false;
  $downloads = array();
  $woo_downloads = array();
  $downloads = array();
  $club = array();

  // get the normal woocommerce downloads, user purchases.
  $woo_downloads_data = WC()->customer->get_downloadable_products();

  // lets add product descriptions and versions to the woocommerce downloads.
  foreach( $woo_downloads_data as $k => $download ) {

    // remove PSDs from regular downloads, if you are club member it will be added later.
//    if( $standalone_dev != $download['product_id'] && preg_match( '/PSDs/', $download['download_name'] ) ) {
//      continue;
//    }
    $data = get_post( $download['product_id'] );
    $woo_downloads[$k]['desc'] = $data->post_excerpt;
    $woo_downloads[$k]['key'] = pl_woo_get_key( $download['order_id'] );
    $woo_downloads[$k]['product_url'] = get_permalink( $download['product_id'] );
    $woo_downloads[$k]['version'] = get_post_meta( $download['product_id'], '_pl_woo_product_version', true );
    $woo_downloads[$k]['download_url'] = $download['download_url'];
    $woo_downloads[$k]['download_name'] = $download['download_name'];
    $woo_downloads[$k]['product_id'] = $download['product_id'];

    $check = new WC_Product_Variation( $download['product_id'] );
    if( $check->exists() ) {
      $woo_downloads[$k]['version'] = get_post_meta( $check->id, '_pl_woo_product_version', true );
    }
    if( isset( $pl_expired_subs[ $download['order_id'] ] ) ) {
      $woo_downloads[$k]['desc'] .= sprintf( '<br /><em>Download expires %s. Order #%s Status: %s</em>',
      date( 'Y-m-d', $pl_expired_subs[ $download['order_id'] ]['expire'] ),
      $download['order_id'],
      $pl_expired_subs[ $download['order_id'] ]['status']
      );
    }

  }

  $old_framework = pl_get_old_platform_downloads();
  if( true == $old_framework ) {
    $downloads[] = pl_get_primary_download_data( 44767 );
    $downloads[] = pl_get_primary_download_data( 44768 );
  }



  // so step one, see if there is any subscriptions, active of course!

  $args = array(
    'customer_id' => $current_user->data->ID
  );

  $sub_code = new WC_Subscriptions;

  $subs = $sub_code->get_subscriptions( $args );


  // these are the old subscriptions.
  $oldsubs = array( 9987, 10448, 10449, 10450, 10451, 10452, 10453, 10456, 10457, 40778, 40779 );

  foreach( $subs as $sub ) {

    if( 'active' == $sub['status'] ) {
      $active_sub = $sub;

      // check if old sub
      if( in_array( $sub['product_id'], $oldsubs ) ) {
        break;
      } else {
        return pl_add_plugins_downloads( array_merge( $woo_downloads, $downloads ) );
      }
    }
  }

  // Carry on with old club code from here.


  if( ! $active_sub && ! empty( $subs ) ) {
    $user = $current_user->data->ID;
    if( 1 == get_user_meta( $user, '_old_plus_member', true ) ) {
      $active_sub = array_shift(array_values($subs));
    } else {
      $active_sub = pl_check_old_subs( $subs );
    }
  }

  // work around for a woocommerce subscription bug, if a sub is cancelled and then renewed no download shows up.
  if( preg_match( '#Renewal\sof#', $active_sub['name'] ) ) {
    $downloads[] = pl_get_primary_download_data( $active_sub['product_id'], $active_sub );
    $downloads[] = pl_get_primary_download_data( $pro_tools );
  }



  // if there is NO active subscription; Just return the downloads, if the user has dms standalone it'll be in there.
  if( ! $active_sub || $active_sub['status'] == 'on-hold' || $active_sub['status'] == 'failed' || $active_sub['status'] == 'cancelled' ) {
    return pl_add_plugins_downloads( array_merge( $woo_downloads, $downloads ) );
  }



  // if were this far, $active_sub holds the current active subscription data.


  // lets load all products, and add any with the PLUS (level I) checkbox.
  $args = array(
    'post_type' => 'product',
    'meta_key'  => '_pl_plus_product',
    'meta_value'  => 'yes',
    'posts_per_page' => -1,
    );
  $downloads_plus = get_posts( $args );

  foreach( $downloads_plus as $k => $d) {
    $downloads[$d->ID] = pl_get_primary_download_data( $d->ID );
  }

  $user_data  =  get_userdata( $current_user->data->ID );

  if( in_array( 'author', $user_data->roles ) ) {
    $args = array(
      'post_type' => 'product',
      'author'  => $current_user->data->ID,
      'posts_per_page' => -1,
      );
    $products = get_posts( $args );
    foreach( $products as $k => $d ) {
      $downloads[$d->ID] = pl_get_primary_download_data( $d->ID, $active_sub, false );
      $downloads[$d->ID + 1] = pl_get_extra_download_data( $d->ID, $active_sub, false );
    }
  }


  // STOP HERE
  // STOP HERE
  // STOP HERE
  // STOP HERE

  if( false == TWO_RELEASED )
    return pl_add_plugins_downloads( array_merge( $woo_downloads, $downloads ) );
  // STOP HERE
  // STOP HERE
  // STOP HERE
  // STOP HERE

  // we need to check what level of subscription it is using the post_meta keys...
  // _pl_club_product_lv2 is $20/mo club - we need to add all PL products here.
  // _pl_club_product_lv3 is $30/mo club - we need to add all PL products PLUS any dev objects.
  // if neither the above are set then it is the old $10/mo legacy subscription and we can just carry on and ignore it

  $id = $active_sub['product_id'];

  // hack to make old personal into a developer download..
  if( in_array( $id, $old_personal ) ) {

    $new = array();
    $new[] = pl_get_primary_download_data( $standalone_dev, $active_sub );
    $new[] = pl_get_extra_download_data( $standalone_dev, $active_sub );

    $downloads = array_merge( $new, $downloads );
  }

  if( in_array( $id, $old_dms ) )
    pl_upgrade_personal_activations( $active_sub );

  // not pro or dev.. so get the hell out.
  if( 'yes' != get_post_meta( $id, '_pl_club_product_pro', true ) && 'yes' != get_post_meta( $id, '_pl_club_product_dev', true ) ) {
    return array_merge( $woo_downloads, $downloads );
  }

  $all = pl_get_all_club_downloads();

  if( 'yes' == get_post_meta( $id, '_pl_club_product_pro', true ) ) {
    $d = pl_get_primary_download_data( $standalone_pro, $active_sub ); // add dms
    $d['download_name'] = 'PageLines DMS ( club download )';
    $club[] = $d;
    foreach( $all as $k => $p ) {

      $variation = false;
      $product = get_product( $p->ID );
      if( is_object( $product ) && 'variable' == $product->product_type ) {
        $available = $product->get_available_variations();
        $variation = $available[0]['variation_id']; // we want the FIRST variation here.
      }

      $downloads[$p->ID] = pl_get_primary_download_data( $p->ID, false, $variation );
    }
  }

  if( 'yes' == get_post_meta( $id, '_pl_club_product_dev', true ) ) {
    $d = pl_get_primary_download_data( $standalone_dev, $active_sub ); // add dms
    $d['download_name'] = 'PageLines DMS Developer ( club download )';
    $club[] = $d;

    $extras = pl_get_extra_download_data( $standalone_dev, $active_sub );

    if( ! empty( $extras ) )
      $club = array_merge( $club, $extras );


    foreach( $all as $k => $p ) {

      $variation = false;
      $product = get_product( $p->ID );
      if( is_object( $product ) && 'variable' == $product->product_type ) {
        $available = $product->get_available_variations();
        $variation = $available[0]['variation_id']; // we want the FIRST variation here.
        $product_id = $available[0]['variation_id'];
      }

      $downloads[$product_id] = pl_get_primary_download_data( $p->ID, false, $variation );

      if( $variation ) {
        // now we have to loop through the variations..
        foreach( $available as $k => $variation ) {
          $club_variations = pl_get_variation_extra( $variation['variation_id'], $p->ID );
          if( ! empty( $club_variations ) )
            $downloads = array_merge( $downloads, $club_variations );
        }
      }


      $a = pl_get_extra_download_data( $p->ID );
      if( ! empty( $a ) )
        $downloads = array_merge( $downloads, $a );
      }
  }


  // by now we are gonna have dms provided by woo and probably more than one duplicate because we are adding all
  // PL products, so lets get rid of them now!




  // now lets add a download for this subscription...


  // now we just add more downloads using the product post id's this is the pro tools plugin.
//  $downloads[] = pl_get_primary_download_data( 183 ); // 21232

  $all = pl_add_plugins_downloads( array_merge( $club, $woo_downloads, $downloads ) );

  return pl_make_downloads_unique( $all );
}

function pl_add_plugins_downloads( $downloads ) {

  global $pro_tools, $updater;
  // add pro tools and updater
  foreach( $downloads as $id => $download ) {

    $id = $download['product_id'];

    $variation = new WC_Product_Variation( $download['product_id'] );
    if( isset( $variation->post->ID ) )
      $id = $variation->post->ID;

    if( 'yes' == get_post_meta( $id, '_pl_product_pro_tools', true ) ) {
      $downloads[] = pl_get_primary_download_data( $pro_tools );
      break; // just once needed
    }
  }

  $downloads[] = pl_get_primary_download_data( $updater );

  return $downloads;
}


function pl_club_check_variation( $p ) {

  $pid = $p->ID;
  $variation = get_product($p->ID);
  if( 'variable' == $variation->product_type ) {
    $available_variations = $variation->get_available_variations();
    $variation = $available_variations[0]; // we only want 1st download.
    $pid = $variation['variation_id'];
  }
  return $pid;
}


/**
 * Used to check against old launchpad database, return true for now.
 */
function pl_get_old_platform_downloads() {
  
  return true;
  
  global $wpdb, $current_user;
  // see if the user has old platform or old framework :/
  $user = $current_user->user_login;


  $query = @$wpdb->prepare( "SELECT member_id FROM amember_members WHERE login = '%s'", $user );

  $result = @$wpdb->get_var( $query );

  if( ! $result )
    return false;

  $query = $wpdb->prepare( "SELECT payment_id FROM amember_payments WHERE member_id = '%s' and completed = 1 and product_id IN(173,174,82,83,84,85,86,69,70,52,46,47)", $result );

  $result = $wpdb->get_col( $query );

  if( empty( $result ) )
    return false;

  return true;
}

function pl_make_downloads_unique( $array ){

  $downloads = array();
  $array =  array_map("unserialize", array_unique(array_map("serialize", $array)));

  foreach( $array as $k => $download ) {
    if( isset( $download['download_url'] ) && ! array_search( $download['download_url'], $downloads ) )
      $downloads[$k] = $download;
  }
  return $downloads;
}

function pl_inject_dms_version( $downloads ) {

  global $storeapi,$old_dms,$dms_products;
  if( ! is_object( $storeapi ) )
    $storeapi = new EditorStoreFront;

  $mixed_array = $storeapi->get_latest();


  foreach( $downloads as $k => $download ) {

    if( ! isset( $download['product_id'] ) )
      continue;

    // if we match DMS lets hack the version number...
    if( in_array( $download['product_id'] , $old_dms ) )
      $downloads[$k]['version'] = '1.1.8';
    elseif( in_array( $download['product_id'] , $dms_products ) )
      $downloads[$k]['version'] = $mixed_array['dms']['version'];
  }
  return $downloads;
}

function pl_product_add_to_cart( $atts ) {
  global $wpdb, $post;

  if ( empty( $atts ) ) return '';

  extract( shortcode_atts( array(
    'id'         => '',
    'sku'        => '',
    'style'      => 'border:4px solid #ccc; padding: 12px;',
    'show_price' => 'true'
  ), $atts ) );

  if ( ! empty( $id ) ) {
    $product_data = get_post( $id );
  } elseif ( ! empty( $sku ) ) {
    $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );
    $product_data = get_post( $product_id );
  } else {
    return '';
  }

  $product = wc_setup_product_data( $product_data );

  if ( ! $product ) {
    return '';
  }

  ob_start();
  woocommerce_template_loop_add_to_cart();
  // Restore Product global in case this is shown inside a product post
  wc_setup_product_data( $post );

  return ob_get_clean();
}

add_shortcode( 'pl_product_add_to_cart', 'pl_product_add_to_cart' );

add_filter( 'wpo_wcpdf_myaccount_allowed_order_statuses', 'wpo_wcpdf_myaccount_allowed_order_statuses' );
function wpo_wcpdf_myaccount_allowed_order_statuses( $allowed_statuses ) {
  // Possible statuses : pending, failed, on-hold, processing, completed, refunded, cancelled
  $allowed_statuses = array ( 'refunded', 'completed', 'on-hold' );

  return $allowed_statuses;
}
/*
Change email subject for renewals
*/
add_filter( 'woocommerce_subscriptions_email_subject_new_renewal_order', 'pl_woocommerce_subscriptions_email_subject_new_renewal_order', 10, 2 );
function pl_woocommerce_subscriptions_email_subject_new_renewal_order($subject, $object) {
  if( 'wc-failed' == $object->post_status ) {
    $subject = 'PageLines Subscription Payment Failed.';
  }
  return $subject;
}

/*
Create a nice button that should work in most email clients.
*/

function pl_woo_email_button( $link, $text ) {
  ob_start();
  ?>
  <!--[if mso]>
  <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="%s" style="height:30px;v-text-anchor:middle;width:100px;" arcsize="17%" strokecolor="#1569D6" fillcolor="#1569D6">
  <w:anchorlock/>
  <center style="color:#ffffff;font-family:sans-serif;font-size:13px;font-weight:bold;">Pay Now</center>
</v:roundrect>
<![endif]--><a target="_blank" href="<?php echo esc_url( $link ); ?>"
style="background-color:#1569D6;border:1px solid #1569D6;border-radius:5px;color:#ffffff;display:inline-block;font-family:sans-serif;font-size:13px;font-weight:bold;line-height:30px;text-align:center;text-decoration:none;width:100px;-webkit-text-size-adjust:none;mso-hide:all;"><?php echo $text; ?></a>
<?php
  return ob_get_clean();
}

function pl_shop_get_star_rating( $product ) {
  return $product->get_rating_html();
}

/*
  Only display themes on initial shop page.
*/
add_action( 'pre_get_posts', 'shop_pre_get_posts_query_cat' );
function shop_pre_get_posts_query_cat( $q ) {

  if ( ! $q->is_main_query() )
    return;

  if ( ! $q->is_post_type_archive() )
    return;

  if ( ! is_admin() && is_shop() ) {
    $q->set( 'tax_query', array(array(
      'taxonomy' => 'product_cat',
      'field' => 'slug',
      'terms' => array( 'pl-themes' )
    )));
  }
  // remove action again, we dont want to kill the server wityh a runaway filter.
  remove_action( 'pre_get_posts', 'shop_pre_get_posts_query_cat' );
}


add_filter( 'pre_comment_approved' , 'check_woo_reviews' , '99', 2 );

function check_woo_reviews( $approved, $data ) {

  if( 'product' === get_post_type( $data['comment_post_ID'] ) )
    return 0;

  return $approved;
}



/*
  Seperate Woocommerce reviews from comments and make a reviews moderation panel.
*/
class PL_Woo_Review_Mods {
  function __construct() {
    add_action( 'current_screen', array( $this, 'check_current_page' ), 10, 2 );
    add_action( 'admin_menu', array( $this, 'add_product_reviews' ) );
  }
  function check_current_page( $screen ) {
    if ( $screen->id == 'edit-comments' ) {
      add_filter( 'comments_clauses', array( $this, 'separate_comments_and_review' ), 10, 2 );
      add_filter( 'comment_status_links', array( $this, 'change_comment_status_link' ) );
      if( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'product' ) {
        add_filter( 'manage_edit-comments_columns', array( $this, 'comment_columns' ) );
        add_filter( 'manage_comments_custom_column', array( $this, 'comment_column' ), 10, 2 );
      }
    }
  }

  function comment_column( $column, $comment_ID ) {
  if ( 'review_custom_column' == $column ) {
    $rating = get_comment_meta( $comment_ID, 'rating', true );
    echo $rating;
  }
}

function comment_columns( $columns ) {
  $columns['review_custom_column'] = __( 'Rating' );
  return $columns;
}

  function change_comment_status_link( $status_links ) {
    if( isset( $_GET['post_type'] ) ) {
      $status_links['all'] = '<a href="edit-comments.php?post_type=product&comment_status=all">All</a>';
      $status_links['moderated'] = '<a href="edit-comments.php?post_type=product&comment_status=moderated">Pending</a>';
      $status_links['approved'] = '<a href="edit-comments.php?post_type=product&comment_status=approved">Approved</a>';
      $status_links['spam'] = '<a href="edit-comments.php?post_type=product&comment_status=spam">Spam</a>';
      $status_links['trash'] = '<a href="edit-comments.php?post_type=product&comment_status=trash">Trash</a>';
    }
  return $status_links;
  }
  function separate_comments_and_review( $clauses, $wp_comment_query ) {

    global $wpdb;
    if ( ! $clauses['join'] ) {
      $clauses['join'] = "JOIN $wpdb->posts ON $wpdb->posts.ID = $wpdb->comments.comment_post_ID";
    }
    if( ! empty( $_GET['post_type'] ) && $_GET['post_type'] == 'product' ) {
      if ( ! $wp_comment_query->query_vars['post_type'] ) {}
        $clauses['where'] .= $wpdb->prepare( " AND {$wpdb->posts}.post_type = %s", 'product' );

    } else {
      if ( ! $wp_comment_query->query_vars['post_type' ] )
        $clauses['where'] .= $wpdb->prepare( " AND {$wpdb->posts}.post_type != %s", 'product' );
    }
  return $clauses;
  }
  function add_product_reviews() {
    global $wpdb;
    $query = "SELECT *
      FROM wp_comments
      INNER JOIN wp_posts ON ( wp_posts.ID = wp_comments.comment_post_ID )
      WHERE wp_posts.post_type = 'product'
      AND wp_comments.comment_approved = '0'";
    $result = $wpdb->get_row($query);
    $count = $wpdb->num_rows;
    if( $count > 0 ) {
      $alert = sprintf( ' <span class="awaiting-mod count-%s"><span class="pending-count">%s</span></span>',
      $count,
      $count
      );
    } else {
      $alert = '';
    }
    $post_type = 'product';
    $text = sprintf( 'Reviews%s', $alert );
    add_menu_page( $text,$text,'manage_options',"edit-comments.php?post_type={$post_type}",'','',59);
  }
}
if( is_admin() )
  new PL_Woo_Review_Mods;

add_action( 'woocommerce_before_template_part', 'pl_saved_cards_start', 10, 4 );
add_action( 'woocommerce_after_template_part', 'pl_saved_cards_end', 10, 4 );

function pl_saved_cards_start($template_name, $template_path, $located, $args) {
  if( 'saved-cards.php' == $template_name || 'myaccount/view-order.php' == $template_name )
    echo '<div class="pl-content">';
}
function pl_saved_cards_end($template_name, $template_path, $located, $args) {
  if( 'saved-cards.php' == $template_name || 'myaccount/view-order.php' == $template_name )
    echo '</div>';
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'pl_product_single_add_to_cart_text' );

function pl_product_single_add_to_cart_text() {
  return __( 'Buy Now', 'woocommerce' );
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {

  foreach( $fields['billing'] as $k => $field ) {
    if( ! in_array( $k, array( 'billing_first_name', 'billing_last_name', 'billing_email' ) ) ) {
      $fields['billing'][$k]['required'] = false;
    }
  }
 return $fields;
}

add_filter( 'woocommerce_default_address_fields' , 'custom_override_default_address_fields' );
function custom_override_default_address_fields( $address_fields ) {
  foreach( $address_fields as $k => $field ) {
      if( ! in_array( $k, array( 'last_name', 'first_name' ) ) )
        $address_fields[$k]['required'] = false;
  }
  return $address_fields;
}

add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
