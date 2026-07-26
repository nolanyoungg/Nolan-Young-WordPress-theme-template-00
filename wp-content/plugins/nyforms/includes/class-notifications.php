<?php
/**
 * Submission notifications.
 *
 * @package NYforms
 */

namespace NYforms;

defined( 'ABSPATH' ) || exit;

/**
 * Sends core email and registered provider notifications with redacted events.
 */
class Notifications {
	/**
	 * Send enabled matching notifications.
	 *
	 * @param array $form     Stored form.
	 * @param array $values   Validated values.
	 * @param int   $entry_id Entry ID.
	 * @return void
	 */
	public function send( $form, $values, $entry_id ) {
		foreach ( $form['definition']['notifications'] as $notification ) {
			$context = array(
				'notification_id' => sanitize_key( $notification['id'] ?? '' ),
				'provider'        => sanitize_key( $notification['provider'] ?? 'email' ),
			);

			if ( empty( $notification['enabled'] ) || ! Conditions::matches( $notification['conditions'], $values ) ) {
				$this->event( $form['id'], $entry_id, 'notification_skipped', $context );
				continue;
			}

			if ( 'email' !== $context['provider'] ) {
				$this->send_provider( $notification, $form, $values, $entry_id, $context );
				continue;
			}

			$to         = $this->tokens( $notification['to'], $form, $values, $entry_id );
			$recipients = array_filter( array_map( 'trim', explode( ',', $to ) ), 'is_email' );
			if ( ! $recipients ) {
				$this->event( $form['id'], $entry_id, 'notification_invalid_recipient', $context );
				continue;
			}

			$subject = wp_strip_all_tags( $this->tokens( $notification['subject'], $form, $values, $entry_id ) );
			$message = $this->tokens( $notification['message'], $form, $values, $entry_id );
			$headers = array( 'Content-Type: text/html; charset=UTF-8' );

			if ( $notification['from_email'] && is_email( $notification['from_email'] ) ) {
				$headers[] = 'From: ' . sanitize_text_field( $notification['from_name'] ) . ' <' . sanitize_email( $notification['from_email'] ) . '>';
			}

			$reply = $this->tokens( $notification['reply_to'], $form, $values, $entry_id );
			if ( is_email( $reply ) ) {
				$headers[] = 'Reply-To: ' . sanitize_email( $reply );
			}

			$sent = wp_mail( $recipients, $subject, wp_kses_post( $message ), $headers );
			$this->event( $form['id'], $entry_id, $sent ? 'notification_sent' : 'notification_failed', $context );
		}
	}

	/**
	 * Replace safe notification tokens.
	 *
	 * @param string $text     Template text.
	 * @param array  $form     Stored form.
	 * @param array  $values   Validated values.
	 * @param int    $entry_id Entry ID.
	 * @return string
	 */
	public function tokens( $text, $form, $values, $entry_id ) {
		return (string) preg_replace_callback(
			'/\[\[nyforms:(field|form|site|entry):([a-zA-Z0-9_-]+)\]\]/',
			function ( $match ) use ( $form, $values, $entry_id ) {
				if ( 'field' === $match[1] ) {
					$value = $values[ $match[2] ] ?? '';
					return esc_html( is_array( $value ) ? implode( ', ', $value ) : $value );
				}
				if ( 'form' === $match[1] && 'title' === $match[2] ) {
					return esc_html( $form['title'] );
				}
				if ( 'site' === $match[1] && 'name' === $match[2] ) {
					return esc_html( get_bloginfo( 'name' ) );
				}
				if ( 'entry' === $match[1] && 'id' === $match[2] ) {
					return (string) $entry_id;
				}
				return '';
			},
			(string) $text
		);
	}

	/**
	 * Send through an explicitly registered provider.
	 *
	 * @param array $notification Notification definition.
	 * @param array $form         Stored form.
	 * @param array $values       Validated values.
	 * @param int   $entry_id     Entry ID.
	 * @param array $context      Redacted event context.
	 * @return void
	 */
	private function send_provider( $notification, $form, $values, $entry_id, $context ) {
		foreach ( Extensions::notification_providers() as $provider ) {
			if ( $provider instanceof Notification_Provider && $context['provider'] === $provider->key() ) {
				$sent = (bool) $provider->send( $notification, $form, $values, $entry_id );
				$this->event( $form['id'], $entry_id, $sent ? 'notification_sent' : 'notification_failed', $context );
				return;
			}
		}

		$this->event( $form['id'], $entry_id, 'notification_provider_unavailable', $context );
	}

	/**
	 * Write a redacted delivery event.
	 *
	 * @param int    $form_id  Form ID.
	 * @param int    $entry_id Entry ID.
	 * @param string $type     Event type.
	 * @param array  $context  Non-sensitive metadata.
	 * @return void
	 */
	private function event( $form_id, $entry_id, $type, $context = array() ) {
		Plugin::instance()->repository->event( $type, $form_id, $entry_id, $context );
	}
}
