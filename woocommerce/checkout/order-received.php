<?php
/**
 * "Order received" message — the confirmation banner at the top of the
 * thank-you page.
 *
 * @package Boxara
 * @var WC_Order|false $order
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="shop-thankyou-page__intro">

	<span class="shop-thankyou-page__icon" aria-hidden="true"><?php boxara_icon( 'cta-frame' ); ?></span>

	<p class="shop-thankyou-page__eyebrow">Porudžbina primljena</p>
	<h1 class="shop-thankyou-page__title">HVALA VAM NA <mark>PORUDŽBINI</mark></h1>

	<p class="shop-thankyou-page__desc">
		<?php
		$boxara_message = apply_filters(
			'woocommerce_thankyou_order_received_text',
			esc_html( __( 'Thank you. Your order has been received.', 'woocommerce' ) ),
			$order
		);
		echo wp_kses_post( $boxara_message );
		?>
	</p>

</div>
