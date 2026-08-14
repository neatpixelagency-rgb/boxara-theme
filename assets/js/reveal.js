/**
 * Scroll/entrance text and section reveals.
 *
 * Three opt-in markup classes, applied wherever a pattern wants them:
 *   .js-reveal-lines   — splits on the element's own <br> tags, each line
 *                         rises up out of a mask (used for the hero H1).
 *   .js-reveal-words   — splits text nodes into per-word spans that rise
 *                         in with a stagger (used for H2/H3 headings).
 *   .js-reveal-section — plain fade + rise, no splitting, optionally
 *                         staggered via a --reveal-i custom property set
 *                         in markup (e.g. across a row of cards).
 *
 * Progressive enhancement: none of the above are hidden by default in CSS.
 * .js-reveal-lines/.js-reveal-words only get their masked/hidden state once
 * this script has actually wrapped their contents, so if JS never runs the
 * text is just plain, visible text. .js-reveal-section elements are hidden
 * by CSS from the start, so a reduced-motion or no-IntersectionObserver
 * environment gets an immediate reveal below rather than staying invisible.
 *
 * @package Boxara
 */
( function () {
	'use strict';

	function wrapLines( el ) {
		var rows = [];
		var current = document.createElement( 'span' );
		current.className = 'reveal-row__inner';

		Array.prototype.slice.call( el.childNodes ).forEach( function ( node ) {
			if ( node.nodeName === 'BR' ) {
				rows.push( current );
				current = document.createElement( 'span' );
				current.className = 'reveal-row__inner';
			} else {
				current.appendChild( node );
			}
		} );
		rows.push( current );

		el.innerHTML = '';
		rows.forEach( function ( inner, i ) {
			var row = document.createElement( 'span' );
			row.className = 'reveal-row';
			row.style.setProperty( '--reveal-i', i );
			row.appendChild( inner );
			el.appendChild( row );
		} );
	}

	function wrapWords( el ) {
		var walker = document.createTreeWalker( el, NodeFilter.SHOW_TEXT, null );
		var textNodes = [];
		var node;
		while ( ( node = walker.nextNode() ) ) {
			if ( node.nodeValue.trim() !== '' ) {
				textNodes.push( node );
			}
		}

		var wordIndex = 0;
		textNodes.forEach( function ( textNode ) {
			var parts = textNode.nodeValue.split( /(\s+)/ );
			var frag = document.createDocumentFragment();

			parts.forEach( function ( part ) {
				if ( part.trim() === '' ) {
					frag.appendChild( document.createTextNode( part ) );
					return;
				}

				var outer = document.createElement( 'span' );
				outer.className = 'reveal-word';
				outer.style.setProperty( '--reveal-i', wordIndex++ );

				var inner = document.createElement( 'span' );
				inner.className = 'reveal-word__inner';
				inner.textContent = part;

				outer.appendChild( inner );
				frag.appendChild( outer );
			} );

			textNode.parentNode.replaceChild( frag, textNode );
		} );
	}

	function reveal( el ) {
		el.classList.add( 'is-revealed' );
	}

	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var hasObserver  = 'IntersectionObserver' in window;
	var io           = null;

	if ( ! reduceMotion && hasObserver ) {
		io = new IntersectionObserver(
			function ( entries, observer ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						reveal( entry.target );
						observer.unobserve( entry.target );
					}
				} );
			},
			{ threshold: 0.2, rootMargin: '0px 0px -10% 0px' }
		);
	}

	/**
	 * Wrap/observe a fresh batch of elements — the initial page scan calls
	 * this with the whole document, and anything that injects markup later
	 * (e.g. the shop's AJAX "load more") can call window.boxaraReveal.observe()
	 * with just the new nodes so they animate in too.
	 */
	function observe( root ) {
		var scope   = root || document;
		var lineEls = scope.matches && scope.matches( '.js-reveal-lines' ) ? [ scope ] : scope.querySelectorAll( '.js-reveal-lines' );
		var wordEls = scope.matches && scope.matches( '.js-reveal-words' ) ? [ scope ] : scope.querySelectorAll( '.js-reveal-words' );
		var sectionEls = scope.matches && scope.matches( '.js-reveal-section' ) ? [ scope ] : scope.querySelectorAll( '.js-reveal-section' );

		if ( ! io ) {
			Array.prototype.forEach.call( lineEls, reveal );
			Array.prototype.forEach.call( wordEls, reveal );
			Array.prototype.forEach.call( sectionEls, reveal );
			return;
		}

		Array.prototype.forEach.call( lineEls, function ( el ) {
			wrapLines( el );
			io.observe( el );
		} );
		Array.prototype.forEach.call( wordEls, function ( el ) {
			wrapWords( el );
			io.observe( el );
		} );
		Array.prototype.forEach.call( sectionEls, function ( el ) {
			io.observe( el );
		} );
	}

	/**
	 * Observe a plain list/array of elements directly (each already known
	 * to be one of the three reveal types), skipping the querySelectorAll
	 * scan — used for AJAX-appended nodes where the caller already has
	 * exact references.
	 */
	function observeElements( els ) {
		Array.prototype.forEach.call( els, function ( el ) {
			if ( el.classList.contains( 'js-reveal-lines' ) ) {
				if ( io ) { wrapLines( el ); }
			} else if ( el.classList.contains( 'js-reveal-words' ) ) {
				if ( io ) { wrapWords( el ); }
			}
			if ( io ) {
				io.observe( el );
			} else {
				reveal( el );
			}
		} );
	}

	window.boxaraReveal = { observe: observeElements };

	function init() {
		observe( document );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
