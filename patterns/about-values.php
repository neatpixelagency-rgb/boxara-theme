<?php
/**
 * Title: About — Values
 * Slug: boxara/about-values
 * Categories: boxara-home
 * Description: Three numbered cards covering what sets Boxara apart — original design, premium materials, precise craft.
 * Keywords: o nama, about, vrednosti, values
 * Viewport Width: 1440
 *
 * @package Boxara
 */
?>
<!-- wp:group {"className":"about-values","layout":{"type":"constrained"}} -->
<div class="wp-block-group about-values">

	<!-- wp:group {"className":"about-values__heading","layout":{"type":"constrained"}} -->
	<div class="wp-block-group about-values__heading">

		<!-- wp:paragraph {"className":"about-values__eyebrow"} -->
		<p class="about-values__eyebrow">KVALITET BEZ KOMPROMISA</p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"className":"about-values__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading about-values__title has-display-font-family js-reveal-words">ŠTA ČINI <mark style="background-color:rgba(0,0,0,0)" class="has-inline-color has-brand-color">BOXARU</mark> POSEBNOM</h2>
		<!-- /wp:heading -->

	</div>
	<!-- /wp:group -->

	<div class="about-values__row">

		<div class="about-values__card js-reveal-section" style="--reveal-i:0">
			<div class="about-values__card-top">
				<span class="about-values__number">01</span>
				<span class="about-values__icon"><?php boxara_icon( 'value-design' ); ?></span>
			</div>
			<h3 class="about-values__card-title js-reveal-words">Unikatni Dizajn</h3>
			<p class="about-values__card-desc">Naša dela nećete naći nigde drugde. Svaki koncept je potpuno autorski, osmišljen i razvijen u našem beogradskom studiju.</p>
		</div>

		<div class="about-values__card js-reveal-section" style="--reveal-i:1">
			<div class="about-values__card-top">
				<span class="about-values__number">02</span>
				<span class="about-values__icon"><?php boxara_icon( 'value-materials' ); ?></span>
			</div>
			<h3 class="about-values__card-title js-reveal-words">Premium Materijali</h3>
			<p class="about-values__card-desc">Koristimo isključivo arhivske italijanske papire i masivne drvene ramove sa antirefleksnim staklom vrhunskog kvaliteta.</p>
		</div>

		<div class="about-values__card js-reveal-section" style="--reveal-i:2">
			<div class="about-values__card-top">
				<span class="about-values__number">03</span>
				<span class="about-values__icon"><?php boxara_icon( 'value-craft' ); ?></span>
			</div>
			<h3 class="about-values__card-title js-reveal-words">Precizna izrada</h3>
			<p class="about-values__card-desc">Svaki sloj je ručno sklopljen sa preciznošću koja čini svaki komad jedinstvenim — bez masovne proizvodnje, samo pažljivo izrađeno umetničko delo.</p>
		</div>

	</div>

</div>
<!-- /wp:group -->
