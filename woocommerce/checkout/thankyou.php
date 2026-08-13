<?php
/**
 * Thank-you (order-received) page.
 *
 * Same page as checkout — WooCommerce swaps to this template automatically
 * once ?order-received={id} is present. Real order data throughout; only
 * the wrapping markup is custom.
 *
 * @package Boxara
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="shop-thankyou-page woocommerce-order">

	<?php if ( $order ) : ?>

		<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<div class="shop-thankyou-page__intro shop-thankyou-page__intro--failed">
				<span class="shop-thankyou-page__icon" aria-hidden="true"><?php boxara_icon( 'close' ); ?></span>
				<p class="shop-thankyou-page__eyebrow">Porudžbina nije uspela</p>
				<h1 class="shop-thankyou-page__title">PLAĆANJE NIJE <mark>USPELO</mark></h1>
				<p class="shop-thankyou-page__desc"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>
				<div class="shop-thankyou-page__actions">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="shop-thankyou-page__cta">Pokušaj ponovo</a>
					<?php if ( is_user_logged_in() ) : ?>
						<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="shop-thankyou-page__cta shop-thankyou-page__cta--ghost">Moj nalog</a>
					<?php endif; ?>
				</div>
			</div>

		<?php else : ?>

			<?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

			<div class="shop-thankyou-page__details">

				<ul class="shop-thankyou-page__overview woocommerce-order-overview woocommerce-thankyou-order-details order_details">

					<li class="shop-thankyou-page__overview-item woocommerce-order-overview__order order">
						<span class="shop-thankyou-page__overview-label">Broj porudžbine</span>
						<strong class="shop-thankyou-page__overview-value"><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>

					<li class="shop-thankyou-page__overview-item woocommerce-order-overview__date date">
						<span class="shop-thankyou-page__overview-label">Datum</span>
						<strong class="shop-thankyou-page__overview-value"><?php echo esc_html( boxara_format_order_date( $order->get_date_created() ) ); ?></strong>
					</li>

					<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
						<li class="shop-thankyou-page__overview-item woocommerce-order-overview__email email">
							<span class="shop-thankyou-page__overview-label">Email</span>
							<strong class="shop-thankyou-page__overview-value"><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
						</li>
					<?php endif; ?>

					<li class="shop-thankyou-page__overview-item woocommerce-order-overview__total total">
						<span class="shop-thankyou-page__overview-label">Ukupno</span>
						<strong class="shop-thankyou-page__overview-value"><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>

					<?php if ( $order->get_payment_method_title() ) : ?>
						<li class="shop-thankyou-page__overview-item woocommerce-order-overview__payment-method method">
							<span class="shop-thankyou-page__overview-label">Način plaćanja</span>
							<strong class="shop-thankyou-page__overview-value"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
						</li>
					<?php endif; ?>

				</ul>

				<div class="shop-thankyou-page__items">
					<?php foreach ( $order->get_items() as $item_id => $item ) : ?>
						<?php
						$boxara_product = $item->get_product();
						if ( ! $boxara_product ) {
							continue;
						}
						?>
						<div class="shop-thankyou-page__item">
							<div class="shop-thankyou-page__item-thumb">
								<?php echo wp_kses_post( $boxara_product->get_image( 'thumbnail' ) ); ?>
								<span class="shop-thankyou-page__item-qty"><?php echo (int) $item->get_quantity(); ?></span>
							</div>
							<span class="shop-thankyou-page__item-name"><?php echo esc_html( $item->get_name() ); ?></span>
							<span class="shop-thankyou-page__item-total"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>

				<?php $boxara_billing_address = $order->get_formatted_billing_address(); ?>
				<?php if ( $boxara_billing_address ) : ?>
					<div class="shop-thankyou-page__address">
						<p class="shop-thankyou-page__address-label">Adresa za naplatu</p>
						<address class="shop-thankyou-page__address-value"><?php echo wp_kses_post( $boxara_billing_address ); ?></address>
						<?php if ( $order->get_billing_phone() ) : ?>
							<p class="shop-thankyou-page__address-phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="shop-thankyou-page__actions">
					<a href="<?php echo esc_url( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>" class="shop-thankyou-page__cta">Nastavi kupovinu</a>
				</div>

			</div>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
