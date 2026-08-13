<?php
/**
 * Outer wrapper for the single product page.
 *
 * Same shape as WooCommerce's own default, minus woocommerce_sidebar() —
 * the design has no sidebar, and leaving that hook in place was rendering
 * the default WordPress widget sidebar (search/recent posts/archives)
 * between the product content and the footer.
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

while ( have_posts() ) :
	the_post();
	wc_get_template_part( 'content', 'single-product' );
endwhile;

/**
 * Hook: woocommerce_after_main_content. Closes </main> via
 * boxara_woocommerce_wrapper_after() in inc/woocommerce.php.
 */
do_action( 'woocommerce_after_main_content' );

get_footer();
