<?php
/**
 * Title: About — Story
 * Slug: boxara/about-story
 * Categories: boxara-home
 * Description: "From digital to material" process copy next to a workshop photo.
 * Keywords: o nama, about, radionica, proces
 * Viewport Width: 1440
 *
 * @package Boxara
 */

$boxara_workshop_image_id  = 1312;
$boxara_workshop_image_url = wp_get_attachment_image_url( $boxara_workshop_image_id, 'large' );
?>
<!-- wp:group {"className":"about-story","layout":{"type":"constrained"}} -->
<div class="wp-block-group about-story">

	<div class="about-story__col js-reveal-section" style="--reveal-i:0">

		<!-- wp:paragraph {"className":"about-story__eyebrow"} -->
		<p class="about-story__eyebrow">NAŠA RADIONICA</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"className":"about-story__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading about-story__title has-display-font-family js-reveal-words">OD DIGITALA DO <mark style="background-color:rgba(0,0,0,0)" class="has-inline-color has-brand-color">MATERIJALA</mark></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"className":"about-story__tagline"} -->
		<p class="about-story__tagline">Digitalno dizajnirano. Ručno izrađeno.</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"about-story__text"} -->
		<p class="about-story__text">Naš proces počinje kao digitalna ideja. Dizajniramo, rezamo i slojimo — sve ručno. Od prvog nacrta do poslednjeg sloja, svaki komad prolazi kroz pet koraka: koncept, dizajn, rezanje, slojevanje i finalno ručno izrađivanje.</p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"className":"about-story__text"} -->
		<p class="about-story__text">Rezultat je jedinstveno, trodimenzionalno umetničko delo — ne samo dekoracija, već priča koja se menja sa svetlom i perspektivom.</p>
		<!-- /wp:paragraph -->

	</div>

	<?php if ( $boxara_workshop_image_url ) : ?>
	<div class="about-story__image js-reveal-section" style="--reveal-i:1">
		<img src="<?php echo esc_url( $boxara_workshop_image_url ); ?>" alt="Ruke koje precizno slažu slojeve papira u radionici" loading="lazy" />
	</div>
	<?php endif; ?>

</div>
<!-- /wp:group -->
