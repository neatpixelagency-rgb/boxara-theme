<?php
/**
 * Single product page.
 *
 * Overrides WooCommerce's hook-driven default with the Figma layout:
 * gallery, meta column (title, price, description, frame-colour swatches,
 * add-to-cart), a specs grid, and related products. Real WooCommerce
 * functions/hooks power the parts that need to (gallery, variations form,
 * add-to-cart, related products) — only the wrapping markup is custom.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}

$boxara_terms      = get_the_terms( $product->get_id(), 'product_cat' );
$boxara_collection = ( $boxara_terms && ! is_wp_error( $boxara_terms ) ) ? $boxara_terms[0]->name : '';

$boxara_tags = get_the_terms( $product->get_id(), 'product_tag' );
$boxara_tag  = ( $boxara_tags && ! is_wp_error( $boxara_tags ) ) ? $boxara_tags[0]->name : '';

$boxara_artist = get_post_meta( $product->get_id(), '_boxara_artist', true );
$boxara_sales  = (int) $product->get_total_sales();
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'shop-product-page', $product ); ?>>

	<div class="shop-product-page__hero">

		<div class="shop-product-page__gallery">
			<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>

		<div class="shop-product-page__summary">

			<div class="shop-product-page__header">

				<?php if ( $boxara_collection || $boxara_tag ) : ?>
					<p class="shop-product-page__eyebrow">
						<?php if ( $boxara_collection ) : ?>
							<span class="shop-product-page__eyebrow-collection">Kolekcija: <?php echo esc_html( $boxara_collection ); ?></span>
						<?php endif; ?>
						<?php if ( $boxara_collection && $boxara_tag ) : ?>
							<span class="shop-product-page__eyebrow-divider" aria-hidden="true"></span>
						<?php endif; ?>
						<?php if ( $boxara_tag ) : ?>
							<span class="shop-product-page__eyebrow-tag"><?php echo esc_html( $boxara_tag ); ?></span>
						<?php endif; ?>
					</p>
				<?php endif; ?>

				<h1 class="shop-product-page__title"><?php the_title(); ?></h1>

				<?php if ( $boxara_artist ) : ?>
					<p class="shop-product-page__signature">Autor: <span><?php echo esc_html( $boxara_artist ); ?></span></p>
				<?php endif; ?>

			</div>

			<div class="shop-product-page__price-row">
				<span class="shop-product-page__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
				<?php if ( $boxara_sales > 0 ) : ?>
					<span class="shop-product-page__sold">
						<span class="shop-product-page__sold-dot" aria-hidden="true"></span>
						<?php
						printf(
							/* translators: %d: number of units sold. */
							esc_html( _n( '%d prodato', '%d prodato', $boxara_sales, 'boxara' ) ),
							(int) $boxara_sales
						);
						?>
					</span>
				<?php endif; ?>
			</div>

			<?php if ( $product->get_short_description() ) : ?>
				<div class="shop-product-page__desc">
					<?php echo wp_kses_post( wpautop( $product->get_short_description() ) ); ?>
				</div>
			<?php endif; ?>

			<div class="shop-product-page__cart">
				<?php
				/**
				 * Hook: woocommerce_single_product_summary priority 30.
				 *
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 */
				woocommerce_template_single_add_to_cart();
				?>
			</div>

		</div>

	</div>

	<?php
	$boxara_specs = boxara_get_product_specs( $product );
	if ( $boxara_specs ) :
		?>
		<div class="shop-product-page__specs">
			<div class="shop-product-page__specs-inner">
				<h2 class="shop-product-page__specs-title">Detalji i specifikacije</h2>
				<div class="shop-product-page__specs-grid">
					<?php foreach ( $boxara_specs as $boxara_spec ) : ?>
						<div class="shop-product-page__spec-row">
							<span class="shop-product-page__spec-label"><?php echo esc_html( $boxara_spec['label'] ); ?></span>
							<span class="shop-product-page__spec-value"><?php echo esc_html( $boxara_spec['value'] ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div class="shop-product-page__related">
		<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked woocommerce_output_related_products - 20 (styled via .related in product.css)
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>

</div>
