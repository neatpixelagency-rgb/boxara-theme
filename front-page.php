<?php
/**
 * The template for the site front page.
 *
 * Used when Settings → Reading is set to a static front page. The homepage is
 * built in the block editor from the Boxara patterns in /patterns/, so this
 * template deliberately does almost nothing: it prints the blocks full-width
 * and lets each pattern control its own layout and padding.
 *
 * If no static front page is set, WordPress falls back to index.php.
 *
 * @package Boxara
 */

get_header();
?>

	<main id="primary" class="site-main site-main--front">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</main><!-- #primary -->

<?php
get_footer();
