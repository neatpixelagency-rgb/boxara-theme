<?php
/**
 * Cart totals — order summary sidebar.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="shop-cart-page__totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h2 class="shop-cart-page__totals-title">Ukupan iznos</h2>

	<div class="shop-cart-page__totals-rows">

		<div class="shop-cart-page__totals-row">
			<span class="shop-cart-page__totals-label">Međuzbir</span>
			<span class="shop-cart-page__totals-value"><?php wc_cart_totals_subtotal_html(); ?></span>
		</div>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="shop-cart-page__totals-row shop-cart-page__totals-row--discount">
				<span class="shop-cart-page__totals-label"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				<span class="shop-cart-page__totals-value"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
			<?php wc_cart_totals_shipping_html(); ?>
			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

			<div class="shop-cart-page__totals-row">
				<span class="shop-cart-page__totals-label">Dostava</span>
				<span class="shop-cart-page__totals-value"><?php woocommerce_shipping_calculator(); ?></span>
			</div>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="shop-cart-page__totals-row">
				<span class="shop-cart-page__totals-label"><?php echo esc_html( $fee->name ); ?></span>
				<span class="shop-cart-page__totals-value"><?php wc_cart_totals_fee_html( $fee ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$boxara_taxable_address = WC()->customer->get_taxable_address();
			$boxara_estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				/* translators: %s location. */
				$boxara_estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $boxara_taxable_address[0] ) . WC()->countries->countries[ $boxara_taxable_address[0] ] );
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) {
					?>
					<div class="shop-cart-page__totals-row">
						<span class="shop-cart-page__totals-label"><?php echo esc_html( $tax->label ) . wp_kses_post( $boxara_estimated_text ); ?></span>
						<span class="shop-cart-page__totals-value"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
					</div>
					<?php
				}
			} else {
				?>
				<div class="shop-cart-page__totals-row">
					<span class="shop-cart-page__totals-label"><?php echo esc_html( WC()->countries->tax_or_vat() ) . wp_kses_post( $boxara_estimated_text ); ?></span>
					<span class="shop-cart-page__totals-value"><?php wc_cart_totals_taxes_total_html(); ?></span>
				</div>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<div class="shop-cart-page__totals-row shop-cart-page__totals-row--total">
			<span class="shop-cart-page__totals-label">Ukupno za plaćanje</span>
			<span class="shop-cart-page__totals-value"><?php wc_cart_totals_order_total_html(); ?></span>
		</div>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</div>

	<div class="shop-cart-page__proceed wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
