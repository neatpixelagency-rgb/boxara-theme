<?php
/**
 * Inline SVG icon helper.
 *
 * Icons live as individual .svg files in /assets/icons/ and are exported
 * directly from the Figma file. They are inlined rather than served as
 * <img> so they can inherit colour via `fill="currentColor"`.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

/**
 * Return an inline SVG icon.
 *
 * Returns an empty string if the file is missing, so a missing export
 * never fatals the page — it just renders nothing.
 *
 * @param string $name  Filename without extension, e.g. 'cart'.
 * @param array  $args  Optional. 'class', 'size', 'label'.
 * @return string Escaped-safe SVG markup, or ''.
 */
function boxara_get_icon( $name, $args = array() ) {
	$name = preg_replace( '/[^a-z0-9\-]/', '', strtolower( $name ) );
	if ( '' === $name ) {
		return '';
	}

	$path = get_theme_file_path( "/assets/icons/{$name}.svg" );
	if ( ! file_exists( $path ) ) {
		return '';
	}

	static $cache = array();
	if ( ! isset( $cache[ $name ] ) ) {
		$cache[ $name ] = trim( (string) file_get_contents( $path ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	}

	$svg = $cache[ $name ];
	if ( '' === $svg ) {
		return '';
	}

	// Strip any XML prolog or comments Figma may have added.
	$svg = preg_replace( '/<\?xml.*?\?>|<!--.*?-->/s', '', $svg );

	$defaults = array(
		'class' => '',
		'size'  => '',
		'label' => '',
	);
	$args = wp_parse_args( $args, $defaults );

	$attrs = 'aria-hidden="true" focusable="false"';
	if ( $args['label'] ) {
		$attrs = sprintf( 'role="img" aria-label="%s" focusable="false"', esc_attr( $args['label'] ) );
	}

	$classes = 'boxara-icon boxara-icon--' . $name;
	if ( $args['class'] ) {
		$classes .= ' ' . $args['class'];
	}
	$attrs .= sprintf( ' class="%s"', esc_attr( $classes ) );

	if ( $args['size'] ) {
		$attrs .= sprintf( ' width="%1$d" height="%1$d"', absint( $args['size'] ) );
	}

	/*
	 * Inject attributes into the opening <svg> tag only, replacing any
	 * existing width/height/class so ours win. This must not touch the
	 * rest of the markup: Figma exports a <rect> with its own width/height
	 * inside <clipPath> to define the clip region, and stripping those
	 * (as an earlier, ungrounded version of this regex did) collapses the
	 * clip to 0x0 and silently blanks the whole icon.
	 */
	$svg = preg_replace_callback(
		'/<svg\b[^>]*>/i',
		function ( $matches ) use ( $attrs ) {
			$tag = preg_replace( '/\s(width|height|class)="[^"]*"/i', '', $matches[0] );
			return preg_replace( '/<svg\b/i', '<svg ' . $attrs, $tag, 1 );
		},
		$svg,
		1
	);

	return $svg;
}

/**
 * Echo an inline SVG icon.
 *
 * @param string $name Icon name.
 * @param array  $args Optional args, see boxara_get_icon().
 */
function boxara_icon( $name, $args = array() ) {
	/*
	 * wp_kses() lowercases every attribute name, but SVG's viewBox is
	 * case-sensitive — browsers ignore a lowercased "viewbox" entirely,
	 * which silently breaks the icon's coordinate system (it renders only
	 * the top-left corner of the glyph). Restore the case after sanitizing.
	 */
	$svg = wp_kses( boxara_get_icon( $name, $args ), boxara_svg_allowed_html() );
	$svg = preg_replace( '/\bviewbox=/i', 'viewBox=', $svg );
	echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already sanitized via wp_kses() above.
}

/**
 * Allowed SVG tags/attributes for wp_kses().
 *
 * @return array
 */
function boxara_svg_allowed_html() {
	$attrs = array(
		'xmlns'             => true,
		'viewbox'           => true,
		'width'             => true,
		'height'            => true,
		'fill'              => true,
		'stroke'            => true,
		'stroke-width'      => true,
		'stroke-linecap'    => true,
		'stroke-linejoin'   => true,
		'stroke-miterlimit' => true,
		'stroke-dasharray'  => true,
		'opacity'           => true,
		'transform'         => true,
		'class'             => true,
		'id'                => true,
		'role'              => true,
		'aria-hidden'       => true,
		'aria-label'        => true,
		'focusable'         => true,
		'fill-rule'         => true,
		'clip-rule'         => true,
		'clip-path'         => true,
	);

	return array(
		'svg'      => $attrs,
		'g'        => $attrs,
		'path'     => array_merge( $attrs, array( 'd' => true ) ),
		'circle'   => array_merge( $attrs, array( 'cx' => true, 'cy' => true, 'r' => true ) ),
		'ellipse'  => array_merge( $attrs, array( 'cx' => true, 'cy' => true, 'rx' => true, 'ry' => true ) ),
		'rect'     => array_merge( $attrs, array( 'x' => true, 'y' => true, 'rx' => true, 'ry' => true ) ),
		'line'     => array_merge( $attrs, array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true ) ),
		'polyline' => array_merge( $attrs, array( 'points' => true ) ),
		'polygon'  => array_merge( $attrs, array( 'points' => true ) ),
		'defs'     => $attrs,
		'clippath' => $attrs,
		'title'    => array(),
	);
}
