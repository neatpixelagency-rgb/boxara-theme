/**
 * Homepage newsletter form — submits over AJAX instead of a page reload.
 *
 * @package Boxara
 */

( function () {
	'use strict';

	var form = document.querySelector( '.home-newsletter__form' );

	if ( ! form || 'undefined' === typeof boxaraNewsletter ) {
		return;
	}

	var input  = form.querySelector( 'input[type="email"]' );
	var button = form.querySelector( 'button' );
	var status = form.querySelector( '.home-newsletter__status' );

	function setStatus( message, isError ) {
		status.textContent = message;
		status.classList.toggle( 'is-error', Boolean( isError ) );
		status.hidden = ! message;
	}

	form.addEventListener( 'submit', function ( event ) {
		event.preventDefault();

		var email = input.value.trim();

		if ( ! email || -1 === email.indexOf( '@' ) ) {
			setStatus( boxaraNewsletter.strings.invalidEmail, true );
			input.focus();
			return;
		}

		button.disabled = true;
		setStatus( '', false );

		var body = new FormData();
		body.append( 'action', 'boxara_newsletter_subscribe' );
		body.append( 'nonce', boxaraNewsletter.nonce );
		body.append( 'email', email );

		fetch( boxaraNewsletter.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' } )
			.then( function ( response ) {
				return response.json();
			} )
			.then( function ( data ) {
				button.disabled = false;

				if ( data && data.success ) {
					form.reset();
					setStatus( data.data && data.data.message ? data.data.message : boxaraNewsletter.strings.success, false );
				} else {
					setStatus( data && data.data && data.data.message ? data.data.message : boxaraNewsletter.strings.genericError, true );
				}
			} )
			.catch( function () {
				button.disabled = false;
				setStatus( boxaraNewsletter.strings.genericError, true );
			} );
	} );
} )();
