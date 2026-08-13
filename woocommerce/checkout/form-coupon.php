<?php
/**
 * Checkout coupon form.
 *
 * Always-visible input instead of WooCommerce's default hidden-until-click
 * toggle, matching woocommerce/cart/cart.php's coupon field — no JS needed.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) {
	return;
}
?>
<div class="shop-checkout-page__coupon">
	<p class="shop-checkout-page__coupon-label">Imate kod kupona?</p>
	<form class="checkout_coupon woocommerce-form-coupon" method="post">
		<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
		<input type="text" name="coupon_code" class="shop-checkout-page__coupon-input" placeholder="Unesite kod kupona" id="coupon_code" value="" />
		<button type="submit" class="shop-checkout-page__coupon-apply" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">Primeni kod</button>
	</form>
</div>
