<?php
/**
 * Review order — order items + totals, inside the sticky summary sidebar.
 *
 * Same visual language as woocommerce/cart/cart-totals.php's totals card,
 * with a compact line-item list above it instead of a table.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="shop-checkout-page__review">

	<?php do_action( 'woocommerce_review_order_before_cart_contents' ); ?>

	<div class="shop-checkout-page__review-items">
		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$visible  = apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key );

			if ( ! ( $_product instanceof WC_Product && $_product->exists() && $cart_item['quantity'] > 0 && $visible ) ) {
				continue;
			}
			?>
			<div class="shop-checkout-page__review-item">

				<div class="shop-checkout-page__review-item-thumb">
					<?php echo wp_kses_post( $_product->get_image( 'thumbnail' ) ); ?>
					<span class="shop-checkout-page__review-item-qty"><?php echo (int) $cart_item['quantity']; ?></span>
				</div>

				<div class="shop-checkout-page__review-item-name">
					<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?>
					<?php $boxara_item_data = wc_get_formatted_cart_item_data( $cart_item ); ?>
					<?php if ( $boxara_item_data ) : ?>
						<div class="shop-checkout-page__review-item-meta"><?php echo wp_kses_post( $boxara_item_data ); ?></div>
					<?php endif; ?>
				</div>

				<span class="shop-checkout-page__review-item-subtotal">
					<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>

			</div>
			<?php
		}
		?>
	</div>

	<?php do_action( 'woocommerce_review_order_after_cart_contents' ); ?>

	<div class="shop-checkout-page__review-totals">

		<div class="shop-checkout-page__totals-row">
			<span class="shop-checkout-page__totals-label">Međuzbir</span>
			<span class="shop-checkout-page__totals-value"><?php wc_cart_totals_subtotal_html(); ?></span>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="shop-checkout-page__totals-row shop-checkout-page__totals-row--discount">
				<span class="shop-checkout-page__totals-label"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				<span class="shop-checkout-page__totals-value"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="shop-checkout-page__totals-row">
				<span class="shop-checkout-page__totals-label"><?php echo esc_html( $fee->name ); ?></span>
				<span class="shop-checkout-page__totals-value"><?php wc_cart_totals_fee_html( $fee ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) {
					?>
					<div class="shop-checkout-page__totals-row">
						<span class="shop-checkout-page__totals-label"><?php echo esc_html( $tax->label ); ?></span>
						<span class="shop-checkout-page__totals-value"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
					</div>
					<?php
				}
			} else {
				?>
				<div class="shop-checkout-page__totals-row">
					<span class="shop-checkout-page__totals-label"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
					<span class="shop-checkout-page__totals-value"><?php wc_cart_totals_taxes_total_html(); ?></span>
				</div>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<div class="shop-checkout-page__totals-row shop-checkout-page__totals-row--total">
			<span class="shop-checkout-page__totals-label">Ukupno za plaćanje</span>
			<span class="shop-checkout-page__totals-value"><?php wc_cart_totals_order_total_html(); ?></span>
		</div>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</div>

</div>
