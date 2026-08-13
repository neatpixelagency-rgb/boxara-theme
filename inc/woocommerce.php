<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package Boxara
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function boxara_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'boxara_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function boxara_woocommerce_scripts() {
	/*
	 * Skip on shop/category archives and single products: this is the
	 * untouched _s scaffold stylesheet, and its ul.products li.product {
	 * width: 30.8%; float: left; } (line ~95) beats both archive-product.php
	 * and the single-product related-products grid on specificity alone,
	 * squashing every card to a sliver. shop.css fully replaces it on both.
	 * Left in place on cart/checkout/my-account, which have no other
	 * styling yet.
	 */
	if ( ! ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() || is_product() ) ) ) {
		wp_enqueue_style( 'boxara-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );
	}

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'boxara-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'boxara_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function boxara_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'boxara_woocommerce_active_body_class' );

/**
 * Force Latin-script Serbian on WooCommerce's own add-to-cart strings.
 *
 * The site locale is `sr_RS`, which WordPress.org only ships as Cyrillic —
 * there is no `sr_RS@latin` translation to install. Every piece of copy
 * this theme authors is already Latin (see theme.json: Bebas Neue and
 * Allison carry no Cyrillic glyphs at all), so WooCommerce's own Cyrillic
 * strings on the homepage product grid would be the only mixed-script text
 * on the page. These four filters are the complete set
 * `woocommerce_template_loop_add_to_cart()` reads, for both simple and
 * variable products.
 */
function boxara_woocommerce_add_to_cart_text( $text, $product ) {
	if ( ! $product->is_purchasable() ) {
		return __( 'Pročitaj više', 'boxara' );
	}

	return $product->is_type( 'variable' ) ? __( 'Izaberi opcije', 'boxara' ) : __( 'Dodaj u korpu', 'boxara' );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'boxara_woocommerce_add_to_cart_text', 10, 2 );

/**
 * Latin aria-label for the add-to-cart link, product name included.
 *
 * @param string     $description Existing description.
 * @param WC_Product $product     Product the link is for.
 * @return string
 */
function boxara_woocommerce_add_to_cart_description( $description, $product ) {
	$label = $product->is_type( 'variable' ) ? __( 'Izaberi opcije za', 'boxara' ) : __( 'Dodaj u korpu', 'boxara' );

	return sprintf(
		/* translators: 1: action label, 2: product name. */
		__( '%1$s: "%2$s"', 'boxara' ),
		$label,
		$product->get_name()
	);
}
add_filter( 'woocommerce_product_add_to_cart_description', 'boxara_woocommerce_add_to_cart_description', 10, 2 );

/**
 * Latin AJAX success message, product name included.
 *
 * @param string     $message Existing message.
 * @param WC_Product $product Product that was added.
 * @return string
 */
function boxara_woocommerce_add_to_cart_success_message( $message, $product ) {
	return sprintf(
		/* translators: %s: product name. */
		__( '"%s" je dodat u vašu korpu.', 'boxara' ),
		$product->get_name()
	);
}
add_filter( 'woocommerce_product_add_to_cart_success_message', 'boxara_woocommerce_add_to_cart_success_message', 10, 2 );

/**
 * Latin screen-reader hint for variable products ("This product has
 * multiple variants…") — the one WooCommerce string left untouched by the
 * three filters above, since it comes from a separate method.
 *
 * @param string     $text    Existing text.
 * @param WC_Product $product Product the link is for.
 * @return string
 */
function boxara_woocommerce_add_to_cart_aria_describedby( $text, $product ) {
	if ( ! $text ) {
		return $text;
	}

	return __( 'Ovaj proizvod ima više varijanti. Opcije možeš izabrati na stranici proizvoda.', 'boxara' );
}
add_filter( 'woocommerce_product_add_to_cart_aria_describedby', 'boxara_woocommerce_add_to_cart_aria_describedby', 10, 2 );

/**
 * Latin Serbian checkout "Place order" button text — same reasoning as the
 * add-to-cart filters above: this is a decisive call-to-action, not
 * background copy, so it's hardcoded rather than left to translation.
 *
 * @return string
 */
function boxara_woocommerce_order_button_text() {
	return __( 'Potvrdi porudžbinu', 'boxara' );
}
add_filter( 'woocommerce_order_button_text', 'boxara_woocommerce_order_button_text' );

/**
 * Latin Serbian thank-you page confirmation text.
 *
 * @return string
 */
function boxara_woocommerce_order_received_text() {
	return __( 'Hvala vam. Vaša porudžbina je uspešno primljena — javićemo vam se sa daljim detaljima.', 'boxara' );
}
add_filter( 'woocommerce_thankyou_order_received_text', 'boxara_woocommerce_order_received_text' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function boxara_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'boxara_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'boxara_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function boxara_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'boxara_woocommerce_wrapper_before' );

