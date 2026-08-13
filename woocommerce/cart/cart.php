<?php
/**
 * Cart page.
 *
 * Overrides WooCommerce's hook-driven default with the Figma-language
 * layout: header, line-item list, coupon + update actions, and an order
 * summary sidebar. Real WooCommerce hooks/functions still power quantity
 * updates, coupon application, shipping and totals — only the wrapping
 * markup is custom, same approach as content-single-product.php.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' );

$boxara_cart_count = WC()->cart->get_cart_contents_count();
?>

<div class="shop-cart-page">

	<div class="shop-cart-page__header">
		<p class="shop-cart-page__eyebrow">Vaša korpa</p>
		<h1 class="shop-cart-page__title">PREGLED <mark>KORPE</mark></h1>
		<p class="shop-cart-page__count">
			<?php
			printf(
				/* translators: %d: number of items in the cart. */
				esc_html( _n( '%d proizvod u korpi', '%d proizvoda u korpi', $boxara_cart_count, 'boxara' ) ),
				(int) $boxara_cart_count
			);
			?>
		</p>
	</div>

	<div class="shop-cart-page__layout">

		<form class="woocommerce-cart-form shop-cart-page__items" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<div class="shop-cart-page__item-list">

				<?php do_action( 'woocommerce_before_cart_contents' ); ?>

				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
					$visible    = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key );

					if ( ! ( $_product instanceof WC_Product && $_product->exists() && $cart_item['quantity'] > 0 && $visible ) ) {
						continue;
					}

					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );

					if ( $_product->is_sold_individually() ) {
						$min_quantity = 1;
						$max_quantity = 1;
					} else {
						$min_quantity = 0;
						$max_quantity = $_product->get_max_purchase_quantity();
					}
					?>
					<div class="shop-cart-page__item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

						<div class="shop-cart-page__item-thumb">
							<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'thumbnail' ), $cart_item, $cart_item_key );
							if ( $product_permalink ) {
								printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), wp_kses_post( $thumbnail ) );
							} else {
								echo wp_kses_post( $thumbnail );
							}
							?>
						</div>

						<div class="shop-cart-page__item-body">

							<div class="shop-cart-page__item-name">
								<?php
								if ( $product_permalink ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
								} else {
									echo wp_kses_post( $product_name );
								}
								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
								?>
							</div>

							<?php $boxara_item_data = wc_get_formatted_cart_item_data( $cart_item ); ?>
							<?php if ( $boxara_item_data ) : ?>
								<div class="shop-cart-page__item-meta"><?php echo wp_kses_post( $boxara_item_data ); ?></div>
							<?php endif; ?>

							<?php if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) : ?>
								<p class="shop-cart-page__item-backorder"><?php esc_html_e( 'Available on backorder', 'woocommerce' ); ?></p>
							<?php endif; ?>

							<div class="shop-cart-page__item-price-row shop-cart-page__item-price-row--mobile">
								<span class="shop-cart-page__item-price shop-cart-page__item-price--mobile">
									<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</span>
								<span class="shop-cart-page__item-subtotal shop-cart-page__item-subtotal--mobile">
									<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</span>
							</div>

							<div class="shop-cart-page__item-controls">

								<div class="shop-cart-page__item-qty">
									<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_quantity',
										woocommerce_quantity_input(
											array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $max_quantity,
												'min_value'    => $min_quantity,
												'product_name' => $product_name,
											),
											$_product,
											false
										),
										$cart_item_key,
										$cart_item
									);
									?>
								</div>

								<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a role="button" href="%s" class="shop-cart-page__item-remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										/* translators: %s is the product name */
										esc_attr( sprintf( __( 'Ukloni "%s" iz korpe', 'boxara' ), wp_strip_all_tags( $product_name ) ) ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() ),
										wp_kses( boxara_get_icon( 'close' ), boxara_svg_allowed_html() )
									),
									$cart_item_key
								);
								?>

							</div>

						</div>

						<span class="shop-cart-page__item-price shop-cart-page__item-price--desktop">
							<?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>

						<span class="shop-cart-page__item-subtotal shop-cart-page__item-subtotal--desktop">
							<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						</span>

					</div>
					<?php
				}
				?>

				<?php do_action( 'woocommerce_cart_contents' ); ?>
				<?php do_action( 'woocommerce_after_cart_contents' ); ?>

			</div>

			<div class="shop-cart-page__actions">

				<?php if ( wc_coupons_enabled() ) : ?>
					<div class="shop-cart-page__coupon">
						<label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
						<input type="text" name="coupon_code" class="shop-cart-page__coupon-input" id="coupon_code" value="" placeholder="Unesite kod kupona" />
						<button type="submit" class="shop-cart-page__coupon-apply" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>">Primeni kod</button>
						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php endif; ?>

				<button type="submit" class="shop-cart-page__update" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>">Ažuriraj korpu</button>

				<?php do_action( 'woocommerce_cart_actions' ); ?>
				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

			</div>

			<?php do_action( 'woocommerce_after_cart_table' ); ?>

		</form>

		<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

		<div class="shop-cart-page__collaterals cart-collaterals">
			<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10 (styled via cart-totals.php override)
			 */
			do_action( 'woocommerce_cart_collaterals' );
			?>
		</div>

	</div>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
