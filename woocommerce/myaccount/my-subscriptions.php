<?php
/**
 * My Subscriptions
 */

?>

<h2 class="pl-sans"><?php _e( 'My Membership', WC_Subscriptions::$text_domain ); ?></h2>

<?php if ( ! empty( $subscriptions ) ) : ?>
<table class="shop_table my_account_subscriptions my_account_orders">

	<thead>
		<tr>
			<th class="subscription-order-number"><span class="nobr"><?php _e( 'Order', WC_Subscriptions::$text_domain ); ?></span></th>
			<th class="subscription-title"><span class="nobr"><?php _e( 'Subscription', WC_Subscriptions::$text_domain ); ?></span></th>
			<th class="subscription-status"><span class="nobr"><?php _e( 'Status', WC_Subscriptions::$text_domain ); ?></span></th>
			<th class="subscription-next-payment"><span class="nobr"><?php _e( 'Next Payment', WC_Subscriptions::$text_domain ); ?></span></th>
			<th class="subscription-expiry"><span class="nobr"><?php _e( 'Expiration', WC_Subscriptions::$text_domain ); ?></span></th>
			<th class="subscription-actions"></th>
		</tr>
	</thead>

	<tbody>
	<?php foreach ( array_reverse( $subscriptions ) as $subscription_key => $subscription_details ) : ?>
		<?php $order = new WC_Order( $subscription_details['order_id'] ); ?>
		<tr class="order">
			<td class="order-number" width="1%">
				<a href="<?php echo esc_url( add_query_arg( 'order', $subscription_details['order_id'], get_permalink( woocommerce_get_page_id( 'view_order' ) ) ) ); ?>"><?php echo $order->get_order_number(); ?></a>
			</td>
			<td class="subscription-title">
				<a href="<?php echo get_post_permalink( $subscription_details['product_id'] ); ?>">
					<?php echo WC_Subscriptions_Order::get_item_name( $subscription_details['order_id'], $subscription_details['product_id'] ); ?>
				</a>
				<?php $order_item = WC_Subscriptions_Order::get_item_by_product_id( $order, $subscription_details['product_id'] ); ?>
				<?php $product    = $order->get_product_from_item( $order_item ); ?>
				<?php if ( isset( $product->variation_data ) ) : ?>
					<p><?php echo woocommerce_get_formatted_variation( $product->variation_data, true ); ?></p>
				<?php endif; ?>
			</td>
			<td class="subscription-status" style="text-align:left; white-space:nowrap;">
				<?php echo WC_Subscriptions_Manager::get_status_to_display( $subscription_details['status'], $subscription_key, $user_id ); ?>
			</td>
			<td class="subscription-next-payment">
				<?php $next_payment_timestamp = WC_Subscriptions_Manager::get_next_payment_date( $subscription_key, $user_id, 'timestamp' ); ?>
				<?php if ( $next_payment_timestamp == 0 ) : ?>
					-
				<?php else : ?>
					<?php $time_diff = $next_payment_timestamp - gmdate( 'U' ); ?>
					<?php if ( $time_diff > 0 && $time_diff < 7 * 24 * 60 * 60 ) : ?>
						<?php $next_payment = sprintf( __( 'In %s', WC_Subscriptions::$text_domain ), human_time_diff( $next_payment_timestamp ) ); ?>
					<?php else : ?>
						<?php $next_payment = date_i18n( get_option( 'date_format' ), $next_payment_timestamp ); ?>
					<?php endif; ?>
				<time title="<?php echo esc_attr( $next_payment_timestamp ); ?>">
					<?php echo $next_payment; ?>
				</time>
				<?php endif; ?>
			</td>
			<td class="subscription-expiry">
				<?php if ( $subscription_details['expiry_date'] == 0 ) : ?>
					<?php _e( 'Never', WC_Subscriptions::$text_domain ); ?>
				<?php else : ?>
					<?php $expiry_timestamp = strtotime( $subscription_details['expiry_date'] ); ?>
					<?php $time_diff = $expiry_timestamp - gmdate( 'U' ); ?>
					<?php if ( absint( $time_diff ) > 0 && absint( $time_diff ) < 7 * 24 * 60 * 60 ) : ?>
						<?php if ( $time_diff > 0 ) : // In the future ?>
							<?php $expiry = sprintf( __( 'In %s', WC_Subscriptions::$text_domain ), human_time_diff( $expiry_timestamp ) ); ?>
						<?php else : // In the past ?>
							<?php $expiry = sprintf( __( '%s ago', WC_Subscriptions::$text_domain ), human_time_diff( $expiry_timestamp ) ); ?>
						<?php endif; ?>
					<?php else : ?>
						<?php $expiry = date_i18n( get_option( 'date_format' ), $expiry_timestamp ); ?>
					<?php endif; ?>
					<time title="<?php echo esc_attr( $expiry_timestamp ); ?>">
						<?php echo $expiry; ?>
					</time>
				<?php endif; ?>
			</td>
			<td class="subscription-actions order-actions">
				<?php foreach( $actions[$subscription_key] as $key => $action ){
					
					if( isset( $action['url'] ) ){
						printf('<a href="%s" class="%s btn btn-mini btn-primary" style="margin-right:5px">%s</a>',
								esc_url( $action['url'] ),
								sanitize_html_class( $key ),
								esc_html( $action['name'] )
							);
					}
					
				} ?>
					
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>

</table>
<div class='cancel-form'>
	<div class="cancel-form-cancel remove-form"><i class="icon icon-remove"></i></div>
	<h5>Are you sure you want to delete your membership?</h5>
	<p>We'll be sad to see you go! Before you go, we might be able to help, please email <a href="mailto:batphone@pagelines.com">priority support</a> and we'll respond ASAP!</p>
	<p>Are you sure you want to delete your PageLines account? Once you do, your support, your pro access, and your pro features including libraries and editing tools will not be available.</p>
	<p><?php echo do_shortcode('[gravityform id="17" name="Cancel Subscription" title="false" description="false" ajax="true"]'); ?></p>
	<p class="cancel-buttons">
		<a href="mailto:hello@pagelines.com" class="btn btn-primary  btn-mini"><i class="icon icon-comments"></i> Contact Support First</a>
		<a href="" class="btn btn-primary btn-mini cancel-form-cancel"><i class="icon icon-ok"></i> Nevermind, I'll stay a Pro.</a>
		<a href="" class="btn btn-mini membership-delete"><i class="icon icon-remove" style="color: #ff0000;"></i> Yes, I'm sure. Delete my membership.</a>
		
	</p>
</div>


<?php else : ?>

	<p><?php _e( 'You have no active subscriptions.', WC_Subscriptions::$text_domain ); ?></p>

<?php endif;
