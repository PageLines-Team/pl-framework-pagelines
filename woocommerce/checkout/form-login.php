<?php
/**
* Checkout login form
*
* @author 		WooThemes
* @package 	WooCommerce/Templates
* @version     2.0.0
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_user_logged_in() || 'no' === get_option( 'woocommerce_enable_checkout_login_reminder' ) ) return;

$info_message  = '<p>Returning customer? &nbsp;&nbsp;<a href="#" class="showlogin btn btn-small btn-inverse">Click here to login</a></p>';

printf( '<div class="woocommerce-info">%s</div>', $info_message );

?>

<?php
woocommerce_login_form(
array(
  'message'  => __( 'If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing &amp; Shipping section.', 'woocommerce' ),
  'redirect' => get_permalink( wc_get_page_id( 'checkout' ) ),
  'hidden'   => true
  )
);
?>
