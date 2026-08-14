<?php
/**
 * Kontakt page contact form.
 *
 * No form plugin is active on this install, so this wires a real AJAX
 * handler that emails the site admin — same approach as the homepage
 * newsletter signup (see inc/newsletter.php).
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue the contact form script, Kontakt page only.
 */
function boxara_contact_form_scripts() {
	if ( ! is_page( 'kontakt' ) ) {
		return;
	}

	wp_enqueue_script(
		'boxara-contact-form',
		get_theme_file_uri( '/assets/js/contact-form.js' ),
		array(),
		_S_VERSION,
		true
	);

	wp_localize_script(
		'boxara-contact-form',
		'boxaraContactForm',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'boxara_contact_form_submit' ),
			'strings' => array(
				'missingFields' => esc_html__( 'Popunite ime, email i poruku.', 'boxara' ),
				'invalidEmail'  => esc_html__( 'Unesite ispravnu email adresu.', 'boxara' ),
				'genericError'  => esc_html__( 'Nešto nije u redu. Pokušajte ponovo.', 'boxara' ),
				'success'       => esc_html__( 'Hvala! Vaša poruka je poslata — javićemo vam se uskoro.', 'boxara' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'boxara_contact_form_scripts' );

/**
 * Handle the AJAX contact form submission, logged-in or not.
 */
function boxara_contact_form_submit() {
	check_ajax_referer( 'boxara_contact_form_submit', 'nonce' );

	// Honeypot: real visitors never fill this hidden field.
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success( array( 'message' => __( 'Hvala! Vaša poruka je poslata — javićemo vam se uskoro.', 'boxara' ) ) );
	}

	$name         = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email_raw    = isset( $_POST['email'] ) ? trim( wp_unslash( $_POST['email'] ) ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
	$subject      = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
	$message      = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $name || ! $email_raw || ! $message ) {
		wp_send_json_error( array( 'message' => __( 'Popunite ime, email i poruku.', 'boxara' ) ), 400 );
	}

	if ( ! is_email( $email_raw ) ) {
		wp_send_json_error( array( 'message' => __( 'Unesite ispravnu email adresu.', 'boxara' ) ), 400 );
	}

	$email = sanitize_email( $email_raw );

	$mail_subject = $subject
		? sprintf( /* translators: %s: message subject/topic. */ __( 'Nova poruka sa sajta: %s', 'boxara' ), $subject )
		: __( 'Nova poruka sa kontakt forme', 'boxara' );

	$mail_body  = sprintf( "Ime: %s\n", $name );
	$mail_body .= sprintf( "Email: %s\n", $email );
	if ( $subject ) {
		$mail_body .= sprintf( "Tema: %s\n", $subject );
	}
	$mail_body .= "\n" . $message;

	$sent = wp_mail(
		get_option( 'admin_email' ),
		$mail_subject,
		$mail_body,
		array( sprintf( 'Reply-To: %1$s <%2$s>', $name, $email ) )
	);

	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => __( 'Nešto nije u redu. Pokušajte ponovo.', 'boxara' ) ), 500 );
	}

	wp_send_json_success( array( 'message' => __( 'Hvala! Vaša poruka je poslata — javićemo vam se uskoro.', 'boxara' ) ) );
}
add_action( 'wp_ajax_boxara_contact_form_submit', 'boxara_contact_form_submit' );
add_action( 'wp_ajax_nopriv_boxara_contact_form_submit', 'boxara_contact_form_submit' );
