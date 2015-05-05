<?php

class PageLines_Ten {

  function __construct() {
    add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
  }

  // enqueue styles and scripts.
  function scripts() {
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/build.css' );
  }
}

new PageLines_Ten;
