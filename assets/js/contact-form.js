/**
 * Kontakt page contact form — submits over AJAX instead of a page reload.
 *
 * @package Boxara
 */

( function () {
	'use strict';

	var form = document.querySelector( '.kontakt-form__form' );

	if ( ! form || 'undefined' === typeof boxaraContactForm ) {
		return;
	}

	var nameField    = form.querySelector( '[name="name"]' );
	var emailField   = form.querySelector( '[name="email"]' );
	var subjectField = form.querySelector( '[name="subject"]' );
	var messageField = form.querySelector( '[name="message"]' );
	var button       = form.querySelector( 'button[type="submit"]' );
	var status       = form.querySelector( '.kontakt-form__status' );

	function setStatus( message, isError ) {
		status.textContent = message;
		status.classList.toggle( 'is-error', Boolean( isError ) );
		status.hidden = ! message;
	}

	form.addEventListener( 'submit', function ( event ) {
		event.preventDefault();

		var name    = nameField.value.trim();
		var email   = emailField.value.trim();
		var message = messageField.value.trim();

		if ( ! name || ! email || ! message ) {
			setStatus( boxaraContactForm.strings.missingFields, true );
			return;
		}

		if ( -1 === email.indexOf( '@' ) ) {
			setStatus( boxaraContactForm.strings.invalidEmail, true );
			emailField.focus();
			return;
		}

		button.disabled = true;
		setStatus( '', false );

		var body = new FormData();
		body.append( 'action', 'boxara_contact_form_submit' );
		body.append( 'nonce', boxaraContactForm.nonce );
		body.append( 'name', name );
		body.append( 'email', email );
		body.append( 'subject', subjectField.value.trim() );
		body.append( 'message', message );
		body.append( 'website', form.querySelector( '[name="website"]' ).value );

		fetch( boxaraContactForm.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' } )
			.then( function ( response ) {
				return response.json();
			} )
			.then( function ( data ) {
				button.disabled = false;

				if ( data && data.success ) {
					form.reset();
					setStatus( data.data && data.data.message ? data.data.message : boxaraContactForm.strings.success, false );
				} else {
					setStatus( data && data.data && data.data.message ? data.data.message : boxaraContactForm.strings.genericError, true );
				}
			} )
			.catch( function () {
				button.disabled = false;
				setStatus( boxaraContactForm.strings.genericError, true );
			} );
	} );
} )();
