<?php
/**
 * Title: Home — Store Location
 * Slug: boxara/home-store-location
 * Categories: boxara-home
 * Description: Physical store address, hours, phone and a visit CTA next to a storefront photo.
 * Keywords: prodavnica, lokacija, store, location, home
 * Viewport Width: 1440
 *
 * @package Boxara
 */

/*
 * The Figma source image for this slot (node 112:222) is a boxing-gear shop
 * stock photo — visibly the wrong business, not just an aesthetic stand-in.
 * Shipping it would misrepresent the store, so this renders a placeholder
 * tile instead until a real photo of the Belgrade space is supplied.
 */
$boxara_store_image_url = '';
?>
<!-- wp:group {"className":"home-store","layout":{"type":"constrained"}} -->
<div class="wp-block-group home-store">

	<!-- wp:group {"className":"home-store__header","layout":{"type":"constrained"}} -->
	<div class="wp-block-group home-store__header">

		<!-- wp:paragraph {"className":"home-store__eyebrow"} -->
		<p class="home-store__eyebrow">Poseti nas</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"className":"home-store__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading home-store__title has-display-font-family js-reveal-words">Boxara prodavnica</h2>
		<!-- /wp:heading -->

	</div>
	<!-- /wp:group -->

	<div class="home-store__content">

		<div class="home-store__image js-reveal-section" style="--reveal-i:0">
			<?php if ( $boxara_store_image_url ) : ?>
				<img src="<?php echo esc_url( $boxara_store_image_url ); ?>" alt="Boxara izložbeni prostor" loading="lazy" />
			<?php else : ?>
				<span class="home-store__image-placeholder" aria-hidden="true"><?php boxara_icon( 'map-pin' ); ?></span>
			<?php endif; ?>
		</div>

		<div class="home-store__details js-reveal-section" style="--reveal-i:1">

			<div class="home-store__address">
				<p class="home-store__address-line">
					<span class="home-store__pin"><?php boxara_icon( 'map-pin' ); ?></span>
					<span class="home-store__address-name">Beogradski izložbeni prostor</span>
				</p>
				<p class="home-store__address-street">Knez Mihailova 24, Beograd, Srbija</p>
			</div>

			<div class="home-store__meta">
				<span class="home-store__meta-label">Radno vreme</span>
				<p class="home-store__meta-value">Pon &ndash; Sub: 10:00 &ndash; 21:00 | Ned: 11:00 &ndash; 18:00</p>
			</div>

			<div class="home-store__meta">
				<span class="home-store__meta-label">Telefon</span>
				<p class="home-store__meta-value"><a href="tel:+381111234567">+381 11 123 4567</a></p>
			</div>

			<!-- wp:buttons {"className":"home-store__cta"} -->
			<div class="wp-block-buttons home-store__cta">
				<!-- wp:button {"className":"is-style-fill"} -->
				<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="https://maps.google.com/?q=Knez+Mihailova+24,+Beograd" target="_blank" rel="noopener">Poseti nas</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

		</div>

	</div>

</div>
<!-- /wp:group -->
