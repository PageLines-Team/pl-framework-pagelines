<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Get the users downloads, based on their subscription.
$downloads = pl_inject_dms_version( pl_woo_get_club_downloads() );

// OUTPUT THE SUCKERS

?>
	<h2 class="pl-sans"><?php echo apply_filters( 'woocommerce_my_account_my_downloads_title', __( 'Your Products', 'woocommerce' ) ); ?></h2>
	<table class="shop_table my_account_subscriptions my_account_orders">
		<thead>
			<tr>
				<th class="subscription-title"><span class="nobr">Product</span></th>
				<th class="subscription-status"><span class="nobr">Version</span></th>
				<th class="subscription-next-payment"><span class="nobr">Download</span></th>
			</tr>
		</thead>
<tbody>
<?php
	if( is_array( $downloads ) && ! empty( $downloads ) ){

		foreach ( $downloads as $download ) :

				if( '' == $download['download_name'] )
					continue;

				if( '' != $download['desc'] )
					$download['desc'] = sprintf( ' %s', $download['desc'] );

				if( '' != $download['key'] )
					$download['key'] = sprintf( '<br /><i class="icon icon-key"></i>&nbsp;<span style="font-weight:bold"><i>%s</i></span>', $download['key'] );

				$name = preg_replace( '#(.*)(\s&ndash;\s[a-z0-9A-Z-_]+.zip)#', '$1', $download['download_name'] );

				printf( '<tr class="order"><td class="my-account-downloads" width="80%%"><strong><a href="%s">%s</a></strong><br />%s%s</td>',
					apply_filters( 'woocommerce_available_download_link', esc_url( $download['download_url'] ), $download ),
					$name,
					$download['desc'],
					$download['key']
				);

				printf( '<td class="" width="20%%"><span class="nobr">%s</span></td>',
					$download['version']
				);

				printf( '<td class="" width="20%%"><span class="nobr"><a href="%s" class="btn btn-mini btn-primary">Download</a></span></td></tr>',
					$download['download_url']
				);

			endforeach;

	} else {
		?>
		<tr>
		<td colspan="3" >
			<div class="billboard">
			<h2 class="pl-sans">Doesn't look like you have any products yet! </h2>
			<p><a class="btn btn-primary" href="http://www.pagelines.com/pricing">Buy</a> <em style="margin: 0 10px;">or</em> <a  class="btn"  href="http://www.pagelines.com/pricing">Browse the Store</a></p>
		</div>
		</td>
		</tr>
		<?php
	}
	 ?>
	</tbody>
</table>
