<?php
/**
 * Title: Kontakt — Form & Info
 * Slug: boxara/kontakt-form
 * Categories: boxara-home
 * Description: Contact form (wired to a real AJAX handler, see inc/contact-form.php) next to a store info card with social links.
 * Keywords: kontakt, contact, form, informacije
 * Viewport Width: 1440
 *
 * @package Boxara
 */

$boxara_social = boxara_social_links();
?>
<!-- wp:group {"className":"kontakt-main","layout":{"type":"constrained"}} -->
<div class="wp-block-group kontakt-main">
	<div class="kontakt-main__row">

		<div class="kontakt-form">
			<form class="kontakt-form__form" novalidate>

				<div class="kontakt-form__group">
					<label class="kontakt-form__label" for="kontakt-name">IME I PREZIME</label>
					<input class="kontakt-form__input" type="text" id="kontakt-name" name="name" placeholder="Unesite vaše ime i prezime" autocomplete="name" required />
				</div>

				<div class="kontakt-form__group">
					<label class="kontakt-form__label" for="kontakt-email">EMAIL ADRESA</label>
					<input class="kontakt-form__input" type="email" id="kontakt-email" name="email" placeholder="primer@email.com" autocomplete="email" required />
				</div>

				<div class="kontakt-form__group">
					<label class="kontakt-form__label" for="kontakt-subject">TEMA</label>
					<input class="kontakt-form__input" type="text" id="kontakt-subject" name="subject" placeholder="Npr. Porudžbina po meri, Dostava, Saradnja..." autocomplete="off" />
				</div>

				<div class="kontakt-form__group">
					<label class="kontakt-form__label" for="kontakt-message">PORUKA</label>
					<textarea class="kontakt-form__input kontakt-form__input--textarea" id="kontakt-message" name="message" placeholder="Napišite vašu poruku ovde..." rows="5" required></textarea>
				</div>

				<p class="kontakt-form__honeypot" aria-hidden="true">
					<label for="kontakt-website">Website</label>
					<input type="text" id="kontakt-website" name="website" tabindex="-1" autocomplete="off" />
				</p>

				<button class="kontakt-form__submit" type="submit">POŠALJITE PORUKU</button>

				<p class="kontakt-form__status" role="status" hidden></p>

			</form>
		</div>

		<div class="kontakt-info">

			<div class="kontakt-info__header">
				<h2 class="kontakt-info__title">INFORMACIJE</h2>
				<span class="kontakt-info__divider" aria-hidden="true"></span>
			</div>

			<div class="kontakt-info__list">

				<div class="kontakt-info__item">
					<div class="kontakt-info__item-row">
						<span class="kontakt-info__icon"><?php boxara_icon( 'map-pin' ); ?></span>
						<span class="kontakt-info__label">IZLOŽBENI PROSTOR</span>
					</div>
					<p class="kontakt-info__value">Knez Mihailova 24, Beograd, Srbija</p>
				</div>

				<div class="kontakt-info__item">
					<div class="kontakt-info__item-row">
						<span class="kontakt-info__icon"><?php boxara_icon( 'clock' ); ?></span>
						<span class="kontakt-info__label">RADNO VREME</span>
					</div>
					<p class="kontakt-info__value">Pon &ndash; Sub: 10:00 &ndash; 21:00 | Ned: 11:00 &ndash; 18:00</p>
				</div>

				<div class="kontakt-info__item">
					<div class="kontakt-info__item-row">
						<span class="kontakt-info__icon"><?php boxara_icon( 'phone' ); ?></span>
						<span class="kontakt-info__label">TELEFON</span>
					</div>
					<p class="kontakt-info__value"><a href="tel:+381111234567">+381 11 123 4567</a></p>
				</div>

				<div class="kontakt-info__item">
					<div class="kontakt-info__item-row">
						<span class="kontakt-info__icon"><?php boxara_icon( 'mail' ); ?></span>
						<span class="kontakt-info__label">EMAIL ADRESA</span>
					</div>
					<p class="kontakt-info__value"><a href="mailto:kontakt@boxara.rs">kontakt@boxara.rs</a></p>
				</div>

			</div>

			<?php if ( $boxara_social ) : ?>
				<div class="kontakt-info__social">
					<span class="kontakt-info__label">PRATITE NAS NA MREŽAMA</span>
					<div class="kontakt-info__social-row">
						<?php foreach ( $boxara_social as $boxara_key => $boxara_link ) : ?>
							<a class="kontakt-info__social-link" href="<?php echo esc_url( $boxara_link['url'] ); ?>" rel="noopener noreferrer" target="_blank">
								<span class="screen-reader-text"><?php echo esc_html( $boxara_link['label'] ); ?></span>
								<?php boxara_icon( $boxara_key ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

		</div>

	</div>
</div>
<!-- /wp:group -->
