/**
 * Single product — frame-colour swatches.
 *
 * Each swatch button is a proxy for a real (visually hidden) <select> that
 * wc-add-to-cart-variation.js already knows how to read. Clicking a swatch
 * just sets that select's value and fires a native change event so
 * WooCommerce's own script recalculates price/image/availability — no
 * variation-matching logic is duplicated here.
 *
 * @package Boxara
 */

( function () {
	'use strict';

	/*
	 * WooCommerce's own variation-matching script (add-to-cart-variation.js)
	 * binds to .variations_form inside a jQuery `$(function(){...})` ready
	 * callback. This script runs as a plain, unwrapped footer script, which
	 * executes synchronously during page parsing — before that ready
	 * callback has fired. Dispatching a synthetic `change` event before
	 * WooCommerce has attached its listener is a no-op: the event fires
	 * into a form nothing is listening to yet, and the add-to-cart button
	 * is left stuck in its initial disabled state. Waiting for `load`
	 * guarantees jQuery's ready queue — registered earlier, since that
	 * script loads as this one's dependency — has already run.
	 */
	function init() {
		document.querySelectorAll( '.shop-product-page__swatches' ).forEach( wireSwatchGroup );
	}

	function wireSwatchGroup( group ) {
		var select  = group.querySelector( 'select' );
		var buttons = Array.prototype.slice.call( group.querySelectorAll( '.shop-product-page__swatch' ) );
		var label   = group.querySelector( '[data-selected-label]' );

		if ( ! select || ! buttons.length ) {
			return;
		}

		function syncFromSelect() {
			var value = select.value;

			buttons.forEach( function ( button ) {
				var isActive = value && button.getAttribute( 'data-value' ) === value;
				button.classList.toggle( 'is-active', Boolean( isActive ) );
				button.setAttribute( 'aria-checked', isActive ? 'true' : 'false' );
			} );

			if ( label ) {
				var active = buttons.filter( function ( button ) {
					return button.classList.contains( 'is-active' );
				} )[ 0 ];
				label.textContent = active ? active.getAttribute( 'title' ) : '';
			}
		}

		buttons.forEach( function ( button ) {
			button.addEventListener( 'click', function () {
				select.value = button.getAttribute( 'data-value' );
				select.dispatchEvent( new Event( 'change', { bubbles: true } ) );
			} );
		} );

		// WooCommerce's own script can change the select's value too — the
		// "Clear" link, or restoring a value from the URL — so mirror it
		// back onto the swatches whenever that happens, not just on click.
		select.addEventListener( 'change', syncFromSelect );

		syncFromSelect();

		// A product can have a default attribute value pre-selected on the
		// <select> (wc_dropdown_variation_attribute_options() reading
		// get_variation_default_attribute()) — the swatch already shows it
		// as active via syncFromSelect() above, but WooCommerce's own
		// variation-matching script only runs on a real change event, which
		// a pre-selected <option> never fires by itself. Without this, the
		// add-to-cart button stays in its initial disabled state even
		// though a colour already looks chosen.
		if ( select.value ) {
			select.dispatchEvent( new Event( 'change', { bubbles: true } ) );
		}
	}

	if ( 'complete' === document.readyState ) {
		init();
	} else {
		window.addEventListener( 'load', init );
	}
} )();
