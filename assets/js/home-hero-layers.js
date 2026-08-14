/**
 * Home hero — pinned scroll reveal parallax.
 *
 * The pin/settle mechanic itself is pure CSS (a sticky hero plus an
 * absolutely-positioned layers block that rises 1:1 with scroll inside a
 * taller wrapper — see .home-hero-pin in home.css). This script adds an
 * extra downward push to each band (bigger for lower bands), so at the top
 * of the page they sit much further apart than their designed spacing --
 * then eases that push off to exactly 0 as the reveal completes, so they
 * converge into their designed staggered positions (18vh/36vh/54vh apart,
 * matching home.css) by the time they settle. Settling at the exact
 * baseline spacing (rather than closing further, e.g. bunching together)
 * is deliberate: it's what keeps the settled bands spanning the full hero
 * edge to edge and landing flush against Collections.
 *
 * @package Boxara
 */
( function () {
	'use strict';

	if ( window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	var wrap  = document.querySelector( '.home-hero-pin' );
	var bands = wrap ? wrap.querySelectorAll( '.home-hero-layers__band' ) : [];

	if ( ! wrap || ! bands.length ) {
		return;
	}

	// Extra push per band at the top of the page, as a fraction of viewport
	// height, on top of its own baseline spacing in home.css -- decays to 0
	// as the reveal completes. In vh rather than a fixed px so the effect
	// reads the same relative strength at any viewport size.
	var lagVh = [ 0, 45, 100, 170 ];

	var ticking = false;

	function update() {
		ticking = false;

		var pinTop = wrap.offsetTop;

		// Read the same --home-hero-settle-vh value CSS uses for the pin
		// room, rather than duplicating the number here.
		var settleVh   = parseFloat( getComputedStyle( wrap ).getPropertyValue( '--home-hero-settle-vh' ) ) || 60;
		var scrollRoom = ( settleVh / 100 ) * window.innerHeight;

		if ( scrollRoom <= 0 ) {
			return;
		}

		var progress = ( window.scrollY - pinTop ) / scrollRoom;
		progress = Math.max( 0, Math.min( 1, progress ) );

		// A band's extra push has usually eased off a lot before it even
		// scrolls into view (it starts well below the viewport), so a
		// linear decay wastes most of the effect off-screen. Math.pow with
		// an exponent under 1 keeps more of it in reserve through the
		// early/middle of the scroll, so the bands are still visibly
		// converging while on screen, not just snapping into their final
		// spacing right at the end.
		var remaining = Math.pow( 1 - progress, 0.6 );

		bands.forEach( function ( band, i ) {
			var lagPx  = ( ( lagVh[ i ] || 0 ) / 100 ) * window.innerHeight;
			var offset = remaining * lagPx;
			band.style.transform = offset ? 'translateY(' + offset.toFixed( 1 ) + 'px)' : '';
		} );
	}

	function onScroll() {
		if ( ! ticking ) {
			ticking = true;
			requestAnimationFrame( update );
		}
	}

	window.addEventListener( 'scroll', onScroll, { passive: true } );
	window.addEventListener( 'resize', onScroll );
	update();
} )();
