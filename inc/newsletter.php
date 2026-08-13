<?php
/**
 * Homepage newsletter signup.
 *
 * Stores subscribers in a single option rather than a custom table or a
 * third-party ESP integration — no email marketing plugin is active on
 * this install yet, and an option array is plenty for a single-form,
 * low-volume capture. Swap boxara_newsletter_store_email() for a real
 * ESP call (Mailchimp, Brevo, etc.) once one is chosen.
 *
 * @package Boxara
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue the newsletter form script, front page only.
 */
function boxara_newsletter_scripts() {
	if ( ! is_front_page() ) {
		return;
	}

	wp_enqueue_script(
		'boxara-newsletter',
		get_theme_file_uri( '/assets/js/newsletter.js' ),
		array(),
		_S_VERSION,
		true
	);

	wp_localize_script(
		'boxara-newsletter',
		'boxaraNewsletter',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'boxara_newsletter_subscribe' ),
			'strings' => array(
				'invalidEmail' => esc_html__( 'Unesi ispravnu email adresu.', 'boxara' ),
				'genericError' => esc_html__( 'Nešto nije u redu. Pokušaj ponovo.', 'boxara' ),
				'success'      => esc_html__( 'Hvala! Proveri inbox za potvrdu.', 'boxara' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'boxara_newsletter_scripts' );

/**
 * Handle the AJAX subscribe request, logged-in or not.
 */
function boxara_newsletter_subscribe() {
	check_ajax_referer( 'boxara_newsletter_subscribe', 'nonce' );

	$email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Unesi ispravnu email adresu.', 'boxara' ) ), 400 );
	}

	$subscribers = get_option( 'boxara_newsletter_subscribers', array() );

	if ( in_array( $email, $subscribers, true ) ) {
		wp_send_json_success( array( 'message' => __( 'Hvala! Proveri inbox za potvrdu.', 'boxara' ) ) );
	}

	$subscribers[] = $email;
	update_option( 'boxara_newsletter_subscribers', $subscribers, false );

	/**
	 * Fires after a new email is captured by the homepage newsletter form.
	 *
	 * Hook a real ESP integration here instead of relying on the stored
	 * option, once one is chosen.
	 *
	 * @param string $email The subscribed address.
	 */
	do_action( 'boxara_newsletter_subscribed', $email );

	wp_send_json_success( array( 'message' => __( 'Hvala! Proveri inbox za potvrdu.', 'boxara' ) ) );
}
add_action( 'wp_ajax_boxara_newsletter_subscribe', 'boxara_newsletter_subscribe' );
add_action( 'wp_ajax_nopriv_boxara_newsletter_subscribe', 'boxara_newsletter_subscribe' );
