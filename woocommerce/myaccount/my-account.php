<?php
/**
* My Account page
*
* @author 		WooThemes
* @package 	WooCommerce/Templates
* @version     2.0.0
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$demo = get_user_meta( get_current_user_id(), '_pl_demo_url', true );

wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_my_account' ); ?>

<div id="tabs" class="my-account-tabs">

			<div class="my-account-nav-container">
				<ul class="my-account-nav tabbed-list fix pl-content">
					<li><a href="#tabs-1"><i class="icon icon-download"></i> My Downloads</a></li>
					<li><a href="#tabs-2"><i class="icon icon-plus"></i> My Membership</a></li>
						<li><a href="#tabs-3"><i class="icon icon-shopping-cart"></i> My Orders</a></li>
					<li><a href="#tabs-4"><i class="icon icon-comments"></i> Support</a></li>
					<?php if( $demo ) : ?>
					<li><a href="#tabs-5"><i class="icon icon-plus"></i> My Demo</a></li>
					<?php endif; ?>
					<?php if( pl_dev()->show_tab() ) {
						echo '<li><a href="#tabs-6"><i class="icon icon-mortar-board"></i> Developer</a></li>';
					}

					if( shortcode_exists( 'picasso-my-account' ) && function_exists( 'picasso_showcase_display' ) && picasso_showcase_display() ) {
						echo '<li class="showcase-button"><a href="#tabs-7"><i class="icon icon-plus"></i> Showcase (beta)</a></li>';
					}
					?>
				</ul>
			</div>

			<div class="pl-content">
				<div class="row">

						<?php
						global $current_user;
						$user_ID = get_current_user_id();
						$user_email = get_the_author_meta( 'user_email', $user_ID);
						$default_avatar = PL_IMAGES . '/avatar_default.gif';
						$user_avatar = get_avatar( $user_email, '120', $default_avatar);
						$user_description = get_the_author_meta( 'description', $user_ID);

						printf(
							__( '
							<div class="myaccount-user picasso-user row">
								<div class="span2">
									%s
								</div>
								<div class="span8">
									<h3 class="user_name pl-sans">%s</h3>
									<p>%s</p>
									<div class="user-actions">
										<a href="%s" class="logout"><i class="icon icon-pencil"></i> Change password</a>
										<a href="%s" title="Edit Profile"><i class="icon icon-user"></i> Edit Profile</a>
										<a href="%s" title="Logout"><i class="icon icon-off"></i> Logout</a>
									</div>
								</div>
							</div>', 'woocommerce' ),
							$user_avatar,
							$current_user->display_name,
							$user_description,
							site_url( '/my-account/edit-account/' ),
							get_edit_user_link( $user_ID ),
							wp_logout_url( get_permalink() )
						);

						?>

				</div>

				<div id="tabs-1">

				<?php pl_maybe_upsell_club() ?>


				<p><?php woocommerce_get_template( 'myaccount/my-downloads.php' ); ?></p>
				</div>
				<div id="tabs-2">
					<p><?php WC_Subscriptions::get_my_subscriptions_template(); ?></p>
				</div>

				<div id="tabs-3">
					<?php woocommerce_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>
				</div>

				<div id="tabs-4">

					<h2 class="pl-sans">Support</h2>
					<p>PageLines takes your happiness seriously! We have a ton of support and contact options for you.</p>
					<div class="alert">
						<strong><a href="http://www.pagelines.com/quick-start/">Quick Start Guide &rarr;</a></strong><br/>
						<p>Videos and helpful tips to help you understand the PageLines workflow.</p>
					</div>
					<div class="alert">
						<strong><a href="http://www.pagelines.com/docs/DMS">DMS Docs &rarr;</a></strong><br/>
						<p>Installation docs to get you set up with PageLines DMS.</p>
					</div>
					<div class="alert">
						<strong><a href="http://answers.pagelines.com">PageLines Answers</a></strong><br/>
						<p>Answers and articles to help with customizing PageLines.</p>
					</div>
					<div class="alert">
						<strong><a href="http://forum.pagelines.com/">Forums &rarr;</a></strong><br/>
						<p>Technical support from the PageLines community.</p>
						<p>Registration is free. To get access to the subscriber forums simply add your DMS key to your <a href="http://forum.pagelines.com/index.php?app=core&module=usercp">Forum Profile</a>.</p>
					</div>

					<div class="alert">
						<a  href="http://www.pagelines.com/contact/">Customer Service</a><br/>
						<p>Have an account or billing related issue? Feel free to contact us! (Please allow for 24 hour response time)</p>
					</div>

				</div>

				<?php if( $demo ): ?>
					<div id="tabs-5">
						<h3>YAY looks like you have a demo setup already!</h3>
						<p>Go there now <a class="btn btn-large btn-primary" href="<?php echo $demo . '/?pl-view-tour=1'; ?>"><?php echo $demo; ?></a>
						</div>
					<?php endif; ?>

				<?php if( pl_dev()->show_tab() ): ?>
					<div id="tabs-6">
							<?php echo pl_dev()->render_my_account_tab(); ?>
					</div>
				<?php endif; ?>

				<?php if( shortcode_exists( 'picasso-my-account' ) && function_exists( 'picasso_showcase_display' ) && picasso_showcase_display() ) { ?>
					<div id="tabs-7">
					</div>
				<?php } ?>
			</div>

</div>
<?php do_action( 'woocommerce_after_my_account' );

function show_forums_status() {
	$user_ID = get_current_user_id();
	$user_info = get_userdata($user_ID);
	$login = $user_info->user_login;
	$data = '';
	if( $_POST ) {
		if( isset( $_POST['link'] ) ) {
			// check if we bought dms
			$orders = fused_get_all_products_ordered_by_user($user_ID);

			if( false == $orders ) {
				echo 'Unable to link to premium forums, you do not own any products.';
			}else {
				// ok we have products, lets see if any are dms...
				$dms = array( '10453','10456','10457','10450','10451','10452','9987','10448','10449' );

				foreach( $orders as $order ) {
					if( in_array( $order, $dms ) ) {

						// were good lets do this shit!
						$data = do_forum_upgrade();
					} else {
						echo 'Unable to link to premium forums, no DMS detected.';
					}
				}
			}
		}
	}

	if( $data )
		return $data ;

	if( ! $data ) {
		return sprintf( '<form method="POST" action="/my-account/#tabs-5"><button name="link" class="btn btn-primary">Check/Create forum account for %s</button></form>', $login );
	}
}


function do_forum_upgrade() {
	$user_ID = get_current_user_id();
	$user_info = get_userdata($user_ID);
	$login = $user_info->user_login;
	$email = $user_info->user_email;
	$login_now = sprintf( '<form method="GET" action="http://forum.pagelines.com/"><button class="btn btn-primary">Login now as %s</button></form>', $login );

	if( ! isset( $_POST['stage'] ) ) {

		// stage 1
		$url = sprintf( 'http://forum.pagelines.com/my-account.php?email=%s&login=%s&mode=check', $email, $login );
		$data = wp_remote_get( $url );

		if( is_array( $data ) && isset( $data['body']) && 'no' == $data['body'] ) {
			return sprintf( '<br /><strong>No user detected, lets add one.</strong><br /><form method="POST" action="/my-account/#tabs-5">
			<input name="pass" placeholder="Enter Password" /><br />
			<input type="hidden" name="stage" value="2"/>
			<button name="link" class="btn btn-primary">Create forum account for %s.</button></form>', $login );
		}
		if( is_array( $data ) && isset( $data['body']) && is_numeric( $data['body'] ) ) {
			return $login_now;
		}
	}

	if( '2' == $_POST['stage'] ) {
		$pass = $_POST['pass'];
		$url = sprintf( 'http://forum.pagelines.com/my-account.php?email=%s&login=%s&mode=new&pass=%s', $email, $login, $pass );
		$data = wp_remote_get( $url );
		if( is_array( $data ) && isset( $data['body']) && 'error' != $data['body'] ) {
			return $login_now;
		}
	}


}

function fused_has_user_bought($user_id,$product_id){
$ordered_products=fused_get_all_products_ordered_by_user($user_id);

if(in_array($product_id, (array)$ordered_products))
	return true;
return false;

}

/**
* Get all Products Successfully Ordered by the user
*
* @global type $wpdb
* @param int $user_id
* @return bool|array false if no products otherwise array of product ids
*/
function fused_get_all_products_ordered_by_user($user_id=false,$status='completed'){

$orders=fused_get_all_user_orders($user_id,$status);
if(empty($orders))
	return false;

$order_list='('.join(',', $orders).')';//let us make a list for query

//so we have all the orders made by this user which was successfull

//we need to find the products in these order and make sure they are downloadable

// find all products in these order

global $wpdb;
$query_select_order_items="SELECT order_item_id as id FROM {$wpdb->prefix}woocommerce_order_items WHERE order_id IN {$order_list}";

$query_select_product_ids="SELECT meta_value as product_id FROM {$wpdb->prefix}woocommerce_order_itemmeta WHERE meta_key=%s AND order_item_id IN ($query_select_order_items)";

$products=$wpdb->get_col($wpdb->prepare($query_select_product_ids,'_product_id'));

return $products;
}

