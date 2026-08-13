<?php
/**
 * Checkout form.
 *
 * Overrides WooCommerce's hook-driven default with the Figma-language
 * layout: header, billing/shipping fields column, and a sticky order review
 * sidebar. Real WooCommerce hooks/functions still power field rendering,
 * coupons, shipping and totals — only the wrapping markup is custom, same
 * approach as woocommerce/cart/cart.php.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

// If checkout registration is disabled and not logged in, the user cannot checkout.
$boxara_checkout_locked = ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in();
?>

<div class="shop-checkout-page">

	<div class="shop-checkout-page__header">
		<p class="shop-checkout-page__eyebrow">Poručivanje</p>
		<h1 class="shop-checkout-page__title">ZAVRŠITE <mark>PORUDŽBINU</mark></h1>
	</div>

	<?php
	/**
	 * Hook: woocommerce_before_checkout_form.
	 *
	 * @hooked woocommerce_checkout_login_form - 10
	 * @hooked woocommerce_checkout_coupon_form - 10 (styled via checkout/form-coupon.php override)
	 * @hooked woocommerce_output_all_notices - 10
	 */
	do_action( 'woocommerce_before_checkout_form', $checkout );
	?>

	<?php if ( $boxara_checkout_locked ) : ?>

		<p><?php echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) ); ?></p>

	<?php else : ?>

	<form name="checkout" method="post" class="shop-checkout-page__form checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="Plaćanje">

		<div class="shop-checkout-page__layout">

			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div class="shop-checkout-page__fields" id="customer_details">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>

			<div class="shop-checkout-page__summary">

				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

				<h2 class="shop-checkout-page__summary-title" id="order_review_heading">Vaša porudžbina</h2>

				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

				<div id="order_review" class="woocommerce-checkout-review-order">
					<?php
					/**
					 * Hook: woocommerce_checkout_order_review.
					 *
					 * @hooked woocommerce_order_review - 10 (styled via checkout/review-order.php override)
					 * @hooked woocommerce_checkout_payment - 20 (styled via checkout/payment.php override)
					 */
					do_action( 'woocommerce_checkout_order_review' );
					?>
				</div>

				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

			</div>

		</div>

	</form>

	<?php endif; ?>

</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
