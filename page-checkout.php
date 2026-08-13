<?php
/**
 * Template for the Checkout page.
 *
 * The page's content is just the [woocommerce_checkout] shortcode, which
 * renders our woocommerce/checkout/form-checkout.php override — this
 * template only needs to print it inside the site chrome, same minimal
 * approach as page-cart.php.
 *
 * @package Boxara
 */

get_header();
?>

	<main id="primary" class="site-main site-main--checkout">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</main><!-- #primary -->

<?php
get_footer();
