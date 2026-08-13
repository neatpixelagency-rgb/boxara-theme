<?php
/**
 * Template for the Cart page.
 *
 * The page's content is just the [woocommerce_cart] shortcode, which
 * renders our woocommerce/cart/cart.php (or cart-empty.php) override — this
 * template only needs to print it inside the site chrome, same minimal
 * approach as page-o-nama.php.
 *
 * @package Boxara
 */

get_header();
?>

	<main id="primary" class="site-main site-main--cart">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</main><!-- #primary -->

<?php
get_footer();