if ( ! function_exists( 'boxara_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function boxara_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'boxara_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'boxara_woocommerce_header_cart' ) ) {
			boxara_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'boxara_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function boxara_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		boxara_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'boxara_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'boxara_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function boxara_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'boxara' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'boxara' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'boxara_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function boxara_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php boxara_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

/**
 * Shop / category archive (archive-product.php, woocommerce/content-product.php).
 *
 * The Figma design has no result count or sort dropdown, and swaps the
 * default numbered pagination for a single "Load more" link — this section
 * un-hooks the WooCommerce defaults that don't match and hooks the
 * replacements.
 */

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'boxara_shop_load_more', 10 );

/**
 * Single "Load more" link instead of numbered pagination — matches the
 * Figma "Učitaj više proizvoda" button. Progressive enhancement: a real
 * link to the next page of results, not an AJAX append, so it works with
 * JavaScript off and needs no extra script.
 *
 * @return void
 */
function boxara_shop_load_more() {
	global $wp_query;

	$current = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );

	if ( $current >= $wp_query->max_num_pages ) {
		return;
	}

	$next_url = get_next_posts_page_link( $wp_query->max_num_pages );
	if ( ! $next_url ) {
		return;
	}

	// Data attributes are read by shop.js to fetch and append the next page
	// without a reload; the <a href> underneath is the no-JS fallback.
	$category = is_product_category() ? get_queried_object()->slug : '';
	?>
	<div
		class="shop-pagination"
		data-shop-pagination
		data-next-page="<?php echo (int) ( $current + 1 ); ?>"
		data-category="<?php echo esc_attr( $category ); ?>"
		data-search="<?php echo esc_attr( get_search_query() ); ?>"
	>
		<a class="shop-pagination__link" href="<?php echo esc_url( $next_url ); ?>">Učitaj više proizvoda</a>
	</div>
	<?php
}

/**
 * AJAX: render the next page of the shop/category grid.
 *
 * Re-runs the same product query the page itself would run for that page
 * number (category + search term passed from the button's data attributes),
 * so results match exactly what a full page load would have shown.
 *
 * @return void
 */
function boxara_ajax_load_more_products() {
	check_ajax_referer( 'boxara_load_more_products', 'nonce' );

	$page     = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 2;
	$category = isset( $_POST['category'] ) ? sanitize_title( wp_unslash( $_POST['category'] ) ) : '';
	$search   = isset( $_POST['search'] ) ? sanitize_text_field( wp_unslash( $_POST['search'] ) ) : '';

	$ordering = WC()->query->get_catalog_ordering_args();

	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'paged'          => max( 1, $page ),
		'posts_per_page' => apply_filters( 'loop_shop_per_page', wc_get_default_products_per_row() * wc_get_default_product_rows_per_page() ),
		'orderby'        => $ordering['orderby'],
		'order'          => $ordering['order'],
	);

	if ( ! empty( $ordering['meta_key'] ) ) {
		$args['meta_key'] = $ordering['meta_key']; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
	}

	if ( $category ) {
		$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	if ( $search ) {
		$args['s'] = $search;
	}

	$query = new WP_Query( $args );

	ob_start();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			global $product;
			$product = wc_get_product( get_the_ID() ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- content-product.php reads this global, same as the main loop.
			wc_get_template_part( 'content', 'product' );
		}
	}
	wp_reset_postdata();

	wp_send_json_success(
		array(
			'html'     => ob_get_clean(),
			'has_more' => $page < $query->max_num_pages,
		)
	);
}
add_action( 'wp_ajax_boxara_load_more_products', 'boxara_ajax_load_more_products' );
add_action( 'wp_ajax_nopriv_boxara_load_more_products', 'boxara_ajax_load_more_products' );

/**
 * Category tabs above the product grid: "Sve" plus every non-empty product
 * category (bestsellers excluded — it's a merchandising tag, not a subject
 * category, same call made on the homepage collections section).
 *
 * @return void
 */
function boxara_shop_category_tabs() {
	$exclude    = array();
	$bestseller = get_term_by( 'slug', 'bestsellers', 'product_cat' );
	if ( $bestseller ) {
		$exclude[] = $bestseller->term_id;
	}

	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'orderby'    => 'name',
			'hide_empty' => true,
			'exclude'    => $exclude,
		)
	);

	if ( is_wp_error( $terms ) ) {
		return;
	}

	$shop_url   = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
	$queried    = is_product_category() ? get_queried_object() : null;
	?>
	<div class="shop-tabs">
		<a class="shop-tabs__tab<?php echo ( is_shop() && ! $queried ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( $shop_url ); ?>">Sve</a>
		<?php foreach ( $terms as $term ) : ?>
			<a class="shop-tabs__tab<?php echo ( $queried && $queried->term_id === $term->term_id ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Single product (content-single-product.php, add-to-cart/variable.php).
 */

// The description/reviews/additional-info tabs and the upsell strip are not
// in the Figma design — only related products survive on this hook.
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

