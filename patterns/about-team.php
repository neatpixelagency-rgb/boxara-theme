<?php
/**
 * Title: About — Team
 * Slug: boxara/about-team
 * Categories: boxara-home
 * Description: Founder cards — name, role, bio and photo.
 * Keywords: o nama, about, ekipa, team, osnivaci
 * Viewport Width: 1440
 *
 * @package Boxara
 */

// Founder photos, matching Figma node 233:1953 (nodes 233:1959 and 233:1966),
// uploaded to the Media Library.
$boxara_team = array(
	array(
		'name'  => 'Sara',
		'role'  => 'Osnivač i Master Sklapanja',
		'bio'   => 'Sara je srce našeg ateljea. Ona voli da svaki komad bude savršen, ne samo lep, već i osećaj koji ostaje u prostoriji.',
		'photo' => 1338,
	),
	array(
		'name'  => 'Marko',
		'role'  => 'Partner i Tehnička Podrška',
		'bio'   => 'Marko voli da stvara stvari koje nisu samo lepe, već i inteligentne. On vidi svet kao slojeve koji čekaju da budu otkriveni.',
		'photo' => 1339,
	),
);
?>
<!-- wp:group {"className":"about-team","layout":{"type":"constrained"}} -->
<div class="wp-block-group about-team">

	<!-- wp:group {"className":"about-team__heading","layout":{"type":"constrained"}} -->
	<div class="wp-block-group about-team__heading">

		<!-- wp:paragraph {"className":"about-team__eyebrow"} -->
		<p class="about-team__eyebrow">NAŠA EKIPA</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"className":"about-team__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading about-team__title has-display-font-family js-reveal-words">UPOZNAJTE <mark style="background-color:rgba(0,0,0,0)" class="has-inline-color has-brand-color">OSNIVAČE</mark></h2>
		<!-- /wp:heading -->

	</div>
	<!-- /wp:group -->

	<div class="about-team__row">
		<?php foreach ( $boxara_team as $boxara_member_i => $boxara_member ) : ?>
			<div class="about-team__card js-reveal-section" style="--reveal-i:<?php echo (int) $boxara_member_i; ?>">
				<div class="about-team__photo">
					<?php if ( $boxara_member['photo'] ) : ?>
						<img src="<?php echo esc_url( wp_get_attachment_image_url( $boxara_member['photo'], 'large' ) ); ?>" alt="<?php echo esc_attr( $boxara_member['name'] ); ?>" loading="lazy" />
					<?php else : ?>
						<span class="about-team__photo-placeholder" aria-hidden="true"><?php boxara_icon( 'avatar-placeholder' ); ?></span>
					<?php endif; ?>
				</div>
				<div class="about-team__details">
					<div class="about-team__id">
						<p class="about-team__name"><?php echo esc_html( $boxara_member['name'] ); ?></p>
						<p class="about-team__role"><?php echo esc_html( $boxara_member['role'] ); ?></p>
					</div>
					<p class="about-team__bio"><?php echo esc_html( $boxara_member['bio'] ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

</div>
<!-- /wp:group -->
