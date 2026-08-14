<?php
/**
 * Title: Kontakt — Location & Store
 * Slug: boxara/kontakt-location
 * Categories: boxara-home
 * Description: Map card linking out to Google Maps, next to a storefront photo slot.
 * Keywords: kontakt, contact, lokacija, mapa, prodavnica
 * Viewport Width: 1440
 *
 * @package Boxara
 */

// Map illustration, uploaded once to the Media Library from the Figma source image.
$boxara_map_image_id  = 1317;
$boxara_map_image_url = wp_get_attachment_image_url( $boxara_map_image_id, 'large' );

/*
 * The Figma source photo for the storefront slot is a boxing-gear shop
 * ("The Arena") — the wrong business, not just an aesthetic stand-in.
 * Same call as home-store-location.php: placeholder tile until a real
 * photo of the Belgrade space is supplied.
 */
$boxara_store_image_url = '';
?>
<!-- wp:group {"className":"kontakt-location","layout":{"type":"constrained"}} -->
<div class="wp-block-group kontakt-location">
	<div class="kontakt-location__row">

		<div class="kontakt-location__col js-reveal-section" style="--reveal-i:0">
			<h2 class="kontakt-location__title js-reveal-words">LOKACIJA</h2>
			<div class="kontakt-location__map-card">
				<?php if ( $boxara_map_image_url ) : ?>
					<img class="kontakt-location__map-image" src="<?php echo esc_url( $boxara_map_image_url ); ?>" alt="Mapa centra Beograda sa oznakom lokacije Boxara prodavnice na Knez Mihailovoj" loading="lazy" />
				<?php endif; ?>
				<span class="kontakt-location__map-marker" aria-hidden="true"><?php boxara_icon( 'map-pin' ); ?></span>
				<div class="kontakt-location__map-overlay">
					<div class="kontakt-location__map-address">
						<span class="kontakt-location__map-label">ADRESA</span>
						<p class="kontakt-location__map-value">Knez Mihailova 24, Beograd</p>
					</div>
					<a class="kontakt-location__map-cta" href="https://maps.google.com/?q=Knez+Mihailova+24,+Beograd" target="_blank" rel="noopener">
						<?php boxara_icon( 'external-link' ); ?>
						<span>OTVORI MAPU</span>
					</a>
				</div>
			</div>
		</div>

		<div class="kontakt-location__col js-reveal-section" style="--reveal-i:1">
			<h2 class="kontakt-location__title js-reveal-words">NAŠA PRODAVNICA</h2>
			<div class="kontakt-location__store-card">
				<?php if ( $boxara_store_image_url ) : ?>
					<img src="<?php echo esc_url( $boxara_store_image_url ); ?>" alt="Boxara izložbeni prostor" loading="lazy" />
				<?php else : ?>
					<span class="kontakt-location__store-placeholder" aria-hidden="true"><?php boxara_icon( 'map-pin' ); ?></span>
				<?php endif; ?>
			</div>
			<p class="kontakt-location__store-caption">Posetite naš izložbeni prostor u srcu Beograda i osetite teksturu i dubinu naših trodimenzionalnih radova uživo.</p>
		</div>

	</div>
</div>
<!-- /wp:group -->
