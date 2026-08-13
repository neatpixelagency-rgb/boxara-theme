<?php
/**
 * Proceed to checkout button.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;
?>
<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="shop-cart-page__checkout-btn checkout-button wc-forward">
	Nastavi na plaćanje
	<?php boxara_icon( 'arrow-right' ); ?>
</a>
