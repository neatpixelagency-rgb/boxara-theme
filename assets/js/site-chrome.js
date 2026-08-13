/**
 * Mobile drawer.
 *
 * Replaces the Underscores navigation script. Handles open/close, Escape,
 * backdrop clicks, body scroll lock, and keeps focus inside the panel while
 * it is open.
 *
 * @package Boxara
 */

( function () {
	'use strict';

	var toggle = document.getElementById( 'menu-toggle' );
	var drawer = document.getElementById( 'mobile-drawer' );

	if ( ! toggle || ! drawer ) {
		return;
	}

	var panel = drawer.querySelector( '.mobile-drawer__panel' );
	var FOCUSABLE = 'a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])';
	var lastFocused = null;

	function focusable() {
		return Array.prototype.slice.call( panel.querySelectorAll( FOCUSABLE ) ).filter( function ( el ) {
			return el.offsetParent !== null;
		} );
	}

	function open() {
		lastFocused = document.activeElement;

		drawer.hidden = false;
		// Force a reflow so the transition runs from the hidden state.
		void drawer.offsetWidth;

		drawer.classList.add( 'is-open' );
		toggle.setAttribute( 'aria-expanded', 'true' );
		document.body.classList.add( 'drawer-open' );

		var first = focusable()[ 0 ];
		if ( first ) {
			first.focus();
		}

		document.addEventListener( 'keydown', onKeydown );
	}

	function close() {
		drawer.classList.remove( 'is-open' );
		toggle.setAttribute( 'aria-expanded', 'false' );
		document.body.classList.remove( 'drawer-open' );

		document.removeEventListener( 'keydown', onKeydown );

		var done = function () {
			drawer.hidden = true;
			panel.removeEventListener( 'transitionend', done );
		};

		if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
			done();
		} else {
			panel.addEventListener( 'transitionend', done );
		}

		if ( lastFocused ) {
			lastFocused.focus();
		}
	}

	function isOpen() {
		return toggle.getAttribute( 'aria-expanded' ) === 'true';
	}

	function onKeydown( event ) {
		if ( event.key === 'Escape' ) {
			close();
			return;
		}

		if ( event.key !== 'Tab' ) {
			return;
		}

		var items = focusable();
		if ( ! items.length ) {
			return;
		}

		var first = items[ 0 ];
		var last = items[ items.length - 1 ];

		if ( event.shiftKey && document.activeElement === first ) {
			event.preventDefault();
			last.focus();
		} else if ( ! event.shiftKey && document.activeElement === last ) {
			event.preventDefault();
			first.focus();
		}
	}

	toggle.addEventListener( 'click', function () {
		if ( isOpen() ) {
			close();
		} else {
			open();
		}
	} );

	drawer.addEventListener( 'click', function ( event ) {
		if ( event.target.hasAttribute( 'data-drawer-close' ) ) {
			close();
		}
	} );

	// Close if the viewport grows past the desktop breakpoint while open.
	window.matchMedia( '(min-width: 900px)' ).addEventListener( 'change', function ( event ) {
		if ( event.matches && isOpen() ) {
			close();
		}
	} );
}() );
