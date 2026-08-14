/**
 * Home hero — pinned scroll reveal parallax.
 *
 * The pin/settle mechanic itself is pure CSS (a sticky hero plus an
 * absolutely-positioned layers block that rises 1:1 with scroll inside a
 * taller wrapper — see .home-hero-pin in home.css). This script pulls each
 * band up toward band 1's position by most of its own baseline gap, so at
 * the top of the page the four bands sit almost, but not quite, on top of
 * each other -- then eases that pull off to exactly 0 as the reveal
 * completes, letting them peel apart into their designed staggered
 * positions (18vh/36vh/54vh apart, matching home.css) by the time they
 * settle.
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

	// Each band's own top offset in home.css (band--1/2/3/4), in vh --
	// the gap being closed at the top of the page is measured against
	// these, so it has to match the CSS or the settle position drifts.
	var baselineVh = [ 0, 18, 36, 54 ];

	// How much of that baseline gap to close at the very top of the page --
	// 0.97 means the bands sit almost, but not quite, on top of each other
	// before any scrolling happens (leaving them just barely distinguishable
	// rather than a single flat color), then peel apart into their full
	// staggered spacing as the user scrolls.
	var pullFactor = 0.97;

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

		// A band's pull-in has usually eased off a lot before it even
		// scrolls into view (it starts well below the viewport), so a
		// linear ease wastes most of the effect off-screen. Math.pow with
		// an exponent under 1 keeps more of it in reserve through the
		// early/middle of the scroll, so the bands are still visibly
		// peeling apart while on screen, not just snapping into their
		// final spacing right at the end.
		var remaining = Math.pow( 1 - progress, 0.6 );

		bands.forEach( function ( band, i ) {
			var pullVh = ( baselineVh[ i ] || 0 ) * pullFactor;
			var pullPx = ( pullVh / 100 ) * window.innerHeight;
			var offset = -remaining * pullPx;
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
