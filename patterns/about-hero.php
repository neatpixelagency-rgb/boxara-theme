<?php
/**
 * Title: About — Hero
 * Slug: boxara/about-hero
 * Categories: boxara-home
 * Description: Full-bleed hero with a background photo, script eyebrow, two-line display heading and a lede paragraph.
 * Keywords: o nama, about, hero
 * Viewport Width: 1440
 *
 * @package Boxara
 */

/*
 * Hero background photo, uploaded once to the Media Library (attachment 1311)
 * from the Figma source image. Referenced by ID like any other image the
 * client inserts through the editor — they can swap it from the block
 * toolbar without touching this file.
 */
$boxara_about_hero_image_id     = 1311;
$boxara_about_hero_image_url    = wp_get_attachment_image_url( $boxara_about_hero_image_id, 'full' );
$boxara_about_hero_image_srcset = wp_get_attachment_image_srcset( $boxara_about_hero_image_id, 'full' );
?>
<!-- wp:cover {"url":"<?php echo esc_url( $boxara_about_hero_image_url ); ?>","id":<?php echo (int) $boxara_about_hero_image_id; ?>,"dimRatio":0,"isUserOverlayColor":true,"minHeight":525,"minHeightUnit":"px","align":"full","className":"about-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull about-hero" style="min-height:525px">
	<?php if ( $boxara_about_hero_image_url ) : ?>
	<img class="wp-block-cover__image-background wp-image-<?php echo (int) $boxara_about_hero_image_id; ?>" alt="" src="<?php echo esc_url( $boxara_about_hero_image_url ); ?>"<?php echo $boxara_about_hero_image_srcset ? ' srcset="' . esc_attr( $boxara_about_hero_image_srcset ) . '" sizes="100vw"' : ''; ?> data-object-fit="cover" />
	<?php endif; ?>
	<span aria-hidden="true" class="wp-block-cover__background about-hero__scrim"></span>
	<div class="wp-block-cover__inner-container">

		<!-- wp:group {"className":"about-hero__inner","layout":{"type":"default"}} -->
		<div class="wp-block-group about-hero__inner">

			<!-- wp:paragraph {"className":"about-hero__eyebrow","fontFamily":"accent"} -->
			<p class="about-hero__eyebrow has-accent-font-family js-reveal-section">Ko smo mi</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"className":"about-hero__title","fontFamily":"display"} -->
			<h1 class="wp-block-heading about-hero__title has-display-font-family js-reveal-lines">KREATORI <mark style="background-color:rgba(0,0,0,0)" class="has-inline-color has-brand-color">DUBINE</mark> I DETALJA</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"about-hero__lede"} -->
			<p class="about-hero__lede js-reveal-section">Boxara je umetnički kolektiv koji spaja fizički i digitalni svet kroz vrhunske dimenzionalne skulpture od papira. Naša strast je unošenje dubine, teksture i karaktera u vaš životni prostor.</p>
			<!-- /wp:paragraph -->

		</div>
		<!-- /wp:group -->

	</div>
</div>
<!-- /wp:cover -->
