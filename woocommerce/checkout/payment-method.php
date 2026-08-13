<?php
/**
 * Output a single payment method.
 *
 * @package Boxara
 * @global WC_Payment_Gateway $gateway
 */

defined( 'ABSPATH' ) || exit;
?>
<li class="shop-checkout-page__payment-method wc_payment_method payment_method_<?php echo esc_attr( $gateway->id ); ?>">

	<label class="shop-checkout-page__payment-label" for="payment_method_<?php echo esc_attr( $gateway->id ); ?>">
		<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="shop-checkout-page__payment-radio input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />
		<span class="shop-checkout-page__payment-title"><?php echo $gateway->get_title(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?></span>
		<?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ?>
	</label>

	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="shop-checkout-page__payment-box payment_box payment_method_<?php echo esc_attr( $gateway->id ); ?>" <?php if ( ! $gateway->chosen ) : ?>style="display:none;"<?php endif; ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>

</li>
