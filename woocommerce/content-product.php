<?php
/**
 * Product card, shop and category archive loops.
 *
 * Overrides WooCommerce's default (yourtheme/woocommerce/content-product.php)
 * with the Figma card layout. Keeps wc_product_class() on the <li> and the
 * real woocommerce_template_loop_add_to_cart() button so cart AJAX, stock
 * status and variable-product "Select options" behaviour all still work.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}

$boxara_terms    = get_the_terms( $product->get_id(), 'product_cat' );
$boxara_category = ( $boxara_terms && ! is_wp_error( $boxara_terms ) ) ? $boxara_terms[0]->name : '';
$boxara_image    = get_the_post_thumbnail_url( $product->get_id(), 'medium_large' );
?>
<li <?php wc_product_class( 'shop-product', $product ); ?>>

	<a class="shop-product__image" href="<?php echo esc_url( get_permalink() ); ?>">
		<?php if ( $boxara_image ) : ?>
			<img src="<?php echo esc_url( $boxara_image ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>" loading="lazy" />
		<?php endif; ?>
	</a>

	<div class="shop-product__info">

		<div class="shop-product__meta">
			<?php if ( $boxara_category ) : ?>
				<span class="shop-product__category"><?php echo esc_html( $boxara_category ); ?></span>
			<?php endif; ?>
			<a class="shop-product__name" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
		</div>

		<div class="shop-product__footer">
			<span class="shop-product__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
			<div class="shop-product__cta">
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
		</div>

	</div>

</li>
