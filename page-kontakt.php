<?php
/**
 * Template for the Kontakt (Contact) page.
 *
 * Matches page-o-nama.php's approach: the page is built in the block editor
 * from the Boxara kontakt-* patterns in /patterns/, so this template does
 * almost nothing — it prints the blocks full-width and skips the default
 * page title/entry-content wrapper so each pattern controls its own layout.
 *
 * @package Boxara
 */

get_header();
?>

	<main id="primary" class="site-main site-main--kontakt">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</main><!-- #primary -->

<?php
get_footer();
