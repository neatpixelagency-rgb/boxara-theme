<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Boxara
 */

$boxara_footer_columns = array(
	'footer-shop'    => __( 'Prodavnica', 'boxara' ),
	'footer-company' => __( 'Kompanija', 'boxara' ),
	'footer-help'    => __( 'Pomoć', 'boxara' ),
);

// Same map graphic as the Kontakt page — real Belgrade map, Knez Mihailova pin.
$boxara_footer_map_url = wp_get_attachment_image_url( 1317, 'medium_large' );
?>

	<footer id="colophon" class="site-footer">
		<div class="site-footer__inner">

			<div class="site-footer__content">

				<div class="site-footer__brand">
					<?php boxara_site_logo(); ?>
					<p class="site-footer__tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
				</div>

				<div class="site-footer__grid">

					<?php foreach ( $boxara_footer_columns as $boxara_location => $boxara_label ) : ?>
						<?php if ( has_nav_menu( $boxara_location ) ) : ?>
							<div class="site-footer__col">
								<h2 class="site-footer__heading"><?php echo esc_html( $boxara_label ); ?></h2>
								<?php
								wp_nav_menu(
									array(
										'theme_location' => $boxara_location,
										'menu_class'     => 'site-footer__menu',
										'container'      => false,
										'depth'          => 1,
									)
								);
								?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>

					<?php
					$boxara_social = boxara_social_links();
					if ( $boxara_social ) :
						?>
						<div class="site-footer__col site-footer__col--social">
							<h2 class="site-footer__heading"><?php esc_html_e( 'Social', 'boxara' ); ?></h2>
							<ul class="site-footer__social">
								<?php foreach ( $boxara_social as $boxara_key => $boxara_link ) : ?>
									<li>
										<a
											class="site-footer__social-link"
											href="<?php echo esc_url( $boxara_link['url'] ); ?>"
											rel="noopener noreferrer"
											target="_blank"
										>
											<span class="screen-reader-text"><?php echo esc_html( $boxara_link['label'] ); ?></span>
											<?php boxara_icon( $boxara_key ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>

				</div>

				<?php if ( $boxara_footer_map_url ) : ?>
					<a
						class="site-footer__map"
						href="https://maps.google.com/?q=Knez+Mihailova+24,+Beograd"
						target="_blank"
						rel="noopener noreferrer"
						aria-label="<?php esc_attr_e( 'Otvori lokaciju na mapi', 'boxara' ); ?>"
					>
						<img src="<?php echo esc_url( $boxara_footer_map_url ); ?>" alt="" loading="lazy" />
					</a>
				<?php endif; ?>

			</div>

			<div class="site-footer__legal">
				<p class="site-footer__copyright">
					<?php
					printf(
						/* translators: 1: current year, 2: site name */
						esc_html__( '© %1$s %2$s. All rights reserved.', 'boxara' ),
						esc_html( gmdate( 'Y' ) ),
						esc_html( get_bloginfo( 'name' ) )
					);
					?>
				</p>

				<?php if ( has_nav_menu( 'footer-legal' ) ) : ?>
					<nav class="site-footer__legal-nav" aria-label="<?php esc_attr_e( 'Legal', 'boxara' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-legal',
								'menu_class'     => 'site-footer__legal-menu',
								'container'      => false,
								'depth'          => 1,
							)
						);
						?>
					</nav>
				<?php endif; ?>
			</div>

		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
