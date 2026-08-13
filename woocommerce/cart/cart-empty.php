<?php
/**
 * Empty cart page.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="shop-cart-page shop-cart-page--empty">
	<div class="shop-cart-page__empty">

		<span class="shop-cart-page__empty-icon" aria-hidden="true"><?php boxara_icon( 'cart' ); ?></span>

		<h1 class="shop-cart-page__empty-title">VAŠA KORPA JE <mark>PRAZNA</mark></h1>

		<p class="shop-cart-page__empty-desc">Još niste dodali nijedno umetničko delo u korpu. Istražite naše kolekcije i pronađite savršen komad za vaš prostor.</p>

		<?php
		/*
		 * Not calling woocommerce_cart_is_empty here: its only default
		 * callback (wc_empty_cart_message) prints a plain-English notice
		 * that would duplicate the heading above in the wrong language.
		 */
		?>

		<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
			<a class="shop-cart-page__empty-cta" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">Istraži kolekcije</a>
		<?php endif; ?>

	</div>
</div>
