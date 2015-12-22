<?php
/*
 * Template Name: Home Page
 */



$default_settings = array(
  'header'                => 'Platform 5', 
  'subheader'             => 'Insanely-Simple Editing for WordPress.<br/> Coming November 2015.', 
  'logo'                  => get_stylesheet_directory_uri() . '/images/pl-logo.png', 
  'logo_height'           => '35', 
  'footer_text'           => '&copy; PageLines Inc. 2015', 
  'button_primary'        => 'http://www.pagelines.com/my-account/', 
  'button_primary_text'   => 'Signup For Early Access &nbsp; <i class="pl-icon pl-icon-caret-right"></i>', 
  'button_primary_style'  => 'primary', 
); 

echo pl_get_section( array( 'section' => 'splashup', 'id' => 'homesplash_321', 'settings' => $default_settings ) );


