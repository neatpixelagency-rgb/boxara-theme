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

	// Extra lag per band, as a fraction of viewport height, decaying to 0
	// as the reveal completes. In vh rather than a fixed px so the effect
	// reads the same relative strength at any viewport size. The topmost
	// (teal) band has none -- it moves at the master pace the whole time
	// -- and each band below it starts further back, so they have more
	// ground to close as they catch up: bottom bands read as visibly
	// quicker, the top band as the slow, steady anchor. Large deltas
	// (up to 35% of viewport height) so the speed difference actually
	// reads while scrolling, not just as a faint wobble.
	var lagVh = [ 0, 12, 23, 35 ];

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

		bands.forEach( function ( band, i ) {
			var lagPx  = ( ( lagVh[ i ] || 0 ) / 100 ) * window.innerHeight;
			var offset = ( 1 - progress ) * lagPx;
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
