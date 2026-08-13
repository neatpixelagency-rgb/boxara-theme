<?php
/**
 * Checkout shipping information form + order notes.
 *
 * @package Boxara
 * @global WC_Checkout $checkout
 */

defined( 'ABSPATH' ) || exit;
?>
<?php if ( true === WC()->cart->needs_shipping_address() ) : ?>
	<div class="shop-checkout-page__field-group">

		<h3 class="shop-checkout-page__field-group-title" id="ship-to-different-address">
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input id="ship-to-different-address-checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" <?php checked( apply_filters( 'woocommerce_ship_to_different_address_checked', 'shipping' === get_option( 'woocommerce_ship_to_destination' ) ? 1 : 0 ), 1 ); ?> type="checkbox" name="ship_to_different_address" value="1" /> <span>Pošalji na drugu adresu?</span>
			</label>
		</h3>

		<div class="shipping_address">

			<?php do_action( 'woocommerce_before_checkout_shipping_form', $checkout ); ?>

			<div class="shop-checkout-page__field-grid">
				<?php
				$boxara_shipping_fields = $checkout->get_checkout_fields( 'shipping' );

				foreach ( $boxara_shipping_fields as $key => $field ) {
					woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
				}
				?>
			</div>

			<?php do_action( 'woocommerce_after_checkout_shipping_form', $checkout ); ?>

		</div>

	</div>
<?php endif; ?>

<div class="shop-checkout-page__field-group shop-checkout-page__field-group--notes">

	<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>

	<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', 'yes' === get_option( 'woocommerce_enable_order_comments', 'yes' ) ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || wc_ship_to_billing_address_only() ) : ?>
			<h3 class="shop-checkout-page__field-group-title">Dodatne informacije</h3>
		<?php endif; ?>

		<div class="shop-checkout-page__field-grid">
			<?php foreach ( $checkout->get_checkout_fields( 'order' ) as $key => $field ) : ?>
				<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
			<?php endforeach; ?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>

</div>
