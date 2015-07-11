<?php

// show renewel header, and show form if logged out...

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

if( ! is_user_logged_in() ) {
  woocommerce_login_form(
		array(
			'message'  => __( 'You must be logged in to complete a renewel order.', 'woocommerce' ),
			'redirect' => get_permalink( wc_get_page_id( 'checkout' ) ),
			'hidden'   => false
		)
	);
} else {
  wc_get_template( 'checkout/pl-renewel-form.php', array( 'checkout' => $checkout ) );
}
