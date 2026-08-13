<?php
/**
 * Header and footer helper functions.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output the site logo.
 *
 * Uses the Customizer custom logo when one is set, otherwise falls back to
 * the site title as text. On the front page the wrapper is an <h1> for
 * document outline; elsewhere it is a <p>.
 */
function boxara_site_logo() {
	$tag = ( is_front_page() && is_home() ) ? 'h1' : 'p';

	printf( '<%1$s class="site-logo">', esc_attr( $tag ) );

	if ( has_custom_logo() ) {
		the_custom_logo();
	} else {
		printf(
			'<a class="site-logo__text" href="%1$s" rel="home">%2$s</a>',
			esc_url( home_url( '/' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
	}

	printf( '</%1$s>', esc_attr( $tag ) );
}

/**
 * Output the cart link with an item-count badge.
 *
 * Renders nothing when WooCommerce is inactive, so the header stays valid
 * on a plain WordPress install.
 */
function boxara_cart_link() {
	if ( ! function_exists( 'wc_get_cart_url' ) || ! WC()->cart ) {
		return;
	}

	$count = (int) WC()->cart->get_cart_contents_count();

	printf(
		'<a class="site-header__cart" href="%1$s" data-cart-link><span class="screen-reader-text">%2$s</span>%3$s%4$s</a>',
		esc_url( wc_get_cart_url() ),
		esc_html__( 'View cart', 'boxara' ),
		wp_kses( boxara_get_icon( 'cart' ), boxara_svg_allowed_html() ),
		$count > 0
			? sprintf(
				'<span class="site-header__cart-count" data-cart-count>%s</span>',
				esc_html( number_format_i18n( $count ) )
			)
			: ''
	);
}

/**
 * Social profile links, filtered and emptied of anything unset.
 *
 * Values come from the Customizer (Site Identity → Social).
 *
 * @return array<string, array{url:string,label:string}>
 */
function boxara_social_links() {
	$networks = array(
		'instagram' => __( 'Instagram', 'boxara' ),
		'facebook'  => __( 'Facebook', 'boxara' ),
		'pinterest' => __( 'Pinterest', 'boxara' ),
	);

	$links = array();
	foreach ( $networks as $key => $label ) {
		$url = get_theme_mod( "boxara_social_{$key}", '' );
		if ( $url ) {
			$links[ $key ] = array(
				'url'   => $url,
				'label' => $label,
			);
		}
	}

	/**
	 * Filter the social links shown in the footer.
	 *
	 * @param array $links Keyed by icon name.
	 */
	return apply_filters( 'boxara_social_links', $links );
}

/**
 * Register Customizer controls for the social profile URLs.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function boxara_customize_social( $wp_customize ) {
	$wp_customize->add_section(
		'boxara_social',
		array(
			'title'    => __( 'Social Profiles', 'boxara' ),
			'priority' => 45,
		)
	);

	$networks = array(
		'instagram' => __( 'Instagram URL', 'boxara' ),
		'facebook'  => __( 'Facebook URL', 'boxara' ),
		'pinterest' => __( 'Pinterest URL', 'boxara' ),
	);

	foreach ( $networks as $key => $label ) {
		$wp_customize->add_setting(
			"boxara_social_{$key}",
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			"boxara_social_{$key}",
			array(
				'label'   => $label,
				'section' => 'boxara_social',
				'type'    => 'url',
			)
		);
	}
}
add_action( 'customize_register', 'boxara_customize_social' );

/**
 * Keep the header cart badge in sync with AJAX add-to-cart.
 *
 * WooCommerce refreshes a set of fragments after every AJAX cart change;
 * registering ours here means the badge updates without a page reload.
 *
 * @param array $fragments Fragment markup keyed by CSS selector.
 * @return array
 */
function boxara_cart_count_fragment( $fragments ) {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return $fragments;
	}

	ob_start();
	boxara_cart_link();
	$fragments['a.site-header__cart'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'boxara_cart_count_fragment' );
