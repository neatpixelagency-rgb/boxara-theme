<?php
/**
 * The template for displaying product archives — the main shop page and
 * every product category (WooCommerce serves both from this one file).
 *
 * Keeps WooCommerce's real query/loop/pagination hooks (so search, category
 * filtering, and plugin compatibility all keep working) but replaces the
 * default header/ordering/pagination markup with the Figma design.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

get_header();

/**
 * Hook: woocommerce_before_main_content. Opens <main id="primary"> via
 * boxara_woocommerce_wrapper_before() in inc/woocommerce.php.
 */
do_action( 'woocommerce_before_main_content' );

$boxara_is_category = is_product_category();
$boxara_term         = $boxara_is_category ? get_queried_object() : null;
?>

<div class="shop-hero">
	<p class="shop-hero__eyebrow">Boxara kolekcije</p>
	<div class="shop-hero__row">
		<h1 class="shop-hero__title">
			<?php if ( $boxara_term ) : ?>
				UMETNOST <mark>&bdquo;<?php echo esc_html( $boxara_term->name ); ?>&ldquo;</mark>
			<?php else : ?>
				UMETNOST <mark>U DIMENZIJI</mark>
			<?php endif; ?>
		</h1>
		<p class="shop-hero__desc">
			<?php
			if ( $boxara_term && $boxara_term->description ) {
				echo wp_kses_post( wpautop( $boxara_term->description ) );
			} else {
				echo 'Spajanje fizičkog i digitalnog sveta kroz premium dimenzionalnu papirnu skulpturu. Remek-dela pažljivo izrađena da unaprede svaki moderan prostor.';
			}
			?>
		</p>
	</div>
</div>

<div class="shop-controls">

	<?php boxara_shop_category_tabs(); ?>

	<div class="shop-controls__right">
		<form class="shop-controls__search" role="search" method="get" action="<?php echo esc_url( $boxara_term ? get_term_link( $boxara_term ) : ( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ) ); ?>">
			<span class="shop-controls__search-icon"><?php boxara_icon( 'search' ); ?></span>
			<label class="screen-reader-text" for="shop-search-input">Pretraži kolekcije</label>
			<input type="search" id="shop-search-input" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Pretraži kolekcije&hellip;" />
			<input type="hidden" name="post_type" value="product" />
		</form>
		<!-- No filter criteria exist in the design yet (price range, size…) — visual only until there's something real to wire it to. -->
		<button type="button" class="shop-controls__filter" aria-disabled="true">Filter</button>
	</div>

</div>

<?php if ( woocommerce_product_loop() ) : ?>

	<?php
	/**
	 * Hook: woocommerce_before_shop_loop. Only notices survive here — result
	 * count and the default ordering dropdown are unhooked in
	 * inc/woocommerce.php since neither is in the design.
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) :
			the_post();
			do_action( 'woocommerce_shop_loop' );
			wc_get_template_part( 'content', 'product' );
		endwhile;
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked boxara_shop_load_more - 10 (replaces woocommerce_pagination)
	 */
	do_action( 'woocommerce_after_shop_loop' );
	?>

<?php else : ?>

	<?php do_action( 'woocommerce_no_products_found' ); ?>

<?php endif; ?>

<?php
/**
 * Hook: woocommerce_after_main_content. Closes </main> via
 * boxara_woocommerce_wrapper_after() in inc/woocommerce.php.
 */
do_action( 'woocommerce_after_main_content' );

get_footer();
