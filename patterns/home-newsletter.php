<?php
/**
 * Title: Home — Newsletter
 * Slug: boxara/home-newsletter
 * Categories: boxara-home
 * Description: Email capture form, wired to a real AJAX subscribe handler (see inc/newsletter.php).
 * Keywords: newsletter, email, prijava, home
 * Viewport Width: 1440
 *
 * @package Boxara
 */
?>
<!-- wp:group {"className":"home-newsletter","layout":{"type":"constrained"}} -->
<div class="wp-block-group home-newsletter">

	<span class="home-newsletter__icon" aria-hidden="true"><?php boxara_icon( 'mail' ); ?></span>

	<!-- wp:heading {"level":2,"className":"home-newsletter__title","fontFamily":"display"} -->
	<h2 class="wp-block-heading home-newsletter__title has-display-font-family">Pridruži se Boxara ekipi</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"home-newsletter__lede"} -->
	<p class="home-newsletter__lede">Dobij rani pristup novim dizajnima, ekskluzivnim kolekcijama i sadržaju iz naše radionice za izradu papirne umetnosti.</p>
	<!-- /wp:paragraph -->

	<form class="home-newsletter__form" novalidate>
		<div class="home-newsletter__row">
			<label class="screen-reader-text" for="home-newsletter-email">Tvoja email adresa</label>
			<input class="home-newsletter__input" type="email" id="home-newsletter-email" name="email" placeholder="Tvoja email adresa" autocomplete="email" required />
			<button class="home-newsletter__submit" type="submit" aria-label="Prijavi se">
				<?php boxara_icon( 'arrow-submit' ); ?>
			</button>
		</div>
		<p class="home-newsletter__status" role="status" hidden></p>
	</form>

</div>
<!-- /wp:group -->
