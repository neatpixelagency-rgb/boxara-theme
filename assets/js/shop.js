/**
 * Shop / category archive "Load more" — fetches the next page over AJAX
 * and appends it to the grid. The button underneath is a real link to the
 * next page, so this is progressive enhancement: if the fetch fails, the
 * catch handler falls through to a normal navigation.
 *
 * @package Boxara
 */

( function () {
	'use strict';

	var pagination = document.querySelector( '[data-shop-pagination]' );

	if ( ! pagination || 'undefined' === typeof boxaraShop ) {
		return;
	}

	var grid = document.querySelector( 'ul.products' );
	var link = pagination.querySelector( '.shop-pagination__link' );

	if ( ! grid || ! link ) {
		return;
	}

	link.addEventListener( 'click', function ( event ) {
		if ( pagination.classList.contains( 'is-loading' ) ) {
			event.preventDefault();
			return;
		}

		event.preventDefault();

		var page       = parseInt( pagination.getAttribute( 'data-next-page' ), 10 );
		var category   = pagination.getAttribute( 'data-category' ) || '';
		var search     = pagination.getAttribute( 'data-search' ) || '';
		var originalText = link.textContent;

		pagination.classList.add( 'is-loading' );
		link.textContent = boxaraShop.strings.loading;

		var body = new FormData();
		body.append( 'action', 'boxara_load_more_products' );
		body.append( 'nonce', boxaraShop.nonce );
		body.append( 'page', page );
		body.append( 'category', category );
		body.append( 'search', search );

		fetch( boxaraShop.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' } )
			.then( function ( response ) {
				return response.json();
			} )
			.then( function ( data ) {
				pagination.classList.remove( 'is-loading' );

				if ( ! data || ! data.success ) {
					link.textContent = originalText;
					return;
				}

				var temp = document.createElement( 'div' );
				temp.innerHTML = data.data.html;
				var newItems = Array.prototype.slice.call( temp.children );
				while ( temp.firstChild ) {
					grid.appendChild( temp.firstChild );
				}

				if ( window.boxaraReveal ) {
					window.boxaraReveal.observe( newItems );
				}

				if ( data.data.has_more ) {
					pagination.setAttribute( 'data-next-page', String( page + 1 ) );
					link.textContent = originalText;
				} else {
					pagination.remove();
				}
			} )
			.catch( function () {
				window.location.href = link.href;
			} );
	} );
} )();