// Custom Fields metabox isn't shown on the product edit screen by default;
// this is the only way to reach `_boxara_artist` until/unless the client
// wants a proper field for it.
add_post_type_support( 'product', 'custom-fields' );

/**
 * Specs shown in the "Detalji i specifikacije" grid.
 *
 * Real WooCommerce dimension/weight fields when set, plus the frame and
 * material construction shared by every Boxara piece (same claim already
 * made on the homepage Features section) — never a fabricated per-product
 * number like layer count or year made, since there's no data source for
 * either yet.
 *
 * @param WC_Product $product Product to read specs from.
 * @return array<int, array{label: string, value: string}>
 */
function boxara_get_product_specs( $product ) {
	$specs = array();

	if ( $product->has_dimensions() ) {
		$specs[] = array(
			'label' => 'Dimenzije',
			'value' => wc_format_dimensions( $product->get_dimensions( false ) ),
		);
	}

	$specs[] = array(
		'label' => 'Materijal',
		'value' => 'Arhivski, muzejski kvalitet papira',
	);

	$specs[] = array(
		'label' => 'Ram',
		'value' => 'Premium drveni ram, ručno izrađen',
	);

	if ( $product->has_weight() ) {
		$specs[] = array(
			'label' => 'Težina',
			'value' => wc_format_weight( $product->get_weight() ),
		);
	}

	// Any custom (non-variation) product attribute — e.g. a client-entered
	// "Slojevi" or "Godina izrade" — surfaces here automatically. This is
	// WooCommerce's own "custom product attribute" mechanism, not a bespoke
	// field: nothing to build when real per-product specs are ready.
	foreach ( $product->get_attributes() as $attribute ) {
		if ( $attribute->get_variation() ) {
			continue;
		}

		$specs[] = array(
			'label' => wc_attribute_label( $attribute->get_name() ),
			'value' => implode( ', ', $attribute->is_taxonomy() ? wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'names' ) ) : $attribute->get_options() ),
		);
	}

	return $specs;
}

/**
 * Guess a swatch fill colour from a frame-colour attribute term name
 * ("Beli Ram", "Crni Ram", "Braon Ram" …) — there is no colour meta on the
 * term itself, just the Serbian name, so this matches on keyword.
 *
 * @param string $label Attribute term name.
 * @return string CSS color value.
 */
function boxara_swatch_color_from_label( $label ) {
	$label = boxara_transliterate_lower( $label );

	$map = array(
		'beli'  => '#ffffff',
		'crni'  => '#0a0a0a',
		'braon' => '#7a5a3d',
		'siv'   => '#a8a59d',
		'zlat'  => '#c9a24b',
	);

	foreach ( $map as $needle => $color ) {
		if ( false !== strpos( $label, $needle ) ) {
			return $color;
		}
	}

	return 'var(--wp--custom--color--stroke-warm)';
}

/**
 * Lowercase a Serbian Latin string enough for keyword matching — swaps the
 * diacritics boxara_swatch_color_from_label() might see (rama boja terms
 * are hand-typed, so both are possible) down to their plain-Latin base.
 *
 * @param string $text Input text.
 * @return string
 */
function boxara_transliterate_lower( $text ) {
	$text = mb_strtolower( $text );
	return strtr(
		$text,
		array(
			'č' => 'c',
			'ć' => 'c',
			'š' => 's',
			'ž' => 'z',
			'đ' => 'dj',
		)
	);
}

/**
 * Thank-you page (checkout/thankyou.php).
 *
 * WooCommerce's default order-details table duplicates what
 * thankyou.php already shows (order number, items, total) in unstyled
 * markup — dropped in favour of the custom summary card. The billing
 * address it also carries is real, useful info, so thankyou.php prints
 * that itself instead.
 */
remove_action( 'woocommerce_thankyou', 'woocommerce_order_details_table', 10 );

/**
 * Latin Serbian order date, e.g. "13. avgust 2026." — the one piece of
 * WooCommerce output the transliteration plugin doesn't reach, since
 * WordPress core's date_i18n() pulls month names straight from the sr_RS
 * (Cyrillic) core translation rather than through a filterable string.
 *
 * @param WC_DateTime $date Order date.
 * @return string
 */
function boxara_format_order_date( $date ) {
	if ( ! $date ) {
		return '';
	}

	$months = array(
		1  => 'januar',
		2  => 'februar',
		3  => 'mart',
		4  => 'april',
		5  => 'maj',
		6  => 'jun',
		7  => 'jul',
		8  => 'avgust',
		9  => 'septembar',
		10 => 'oktobar',
		11 => 'novembar',
		12 => 'decembar',
	);

	return sprintf(
		'%1$d. %2$s %3$d.',
		(int) $date->date( 'j' ),
		$months[ (int) $date->date( 'n' ) ],
		(int) $date->date( 'Y' )
	);
}
