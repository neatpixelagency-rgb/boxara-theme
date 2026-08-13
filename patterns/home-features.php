<?php
/**
 * Title: Home — Features
 * Slug: boxara/home-features
 * Categories: boxara-home
 * Description: Two feature blocks explaining what sets the craft apart — layered hand assembly and premium frames.
 * Keywords: prednosti, features, home
 * Viewport Width: 1440
 *
 * @package Boxara
 */

$boxara_craft_hands_url    = wp_get_attachment_image_url( 1302, 'large' );
$boxara_premium_frames_url = wp_get_attachment_image_url( 1303, 'large' );
?>
<!-- wp:group {"className":"home-features","layout":{"type":"constrained"}} -->
<div class="wp-block-group home-features">

	<!-- wp:group {"className":"home-features__heading","layout":{"type":"constrained"}} -->
	<div class="wp-block-group home-features__heading">

		<!-- wp:paragraph {"className":"home-features__eyebrow","fontFamily":"accent"} -->
		<p class="home-features__eyebrow has-accent-font-family">Šta nas čini drugačijim</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"className":"home-features__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading home-features__title has-display-font-family">Dizajn koji ima pravu <mark style="background-color:rgba(0,0,0,0)" class="has-inline-color has-brand-color">dubinu</mark>.</h2>
		<!-- /wp:heading -->

	</div>
	<!-- /wp:group -->

	<div class="home-features__row">

		<div class="home-features__item">
			<?php if ( $boxara_craft_hands_url ) : ?>
			<span class="home-features__image">
				<img src="<?php echo esc_url( $boxara_craft_hands_url ); ?>" alt="Ručno sklapanje slojeva umetničkog dela" loading="lazy" />
			</span>
			<?php endif; ?>
			<h3 class="home-features__item-title">Ručno izrađeno u slojevima</h3>
			<p class="home-features__item-desc">Ručno sklapamo svaki sloj sa preciznošću kako bismo stvorili dubinu koja prelepo hvata prirodno i galerijsko svetlo, privlačeći pažnju iz svakog ugla.</p>
		</div>

		<div class="home-features__item">
			<?php if ( $boxara_premium_frames_url ) : ?>
			<span class="home-features__image">
				<img src="<?php echo esc_url( $boxara_premium_frames_url ); ?>" alt="Detalj ćoška premium drvenog rama" loading="lazy" />
			</span>
			<?php endif; ?>
			<h3 class="home-features__item-title">Napravljeno da traje</h3>
			<p class="home-features__item-desc">Koristeći muzejski kvalitet teksturiranog papira i posebno izrađene ramove, svaki Boxara komad je napravljen kao vrhunska relikvija dizajnirana da ostane živopisna decenijama.</p>
		</div>

	</div>

</div>
<!-- /wp:group -->