/**
* Returns all the orders made by the user
*
* @param int $user_id
* @param string $status (completed|processing|canceled|on-hold etc)
* @return array of order ids
*/
function fused_get_all_user_orders($user_id,$status='completed'){
		if(!$user_id)
				return false;

		$orders=array();//order ids

		$args = array(
				'numberposts'     => -1,
				'meta_key'        => '_customer_user',
				'meta_value'      => $user_id,
				'post_type'       => 'shop_order',
				'post_status'     => 'publish',
				'tax_query'=>array(
								array(
										'taxonomy'  =>'shop_order_status',
										'field'     => 'slug',
										'terms'     =>$status
										)
				)
		);

		$posts=get_posts($args);
		//get the post ids as order ids
		$orders=wp_list_pluck( $posts, 'ID' );

		return $orders;

}


function pl_maybe_upsell_club() {
	$id = get_current_user_id();
	$subs = WC_Subscriptions_Manager::get_users_subscriptions($id);

	if( ! is_array( $subs ) || empty( $subs ) )
		return false;

	// finish early if we have an active sub...
	foreach( $subs as $k => $sub ) {
		if( 'active' == $sub['status'] )
			return false;
	}

	// if we get here, user must have at least one subscription that is not active.

	echo '<div class="alert pl-alert"><div class="club-alert-content">
	<p><strong>Your Membership is Inactive</strong><br />
	Membership is needed for updates and support. To renew, visit <a class="club-upsell" href="#">the membership page.</a></p>
	<a class="btn btn-black club-upsell">RENEW</a>
	</div>
	</div>
	<script>
	jQuery(document).ready(function() {
		jQuery( ".club-upsell").click( function(e){
			e.preventDefault()
			jQuery("#ui-id-2").trigger("click")
		})
	})
	</script>
	';
}
