<?php
/**
 * Title: Home — Store Location
 * Slug: boxara/home-store-location
 * Categories: boxara-home
 * Description: Physical store address, hours, phone and a visit CTA next to a Google Maps embed.
 * Keywords: prodavnica, lokacija, store, location, home
 * Viewport Width: 1440
 *
 * @package Boxara
 */

/*
 * There is currently no verified Google Maps business pin for the store
 * address, so this uses the same address-based Maps embed (no API key,
 * no invented coordinates or Place ID) as patterns/kontakt-location.php
 * and footer.php, instead of a static photo.
 */
$boxara_map_embed_src = 'https://www.google.com/maps?q=Palmira+Toljatija+5,+Beograd,+Srbija&output=embed';
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
			<iframe class="home-store__map-embed" src="<?php echo esc_url( $boxara_map_embed_src ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="<?php esc_attr_e( 'Mapa lokacije Boxara prodavnice', 'boxara' ); ?>"></iframe>
		</div>

		<div class="home-store__details js-reveal-section" style="--reveal-i:1">

			<div class="home-store__address">
				<p class="home-store__address-line">
					<span class="home-store__pin"><?php boxara_icon( 'map-pin' ); ?></span>
					<span class="home-store__address-name">Beogradski izložbeni prostor</span>
				</p>
				<p class="home-store__address-street">Palmira Toljatija 5, Stari Mercator, sa spoljne strane</p>
			</div>

			<div class="home-store__meta">
				<span class="home-store__meta-label">Radno vreme</span>
				<p class="home-store__meta-value">Pon &ndash; Pet: 09:00 &ndash; 17:00 | Sub: 09:00 &ndash; 15:00 | Ned: zatvoreno</p>
			</div>

			<div class="home-store__meta">
				<span class="home-store__meta-label">Telefon</span>
				<p class="home-store__meta-value"><a href="tel:+381601901034">+381 60 1901034</a></p>
			</div>

			<!-- wp:buttons {"className":"home-store__cta"} -->
			<div class="wp-block-buttons home-store__cta">
				<!-- wp:button {"className":"is-style-fill"} -->
				<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="https://maps.google.com/?q=Palmira+Toljatija+5,+Beograd,+Srbija" target="_blank" rel="noopener">Poseti nas</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

		</div>

	</div>

</div>
<!-- /wp:group -->
