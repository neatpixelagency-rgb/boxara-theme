<?php
/**
 * Title: About — CTA
 * Slug: boxara/about-cta
 * Categories: boxara-home
 * Description: Closing call to action pointing into the shop collections.
 * Keywords: o nama, about, cta
 * Viewport Width: 1440
 *
 * @package Boxara
 */

$boxara_shop_url = function_exists( 'wc_get_page_permalink' )
	? wc_get_page_permalink( 'shop' )
	: home_url( '/' );
?>
<!-- wp:group {"className":"about-cta","layout":{"type":"constrained"}} -->
<div class="wp-block-group about-cta">

	<span class="about-cta__icon" aria-hidden="true"><?php boxara_icon( 'cta-frame' ); ?></span>

	<!-- wp:group {"className":"about-cta__copy","layout":{"type":"constrained"}} -->
	<div class="wp-block-group about-cta__copy">

		<!-- wp:heading {"level":2,"className":"about-cta__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading about-cta__title has-display-font-family">PRONAĐITE SVOJ RAM</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"className":"about-cta__lede"} -->
		<p class="about-cta__lede">Želite unikatno umetničko delo napravljeno specijalno po vašoj želji? Otvorite naš proces naručivanja ili istražite gotove limitirane kolekcije.</p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

	<!-- wp:buttons {"className":"about-cta__buttons"} -->
	<div class="wp-block-buttons about-cta__buttons">
		<!-- wp:button {"className":"is-style-fill"} -->
		<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $boxara_shop_url ); ?>">Istraži kolekcije</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

</div>
<!-- /wp:group -->
