<?php

// show renewal form, user now logged in.

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">

  <?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

    <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

    <div class="col2-set" id="customer_details">

      <div class="col-1">

        <?php do_action( 'woocommerce_checkout_billing' ); ?>

      </div>

      <div class="col-2">

        <h3 id="order_review_heading" class="pl-sans"><?php _e( 'Your order', 'woocommerce' ); ?></h3>

        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
      </div>

    </div>

    <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>



  <?php endif; ?>



</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
