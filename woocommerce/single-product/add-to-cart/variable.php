<?php
/**
 * Variable product add-to-cart — swatches instead of the default <select>.
 *
 * Keeps the exact form/data attributes wc-add-to-cart-variation.js binds to
 * (.variations_form, data-product_variations) so price/availability/image
 * updates keep working; the real <select> for each attribute still renders,
 * just visually hidden, so screen readers and the core script both still
 * have a working control. Swatch buttons (product.js) just proxy clicks
 * onto it.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

global $product;

$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' );
?>
<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype="multipart/form-data" data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>

		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>

	<?php else : ?>

		<?php foreach ( $attributes as $attribute_name => $options ) : ?>
			<div class="shop-product-page__swatches" data-attribute_name="attribute_<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>">
				<p class="shop-product-page__swatches-label">Izaberi <?php echo esc_html( mb_strtolower( wc_attribute_label( $attribute_name ) ) ); ?></p>
				<div class="shop-product-page__swatches-row" role="radiogroup" aria-label="<?php echo esc_attr( wc_attribute_label( $attribute_name ) ); ?>">
					<?php foreach ( $options as $option ) : ?>
						<?php
						$term  = taxonomy_exists( $attribute_name ) ? get_term_by( 'slug', $option, $attribute_name ) : null;
						$label = $term ? $term->name : $option;
						?>
						<button
							type="button"
							class="shop-product-page__swatch"
							data-value="<?php echo esc_attr( $option ); ?>"
							style="background-color: <?php echo esc_attr( boxara_swatch_color_from_label( $label ) ); ?>;"
							aria-label="<?php echo esc_attr( $label ); ?>"
							title="<?php echo esc_attr( $label ); ?>"
							role="radio"
							aria-checked="false"
						></button>
					<?php endforeach; ?>
				</div>
				<p class="shop-product-page__swatches-selected" data-selected-label></p>
				<?php
				/*
				 * The "variations" class is load-bearing, not decorative:
				 * wc-add-to-cart-variation.js hardcodes
				 * $form.find('.variations select') to read the current
				 * selection, a leftover from the <table class="variations">
				 * this replaces. Without it the script finds zero attribute
				 * fields and the add-to-cart button never leaves its
				 * "wc-variation-selection-needed" state, regardless of what
				 * the select's actual value is.
				 */
				?>
				<div class="screen-reader-text variations">
					<label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wp_kses_post( wc_attribute_label( $attribute_name ) ); ?></label>
					<?php
					wc_dropdown_variation_attribute_options(
						array(
							'options'   => $options,
							'attribute' => $attribute_name,
							'product'   => $product,
						)
					);
					?>
				</div>
			</div>
		<?php endforeach; ?>

		<div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>

		<div class="single_variation_wrap">
			<?php
			/**
			 * Hook: woocommerce_before_single_variation.
			 */
			do_action( 'woocommerce_before_single_variation' );

			/**
			 * Hook: woocommerce_single_variation.
			 *
			 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
			 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
			 */
			do_action( 'woocommerce_single_variation' );

			/**
			 * Hook: woocommerce_after_single_variation.
			 */
			do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>
<?php
do_action( 'woocommerce_after_add_to_cart_form' );
