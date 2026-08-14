<?php
/**
 * Title: Home — Testimonials
 * Slug: boxara/home-testimonials
 * Categories: boxara-home
 * Description: Two customer reviews with a star rating, quote and avatar.
 * Keywords: recenzije, testimonials, reviews, home
 * Viewport Width: 1440
 *
 * @package Boxara
 */

$boxara_reviews = array(
	array(
		'quote'  => 'Dubina je neverovatna. Nikada nisam video ništa slično. Potpuno je promenila atmosferu moje kućne kancelarije. Svi pitaju za to!',
		'avatar' => wp_get_attachment_image_url( 1304, 'thumbnail' ),
		'name'   => 'Marko G.',
		'label'  => 'Verifikovani kolekcionar',
	),
	array(
		'quote'  => 'Naručila sam komad po meri za rođendan svog muža i tim je bio neverovatan. Konačni rezultat je premašio sva moja očekivanja.',
		'avatar' => wp_get_attachment_image_url( 1305, 'thumbnail' ),
		'name'   => 'Jelena S.',
		'label'  => 'Verifikovani kolekcionar',
	),
);
?>
<!-- wp:group {"className":"home-testimonials","layout":{"type":"constrained"}} -->
<div class="wp-block-group home-testimonials">

	<!-- wp:group {"className":"home-testimonials__heading","layout":{"type":"constrained"}} -->
	<div class="wp-block-group home-testimonials__heading">

		<!-- wp:heading {"level":2,"className":"home-testimonials__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading home-testimonials__title has-display-font-family js-reveal-words">Stvoreno da pripada.</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"className":"home-testimonials__subtitle"} -->
		<p class="home-testimonials__subtitle">Pravi domovi. Prave priče.</p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

	<div class="home-testimonials__grid">
		<?php foreach ( $boxara_reviews as $boxara_review_i => $boxara_review ) : ?>
		<div class="home-testimonials__card js-reveal-section" style="--reveal-i:<?php echo (int) $boxara_review_i; ?>">
			<div class="home-testimonials__stars" aria-hidden="true">
				<?php for ( $boxara_i = 0; $boxara_i < 5; $boxara_i++ ) : ?>
					<?php boxara_icon( 'star' ); ?>
				<?php endfor; ?>
			</div>
			<p class="home-testimonials__quote">&ldquo;<?php echo esc_html( $boxara_review['quote'] ); ?>&rdquo;</p>
			<div class="home-testimonials__author">
				<?php if ( $boxara_review['avatar'] ) : ?>
					<img class="home-testimonials__avatar" src="<?php echo esc_url( $boxara_review['avatar'] ); ?>" alt="" loading="lazy" />
				<?php endif; ?>
				<span class="home-testimonials__author-info">
					<span class="home-testimonials__author-name"><?php echo esc_html( $boxara_review['name'] ); ?></span>
					<span class="home-testimonials__author-label"><?php echo esc_html( $boxara_review['label'] ); ?></span>
				</span>
			</div>
		</div>
		<?php endforeach; ?>
	</div>

</div>
<!-- /wp:group -->
