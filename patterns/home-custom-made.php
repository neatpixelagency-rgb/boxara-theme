<?php
/**
 * Title: Home — Custom Made
 * Slug: boxara/home-custom-made
 * Categories: boxara-home
 * Description: Custom-order pitch — a finished piece next to its reference photo, the three-step process, and a CTA into the order form.
 * Keywords: po meri, custom, proces, home
 * Viewport Width: 1440
 *
 * @package Boxara
 */

$boxara_custom_url = home_url( '/po-meri/' );

$boxara_showcase_id  = 1300;
$boxara_showcase_url = wp_get_attachment_image_url( $boxara_showcase_id, 'large' );

$boxara_grain_id  = 1301;
$boxara_grain_url = wp_get_attachment_image_url( $boxara_grain_id, 'full' );
?>
<!-- wp:group {"className":"home-custom-made","layout":{"type":"constrained"}} -->
<div class="wp-block-group home-custom-made">

	<?php if ( $boxara_grain_url ) : ?>
	<img class="home-custom-made__grain" src="<?php echo esc_url( $boxara_grain_url ); ?>" alt="" aria-hidden="true" loading="lazy" />
	<?php endif; ?>

	<!-- wp:group {"className":"home-custom-made__heading","layout":{"type":"constrained"}} -->
	<div class="wp-block-group home-custom-made__heading">

		<!-- wp:paragraph {"className":"home-custom-made__eyebrow","fontFamily":"accent"} -->
		<p class="home-custom-made__eyebrow has-accent-font-family">Samo za tebe.</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"className":"home-custom-made__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading home-custom-made__title has-display-font-family js-reveal-words">Umetnost po meri</h2>
		<!-- /wp:heading -->

	</div>
	<!-- /wp:group -->

	<div class="home-custom-made__grid">

		<?php if ( $boxara_showcase_url ) : ?>
		<div class="home-custom-made__showcase js-reveal-section" style="--reveal-i:0">
			<img src="<?php echo esc_url( $boxara_showcase_url ); ?>" alt="Gotov ram naspram originalne referentne fotografije" loading="lazy" />
		</div>
		<?php endif; ?>

		<div class="home-custom-made__process-col js-reveal-section" style="--reveal-i:1">

			<ol class="home-custom-made__process">

				<li class="home-custom-made__step js-reveal-section" style="--reveal-i:2">
					<span class="home-custom-made__step-icon"><?php boxara_icon( 'step-choose' ); ?></span>
					<span class="home-custom-made__step-copy">
						<span class="home-custom-made__step-heading"><span class="home-custom-made__step-number">1</span>Izaberi svoju temu</span>
						<span class="home-custom-made__step-desc">Izaberi temu ili otpremi svoju referentnu fotografiju.</span>
					</span>
				</li>

				<li class="home-custom-made__step js-reveal-section" style="--reveal-i:3">
					<span class="home-custom-made__step-icon"><?php boxara_icon( 'step-create' ); ?></span>
					<span class="home-custom-made__step-copy">
						<span class="home-custom-made__step-heading"><span class="home-custom-made__step-number">2</span>Mi dizajniramo i pravimo</span>
						<span class="home-custom-made__step-desc">Naši umetnici dizajniraju slojeve i ručno sklapaju tvoj komad.</span>
					</span>
				</li>

				<li class="home-custom-made__step js-reveal-section" style="--reveal-i:4">
					<span class="home-custom-made__step-icon"><?php boxara_icon( 'step-deliver' ); ?></span>
					<span class="home-custom-made__step-copy">
						<span class="home-custom-made__step-heading"><span class="home-custom-made__step-number">3</span>Dostavljamo do tebe</span>
						<span class="home-custom-made__step-desc">Pažljivo upakovano i spremno za kačenje u tvom prostoru.</span>
					</span>
				</li>

			</ol>

			<!-- wp:buttons {"className":"home-custom-made__cta"} -->
			<div class="wp-block-buttons home-custom-made__cta">
				<!-- wp:button {"className":"is-style-fill"} -->
				<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $boxara_custom_url ); ?>">Naruči ram</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->

		</div>

	</div>

</div>
<!-- /wp:group -->
