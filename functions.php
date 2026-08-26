<?php
/**
 * Boxara functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Boxara
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function boxara_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Boxara, use a find and replace
		* to change 'boxara' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'boxara', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// Navigation menus: one primary, three footer columns, plus a legal bar.
	register_nav_menus(
		array(
			'menu-1'         => esc_html__( 'Primary', 'boxara' ),
			'footer-shop'    => esc_html__( 'Footer — Shop', 'boxara' ),
			'footer-company' => esc_html__( 'Footer — Company', 'boxara' ),
			'footer-help'    => esc_html__( 'Footer — Help', 'boxara' ),
			'footer-legal'   => esc_html__( 'Footer — Legal', 'boxara' ),
		)
	);

	// Block editor: let patterns and blocks span the full viewport width.
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	// Load the editor stylesheet so patterns look right inside wp-admin too.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/home.css' );
	add_editor_style( 'assets/css/about.css' );
	add_editor_style( 'assets/css/cart.css' );
	add_editor_style( 'assets/css/checkout.css' );
	add_editor_style( 'assets/css/kontakt.css' );

	// WooCommerce. Declared here so Woo does not flag the theme as unsupported.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'boxara_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'boxara_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function boxara_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'boxara_content_width', 640 );
}
add_action( 'after_setup_theme', 'boxara_content_width', 0 );

/**
 * Register the pattern category the homepage sections are grouped under.
 *
 * Pattern files themselves live in /patterns/ and are registered automatically
 * by WordPress — there is nothing to add here when a new section is created.
 */
function boxara_register_pattern_categories() {
	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category(
		'boxara-home',
		array(
			'label'       => esc_html__( 'Boxara — Homepage', 'boxara' ),
			'description' => esc_html__( 'Sections for building the Boxara homepage.', 'boxara' ),
		)
	);
}
add_action( 'init', 'boxara_register_pattern_categories' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function boxara_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'boxara' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'boxara' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'boxara_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function boxara_scripts() {
	wp_enqueue_style( 'boxara-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'boxara-style', 'rtl', 'replace' );

	// Header, footer and mobile drawer styles.
	wp_enqueue_style(
		'boxara-chrome',
		get_theme_file_uri( '/assets/css/site-chrome.css' ),
		array( 'boxara-style' ),
		_S_VERSION
	);

	// Scroll/entrance reveal system — generic, so it loads sitewide even
	// though only the homepage patterns use it today. See assets/js/reveal.js.
	wp_enqueue_style(
		'boxara-animations',
		get_theme_file_uri( '/assets/css/animations.css' ),
		array( 'boxara-chrome' ),
		_S_VERSION
	);

	wp_enqueue_script(
		'boxara-reveal',
		get_theme_file_uri( '/assets/js/reveal.js' ),
		array(),
		_S_VERSION,
		true
	);

	// Homepage section styles. Also loaded as an editor stylesheet in boxara_setup().
	wp_enqueue_style(
		'boxara-home',
		get_theme_file_uri( '/assets/css/home.css' ),
		array( 'boxara-chrome' ),
		_S_VERSION
	);

	// Shop and category archive styles + AJAX "load more".
	if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) ) {
		wp_enqueue_style(
			'boxara-shop',
			get_theme_file_uri( '/assets/css/shop.css' ),
			array( 'boxara-chrome' ),
			_S_VERSION
		);

		wp_enqueue_script(
			'boxara-shop',
			get_theme_file_uri( '/assets/js/shop.js' ),
			array(),
			_S_VERSION,
			true
		);

		wp_localize_script(
			'boxara-shop',
			'boxaraShop',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'boxara_load_more_products' ),
				'strings' => array(
					'loading' => esc_html__( 'Učitavanje…', 'boxara' ),
				),
			)
		);
	}

	// Single product page.
	if ( function_exists( 'is_product' ) && is_product() ) {
		// Related products reuse woocommerce/content-product.php — the same
		// card template the shop archive uses — so its styling (shop.css)
		// has to load here too, not just on the archive.
		wp_enqueue_style(
			'boxara-shop',
			get_theme_file_uri( '/assets/css/shop.css' ),
			array( 'boxara-chrome' ),
			_S_VERSION
		);

		wp_enqueue_style(
			'boxara-product',
			get_theme_file_uri( '/assets/css/product.css' ),
			array( 'boxara-shop' ),
			_S_VERSION
		);

		wp_enqueue_script(
			'boxara-product',
			get_theme_file_uri( '/assets/js/product.js' ),
			array( 'wc-add-to-cart-variation' ),
			_S_VERSION,
			true
		);
	}

	// O nama (About) page.
	if ( is_page( 'o-nama' ) ) {
		wp_enqueue_style(
			'boxara-about',
			get_theme_file_uri( '/assets/css/about.css' ),
			array( 'boxara-chrome' ),
			_S_VERSION
		);
	}

	// Kontakt (Contact) page.
	if ( is_page( 'kontakt' ) ) {
		wp_enqueue_style(
			'boxara-kontakt',
			get_theme_file_uri( '/assets/css/kontakt.css' ),
			array( 'boxara-chrome' ),
			_S_VERSION
		);
	}

	// Cart page.
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		// Cross-sells reuse the shop product-card grid, same as related
		// products on the single product page.
		wp_enqueue_style(
			'boxara-shop',
			get_theme_file_uri( '/assets/css/shop.css' ),
			array( 'boxara-chrome' ),
			_S_VERSION
		);

		wp_enqueue_style(
			'boxara-cart',
			get_theme_file_uri( '/assets/css/cart.css' ),
			array( 'boxara-shop' ),
			_S_VERSION
		);
	}

	// Checkout page (also covers the thank-you / order-received screen —
	// same page, WooCommerce swaps templates internally).
	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		wp_enqueue_style(
			'boxara-checkout',
			get_theme_file_uri( '/assets/css/checkout.css' ),
			array( 'boxara-chrome' ),
			_S_VERSION
		);
	}

	// 404 (page not found) template.
	if ( is_404() ) {
		wp_enqueue_style(
			'boxara-404',
			get_theme_file_uri( '/assets/css/404.css' ),
			array( 'boxara-chrome' ),
			_S_VERSION
		);
	}

	// Replaces the Underscores navigation script — our drawer has its own behaviour.
	wp_enqueue_script(
		'boxara-chrome',
		get_theme_file_uri( '/assets/js/site-chrome.js' ),
		array(),
		_S_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'boxara_scripts' );

/**
 * Inline SVG icon helper.
 */
require get_template_directory() . '/inc/icons.php';

/**
 * Header and footer helpers.
 */
require get_template_directory() . '/inc/site-chrome.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Homepage newsletter signup.
 */
require get_template_directory() . '/inc/newsletter.php';

/**
 * Kontakt page contact form.
 */
require get_template_directory() . '/inc/contact-form.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
