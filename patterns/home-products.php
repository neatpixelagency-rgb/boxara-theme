<?php
/**
 * Title: Home — Products Showcase
 * Slug: boxara/home-products
 * Categories: boxara-home
 * Description: Grid of the store's most popular products with a real add-to-cart button.
 * Keywords: proizvodi, products, najpopularniji, home
 * Viewport Width: 1440
 *
 * @package Boxara
 */

/*
 * Real products, ordered by popularity (WooCommerce's own sales-count
 * ordering) rather than the eight identical Figma placeholders — this is
 * what "Najpopularniji" (Most Popular) actually means, and it changes as
 * the store sells.
 */
$boxara_products = function_exists( 'wc_get_products' )
	? wc_get_products(
		array(
			'status'  => 'publish',
			'limit'   => 8,
			'orderby' => 'popularity',
		)
	)
	: array();

$boxara_shop_url = function_exists( 'wc_get_page_permalink' )
	? wc_get_page_permalink( 'shop' )
	: home_url( '/' );
?>
<!-- wp:group {"className":"home-products","layout":{"type":"constrained"}} -->
<div class="wp-block-group home-products">

	<!-- wp:group {"className":"home-products__header","layout":{"type":"flex","justifyContent":"space-between"}} -->
	<div class="wp-block-group home-products__header">

		<!-- wp:heading {"level":2,"className":"home-products__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading home-products__title has-display-font-family js-reveal-words">Najpopularniji</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"className":"home-products__link"} -->
		<p class="home-products__link"><a href="<?php echo esc_url( $boxara_shop_url ); ?>">Pogledaj sve</a></p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

	<?php if ( $boxara_products ) : ?>
	<div class="home-products__grid">
		<?php
		foreach ( $boxara_products as $boxara_product_i => $boxara_product ) :
			global $product;
			$product = $boxara_product; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- required by woocommerce_template_loop_add_to_cart(), which reads the global.

			$boxara_terms    = get_the_terms( $boxara_product->get_id(), 'product_cat' );
			$boxara_category = ( $boxara_terms && ! is_wp_error( $boxara_terms ) ) ? $boxara_terms[0]->name : '';
			$boxara_image    = get_the_post_thumbnail_url( $boxara_product->get_id(), 'medium_large' );
			?>
			<div class="home-products__card js-reveal-section" style="--reveal-i:<?php echo (int) ( $boxara_product_i % 4 ); ?>">
				<a class="home-products__image" href="<?php echo esc_url( get_permalink( $boxara_product->get_id() ) ); ?>">
					<?php if ( $boxara_image ) : ?>
						<img src="<?php echo esc_url( $boxara_image ); ?>" alt="<?php echo esc_attr( $boxara_product->get_name() ); ?>" loading="lazy" />
					<?php endif; ?>
				</a>
				<div class="home-products__info">
					<div class="home-products__meta">
						<?php if ( $boxara_category ) : ?>
							<span class="home-products__category"><?php echo esc_html( $boxara_category ); ?></span>
						<?php endif; ?>
						<a class="home-products__name" href="<?php echo esc_url( get_permalink( $boxara_product->get_id() ) ); ?>"><?php echo esc_html( $boxara_product->get_name() ); ?></a>
					</div>
					<span class="home-products__price"><?php echo wp_kses_post( $boxara_product->get_price_html() ); ?></span>
					<div class="home-products__cta">
						<?php woocommerce_template_loop_add_to_cart(); ?>
					</div>
				</div>
			</div>
			<?php
		endforeach;
		unset( $GLOBALS['product'] );
		?>
	</div>
	<?php endif; ?>

</div>
<!-- /wp:group -->
