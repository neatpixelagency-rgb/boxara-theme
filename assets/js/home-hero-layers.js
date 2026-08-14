/**
 * Home hero — pinned scroll reveal parallax.
 *
 * The pin/settle mechanic itself is pure CSS (a sticky hero plus an
 * absolutely-positioned layers block that rises 1:1 with scroll inside a
 * taller wrapper — see .home-hero-pin in home.css). This script only adds
 * a small extra per-band offset on top of that free motion, decaying to
 * zero exactly as the layers settle into their designed position, so the
 * four bands arrive with a slight stagger instead of moving as one rigid
 * block.
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

	// Extra lag per band in px, decaying to 0 as the reveal completes --
	// keeps the topmost (teal) band a touch livelier than the bottom
	// (dark) band, which anchors the group and moves with the master pace.
	var lag = [ 60, 30, 15, 0 ];

	var ticking = false;

	function update() {
		ticking = false;

		var pinTop = wrap.offsetTop;

		// The settle point is reached partway through the pin, not at the
		// end of it -- the wrap is taller than that so the layers' tail has
		// room to clear before Collections appears (see home.css). Read the
		// same --home-hero-settle-vh value CSS uses rather than duplicating
		// the number here.
		var settleVh   = parseFloat( getComputedStyle( wrap ).getPropertyValue( '--home-hero-settle-vh' ) ) || 60;
		var scrollRoom = ( settleVh / 100 ) * window.innerHeight;

		if ( scrollRoom <= 0 ) {
			return;
		}

		var progress = ( window.scrollY - pinTop ) / scrollRoom;
		progress = Math.max( 0, Math.min( 1, progress ) );

		bands.forEach( function ( band, i ) {
			var offset = ( 1 - progress ) * ( lag[ i ] || 0 );
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
