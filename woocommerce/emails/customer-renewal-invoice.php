<?php
/**
 * Customer renewal invoice email
 *
 * @author	Brent Shepherd
 * @package WooCommerce_Subscriptions/Templates/Emails
 * @version 1.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php if ( $order->status == 'pending' ) : ?>
	<?php do_action( 'woocommerce_email_header', $email_heading ); ?>
	<p><?php printf( __( 'An invoice has been created for you to renew your subscription with %s. To pay for this invoice please use the following link: <a href="%s">Pay Now &raquo;</a>', 'woocommerce-subscriptions' ), get_bloginfo( 'name' ), esc_url( $order->get_checkout_payment_url() ) ); ?></p>
<?php elseif ( 'failed' == $order->status ) : ?>

	<?php do_action( 'woocommerce_email_header', 'Your Subscription Payment has Failed!' ); ?>
	<p>
<div><?php echo pl_woo_email_button( $order->get_checkout_payment_url(), 'Pay Now &raquo;'); ?></div>
</p>
	<p>On no! The automatic payment to renew your subscription with PageLines has failed :(</p>
	<p>You will stop receiving product updates and your licence keys will not work until you renew your subscription.</p>
		<?php printf( __( '<p>Please login and pay for the renewal from your account page: <a href="%s">Pay Now &raquo;</a></p>', 'woocommerce-subscriptions' ), get_bloginfo( 'name' ), esc_url( $order->get_checkout_payment_url() ) ); ?>
</p>
<?php endif; ?>

<?php do_action( 'woocommerce_email_before_order_table', $order, false ); ?>

<h2><?php echo __( 'Order:', 'woocommerce-subscriptions' ) . ' ' . $order->get_order_number(); ?></h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<thead>
		<tr>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Product', 'woocommerce-subscriptions' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'woocommerce-subscriptions' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Price', 'woocommerce-subscriptions' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( false, true, false ); ?>
	</tbody>
	<tfoot>
		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				foreach ( $totals as $total ) {
					$i++;
					?><tr>
						<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
						<td style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['value']; ?></td>
					</tr><?php
				}
			}
		?>
	</tfoot>
</table>

<?php do_action( 'woocommerce_email_after_order_table', $order, false ); ?>

<?php do_action( 'woocommerce_email_footer' ); ?>
