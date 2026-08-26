<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Boxara
 */

get_header();

$boxara_shop_url = function_exists( 'wc_get_page_permalink' )
	? wc_get_page_permalink( 'shop' )
	: home_url( '/' );
?>

	<main id="primary" class="site-main site-main--404">

		<section class="boxara-404">
			<div class="boxara-404__intro">

				<div class="boxara-404__icon">
					<?php boxara_icon( 'search' ); ?>
				</div>

				<p class="boxara-404__eyebrow"><?php esc_html_e( 'Greška 404', 'boxara' ); ?></p>

				<h1 class="boxara-404__title"><?php esc_html_e( 'Stranica nije pronađena', 'boxara' ); ?></h1>

				<p class="boxara-404__desc">
					<?php esc_html_e( 'Stranica koju tražite ne postoji, premeštena je ili je privremeno nedostupna. Proverite adresu ili se vratite na jedno od mesta ispod.', 'boxara' ); ?>
				</p>

				<form role="search" method="get" class="boxara-404__search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="boxara-404-search"><?php esc_html_e( 'Pretraga', 'boxara' ); ?></label>
					<span class="boxara-404__search-icon"><?php boxara_icon( 'search' ); ?></span>
					<input
						type="search"
						id="boxara-404-search"
						class="boxara-404__search-field"
						placeholder="<?php esc_attr_e( 'Pretraži prodavnicu…', 'boxara' ); ?>"
						value="<?php echo esc_attr( get_search_query() ); ?>"
						name="s"
					/>
					<button type="submit" class="boxara-404__search-submit">
						<span class="screen-reader-text"><?php esc_html_e( 'Pretraži', 'boxara' ); ?></span>
						<?php boxara_icon( 'arrow-right' ); ?>
					</button>
				</form>

				<div class="boxara-404__actions">
					<a class="boxara-404__cta" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php esc_html_e( 'Nazad na početnu', 'boxara' ); ?>
					</a>
					<a class="boxara-404__cta boxara-404__cta--ghost" href="<?php echo esc_url( $boxara_shop_url ); ?>">
						<?php esc_html_e( 'Pogledaj prodavnicu', 'boxara' ); ?>
					</a>
				</div>

			</div>
		</section><!-- .boxara-404 -->

	</main><!-- #primary -->

<?php
get_footer();
