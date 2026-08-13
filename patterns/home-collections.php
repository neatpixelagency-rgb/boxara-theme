<?php
/**
 * Title: Home — Collections
 * Slug: boxara/home-collections
 * Categories: boxara-home
 * Description: Top product categories as browsable cards, image, name and starting price.
 * Keywords: kolekcije, collections, categories, home
 * Viewport Width: 1440
 *
 * @package Boxara
 */

/*
 * The Figma design repeats one stand-in photo across four identical cards
 * ({kategorija} placeholder text). Real WooCommerce categories exist and
 * carry real product photos, so this pulls the top ones by product count
 * instead — it reads correctly today and stays correct as the catalogue
 * changes. "Bestsellers" is excluded: it is a merchandising tag, not a
 * subject category, and would not make sense next to "Dogs" or "Figurines".
 */
$boxara_collections_exclude    = array();
$boxara_collections_bestseller = get_term_by( 'slug', 'bestsellers', 'product_cat' );
if ( $boxara_collections_bestseller ) {
	$boxara_collections_exclude[] = $boxara_collections_bestseller->term_id;
}

$boxara_collections_terms = get_terms(
	array(
		'taxonomy'   => 'product_cat',
		'orderby'    => 'count',
		'order'      => 'DESC',
		'hide_empty' => true,
		'exclude'    => $boxara_collections_exclude,
		'number'     => 4,
	)
);

$boxara_collections_cards = array();
if ( ! is_wp_error( $boxara_collections_terms ) ) {
	foreach ( $boxara_collections_terms as $boxara_term ) {
		// Category thumbnail if the client has set one, otherwise the most
		// popular product in the category stands in for it.
		$boxara_thumb_id  = get_term_meta( $boxara_term->term_id, 'thumbnail_id', true );
		$boxara_image_url = $boxara_thumb_id ? wp_get_attachment_image_url( $boxara_thumb_id, 'medium_large' ) : '';

		if ( ! $boxara_image_url && function_exists( 'wc_get_products' ) ) {
			$boxara_sample = wc_get_products(
				array(
					'category' => array( $boxara_term->slug ),
					'limit'    => 1,
					'orderby'  => 'popularity',
				)
			);
			if ( $boxara_sample ) {
				$boxara_image_url = get_the_post_thumbnail_url( $boxara_sample[0]->get_id(), 'medium_large' );
			}
		}

		$boxara_min_price = null;
		if ( function_exists( 'wc_get_products' ) ) {
			$boxara_cheapest = wc_get_products(
				array(
					'category' => array( $boxara_term->slug ),
					'limit'    => 1,
					'orderby'  => 'price',
					'order'    => 'ASC',
				)
			);
			if ( $boxara_cheapest ) {
				$boxara_min_price = (float) $boxara_cheapest[0]->get_price();
			}
		}

		$boxara_collections_cards[] = array(
			'name'  => $boxara_term->name,
			'url'   => get_term_link( $boxara_term ),
			'image' => $boxara_image_url,
			'price' => $boxara_min_price,
		);
	}
}

$boxara_shop_url = function_exists( 'wc_get_page_permalink' )
	? wc_get_page_permalink( 'shop' )
	: home_url( '/' );
?>
<!-- wp:group {"className":"home-collections","layout":{"type":"constrained"}} -->
<div class="wp-block-group home-collections">

	<!-- wp:group {"className":"home-collections__header","layout":{"type":"flex","justifyContent":"space-between"}} -->
	<div class="wp-block-group home-collections__header">

		<!-- wp:heading {"level":2,"className":"home-collections__title","fontFamily":"display"} -->
		<h2 class="wp-block-heading home-collections__title has-display-font-family">Kolekcije</h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"className":"home-collections__link"} -->
		<p class="home-collections__link"><a href="<?php echo esc_url( $boxara_shop_url ); ?>">Pogledaj sve</a></p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

	<?php if ( $boxara_collections_cards ) : ?>
	<div class="home-collections__grid">
		<?php foreach ( $boxara_collections_cards as $boxara_card ) : ?>
		<a class="home-collections__card" href="<?php echo esc_url( $boxara_card['url'] ); ?>">
			<span class="home-collections__image">
				<?php if ( $boxara_card['image'] ) : ?>
					<img src="<?php echo esc_url( $boxara_card['image'] ); ?>" alt="" loading="lazy" />
				<?php endif; ?>
			</span>
			<span class="home-collections__details">
				<span class="home-collections__meta">
					<span class="home-collections__name"><?php echo esc_html( $boxara_card['name'] ); ?></span>
					<?php if ( null !== $boxara_card['price'] ) : ?>
						<span class="home-collections__price">Od <?php echo wp_kses_post( wc_price( $boxara_card['price'] ) ); ?></span>
					<?php endif; ?>
				</span>
				<span class="home-collections__go" aria-hidden="true"><?php boxara_icon( 'arrow-right' ); ?></span>
			</span>
		</a>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>

</div>
<!-- /wp:group -->
