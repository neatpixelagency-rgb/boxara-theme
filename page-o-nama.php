<?php
/**
 * Template for the O nama (About) page.
 *
 * Matches front-page.php's approach: the page is built in the block editor
 * from the Boxara about-* patterns in /patterns/, so this template does
 * almost nothing — it prints the blocks full-width and skips the default
 * page title/entry-content wrapper so each pattern controls its own layout.
 *
 * @package Boxara
 */

get_header();
?>

	<main id="primary" class="site-main site-main--about">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</main><!-- #primary -->

<?php
get_footer();
