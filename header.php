<?php
/**
 * The header for our theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Boxara
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'boxara' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-header__inner">

			<div class="site-header__brand">
				<?php boxara_site_logo(); ?>
			</div>

			<nav id="site-navigation" class="site-header__nav" aria-label="<?php esc_attr_e( 'Primary', 'boxara' ); ?>">
				<?php
				if ( has_nav_menu( 'menu-1' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'menu_class'     => 'nav-menu',
							'container'      => false,
							'depth'          => 2,
						)
					);
				}
				?>
			</nav>

			<div class="site-header__actions">
				<?php boxara_cart_link(); ?>

				<button
					class="site-header__toggle"
					id="menu-toggle"
					aria-controls="mobile-drawer"
					aria-expanded="false"
				>
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'boxara' ); ?></span>
					<span class="site-header__toggle-icon" data-icon="open"><?php boxara_icon( 'menu' ); ?></span>
					<span class="site-header__toggle-icon" data-icon="close"><?php boxara_icon( 'close' ); ?></span>
				</button>
			</div>

		</div>
	</header><!-- #masthead -->

	<div class="mobile-drawer" id="mobile-drawer" hidden>
		<div class="mobile-drawer__backdrop" data-drawer-close></div>
		<div class="mobile-drawer__panel" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menu', 'boxara' ); ?>">
			<?php
			if ( has_nav_menu( 'menu-1' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'mobile-menu',
						'menu_class'     => 'mobile-drawer__menu',
						'container'      => false,
						'depth'          => 2,
					)
				);
			}
			?>
		</div>
	</div>
