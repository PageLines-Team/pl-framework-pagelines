<?php
/**
 * WooCommerce Points and Rewards
 *
 * @package     WC-Points-Rewards/Templates
 * @author      WooThemes
 * @copyright   Copyright (c) 2013, WooThemes
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * My Account - My Points
 *
 * @since 1.0
 * @version 1.0
 */

$lifetime_karma = (int) get_user_meta( get_current_user_id(), 'pl_lifetime_karma', true );

$legacy_exempt = (int) get_user_meta( get_current_user_id(), '_old_plus_member', true );

?>


<h2 class="pl-sans"><i class="icon icon-sun"></i> My Karma</h2>

<p><?php printf( "You currently have <strong>%d</strong> %s and <strong>%s</strong> Lifetime Karma Points.", $points_balance, $points_label, $lifetime_karma ); ?></p>


<?php if ( $events ) : ?>
	<table class="shop_table my_account_points_rewards my_account_orders">

		<thead>
			<tr>
				<th class="points-rewards-event-description"><span class="nobr">Event</span></th>
				<th class="points-rewards-event-date"><span class="nobr">Date</span></th>
				<th class="points-rewards-event-points"><span class="nobr"><?php echo esc_html( $points_label ); ?></span></th>
			</tr>
		</thead>

		<tbody>
		<?php foreach ( $events as $event ) : ?>
			<tr class="points-event">
				<td class="points-rewards-event-description">
					<?php echo $event->description; ?>
				</td>
				<td class="points-rewards-event-date">
					<?php echo '<abbr title="' . esc_attr( $event->date_display ) . '">' . esc_html( $event->date_display_human ) . '</abbr>'; ?>
				</td>
				<td class="points-rewards-event-points" width="1%">
					<?php echo ( $event->points > 0 ? '+' : '' ) . $event->points; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>

	</table>

<?php endif; ?>

<h2 class="pl-sans"><i class="icon icon-sun"></i> Karma Extensions</h2>
<?php 
$args = array(
	'post_type'		=> 'product',
	'meta_key'		=> '_pl_karma_product',
	'meta_value'	=> 'yes',

);
$query = new WP_Query( $args );
if($query->have_posts()): 
?>
<table class="shop_table my_account_points_rewards my_account_orders">

	<thead>
		<tr>
			<th class="points-rewards-event-description"><span class="nobr">Extension</span></th>
			<th class="points-rewards-event-date"><span class="nobr">Points Needed</span></th>
			<th class="points-rewards-event-points"><span class="nobr">Available?</span></th>
			<th class="points-rewards-event-points"><span class="nobr">Actions</span></th>
			
		</tr>
	</thead>

	<tbody>
		
		<?php
		

	
		      while($query->have_posts()) : 
		         $query->the_post();
		
				$points_needed = get_post_meta( get_the_id(), '_pl_karma_points_required', true);
				
				$plus_product = get_post_meta( get_the_id(), '_pl_plus_product', true);
				
				$plus_exempt = ( $legacy_exempt && $plus_product ) ? true : false;
				
				$the_download_data = pl_get_primary_download_data( get_the_id(), false );
				$the_download = $the_download_data['download_url'];
				
		?>
			<tr class="points-event">
				<td width="30%">
					<a href="<?php the_permalink();?>"><?php the_title() ?></a>
				</td>
				<td class="" width="10%" >
					<?php echo $points_needed; ?>
				</td>
				<td class="" width="10%" >
					<?php if($lifetime_karma >= $points_needed): ?>
						<i class="icon icon-ok"></i>
					<?php elseif( $plus_exempt ): ?>
						<i class="icon icon-ok"></i> <small>(Plus Member Exempt)</small>
					<?php else: ?>
						<i class="icon icon-remove"></i>
					<?php endif; ?>
				</td>
				<td class="">
					<a class="btn btn-mini" href="<?php the_permalink();?>"><i class="icon icon-edit"></i> Overview</a>&nbsp;
					<?php if($lifetime_karma >= $points_needed || $plus_exempt): ?>
						<a class="btn btn-primary btn-mini" href="<?php echo $the_download;?>"><i class="icon icon-download"></i> Download!</a>&nbsp;
					<?php else: ?>
						<a class="btn disabled btn-mini" ><strong><?php echo $points_needed - $lifetime_karma; ?> <i class="icon icon-sun"></i></strong> More Points Needed</a>
					<?php endif; ?>
				</td>
				
			</tr>
		<?php
		      endwhile;
		 
	
		?>
	
	</tbody>

</table>

<?php

else:
	printf('<div class="alert alert-warning"><strong>Coming Soon!</strong> Unlock extensions with Lifetime Karma Points.</div>'); 
endif;

?>
<div class="my-account-headline alert">
		<p>The Karma System is designed to reward contributions to the community. <a href="http://www.pagelines.com/the-karma-system/" class="btn btn-primary btn-mini"><i class="icon icon-sun"></i> Learn More</a></p>
		
</div>