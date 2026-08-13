<?php
/**
 * Title: Home — Hero
 * Slug: boxara/home-hero
 * Categories: boxara-home
 * Description: Full-width hero with a background photo, script eyebrow, three-line display heading and two calls to action.
 * Keywords: hero, home, naslovna
 * Viewport Width: 1440
 *
 * @package Boxara
 */

/*
 * Resolve the shop URL from WooCommerce rather than hardcoding a slug.
 * The shop page is currently "Shop" (/shop/) but will likely be renamed to
 * /prodavnica/ later — asking Woo means the pattern survives that rename.
 * Note this resolves when the pattern is inserted, not on every page load,
 * so the client can freely edit the link afterwards.
 */
$boxara_shop_url = function_exists( 'wc_get_page_permalink' )
	? wc_get_page_permalink( 'shop' )
	: home_url( '/' );

$boxara_custom_url = home_url( '/po-meri/' );

/*
 * Hero background photo, uploaded once to the Media Library (attachment 1299)
 * from the Figma source image. Referenced by ID like any other image the
 * client inserts through the editor — they can swap it from the block
 * toolbar without touching this file.
 */
$boxara_hero_image_id     = 1299;
$boxara_hero_image_url    = wp_get_attachment_image_url( $boxara_hero_image_id, 'full' );
$boxara_hero_image_srcset = wp_get_attachment_image_srcset( $boxara_hero_image_id, 'full' );
?>
<!-- wp:cover {"url":"<?php echo esc_url( $boxara_hero_image_url ); ?>","id":<?php echo (int) $boxara_hero_image_id; ?>,"dimRatio":0,"isUserOverlayColor":true,"minHeight":809,"minHeightUnit":"px","align":"full","className":"home-hero","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull home-hero" style="min-height:809px">
	<?php if ( $boxara_hero_image_url ) : ?>
	<img class="wp-block-cover__image-background wp-image-<?php echo (int) $boxara_hero_image_id; ?>" alt="" src="<?php echo esc_url( $boxara_hero_image_url ); ?>"<?php echo $boxara_hero_image_srcset ? ' srcset="' . esc_attr( $boxara_hero_image_srcset ) . '" sizes="100vw"' : ''; ?> data-object-fit="cover" />
	<?php endif; ?>
	<span aria-hidden="true" class="wp-block-cover__background home-hero__scrim"></span>
	<div class="wp-block-cover__inner-container">

		<!-- wp:group {"className":"home-hero__inner","layout":{"type":"default"}} -->
		<div class="wp-block-group home-hero__inner">

			<!-- wp:paragraph {"className":"home-hero__eyebrow","fontFamily":"accent"} -->
			<p class="home-hero__eyebrow has-accent-font-family">mesto za</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":1,"className":"home-hero__title","fontFamily":"display"} -->
			<h1 class="wp-block-heading home-hero__title has-display-font-family">Male stvari<br><mark style="background-color:rgba(0,0,0,0)" class="has-inline-color has-brand-color">sa velikom</mark><br>pričom</h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"home-hero__lede"} -->
			<p class="home-hero__lede">Ručno izrađena slojevita umetnička dela koja donose dubinu, teksturu i karakter vašem životnom prostoru.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"className":"home-hero__ctas"} -->
			<div class="wp-block-buttons home-hero__ctas">

				<!-- wp:button {"className":"is-style-fill"} -->
				<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $boxara_shop_url ); ?>">Pronađi ram</a></div>
				<!-- /wp:button -->

				<!-- wp:button {"className":"is-style-outline"} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $boxara_custom_url ); ?>">Naruči po meri</a></div>
				<!-- /wp:button -->

			</div>
			<!-- /wp:buttons -->

		</div>
		<!-- /wp:group -->

	</div>
</div>
<!-- /wp:cover -->
