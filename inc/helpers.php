<?php
/**
 * System Optymalizacji Wydajności i Bezpieczeństwa - Rdzeń Logiki
 * Ścieżka: wp-content/themes/theme-autodetailing/inc/helpers.php
 * * Zgodność z WPCS, PHP 8.x, pełna automatyzacja Transients API oraz bezpieczny AJAX.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Uniwersalna funkcja czyszcząca cache dla konkretnego typu wpisu.
 * Zapobiega powtarzaniu kodu (DRY Principle).
 *
 * @param string $post_type Typ wpisu, dla którego czyścimy cache.
 */
function buczek_clear_cpt_transients(string $post_type): void {
    $transients_map = [
        'realizacje' => ['buczek_realizacje_home_query', 'buczek_realizacje_archive_query'],
        'uslugi'     => ['buczek_uslugi_menu_query', 'buczek_uslugi_home_query'],
        'opinie'     => ['buczek_opinie_slider_query'],
    ];

    if (array_key_exists($post_type, $transients_map)) {
        foreach ($transients_map[$post_type] as $transient_name) {
            delete_transient($transient_name);
        }
    }
}

/**
 * Automatyczne czyszczenie transientów przy zapisie lub edycji wpisów.
 */
add_action('save_post', function(int $post_id, WP_Post $post, bool $update): void {
    if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || wp_is_post_revision($post_id)) {
        return;
    }
    buczek_clear_cpt_transients($post->post_type);
}, 10, 3);

/**
 * Automatyczne czyszczenie transientów przy przenoszeniu do kosza i usuwaniu.
 */
add_action('wp_trash_post', function(int $post_id): void {
    buczek_clear_cpt_transients((string) get_post_type($post_id));
});

add_action('before_delete_post', function(int $post_id): void {
    buczek_clear_cpt_transients((string) get_post_type($post_id));
});

function buczek_get_mail_from_address(): string {
    $host = wp_parse_url(home_url(), PHP_URL_HOST);

    if (!is_string($host) || $host === '') {
        return (string) get_option('admin_email');
    }

    $host = preg_replace('/^www\./', '', $host);
    $email = sanitize_email('wordpress@' . $host);

    return $email !== '' ? $email : (string) get_option('admin_email');
}

function buczek_get_mail_headers(string $reply_to_name = '', string $reply_to_email = ''): array {
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Buczek Poleruje <' . buczek_get_mail_from_address() . '>',
    ];

    if ($reply_to_email !== '' && is_email($reply_to_email)) {
        $headers[] = 'Reply-To: ' . sanitize_text_field($reply_to_name) . ' <' . sanitize_email($reply_to_email) . '>';
    }

    return $headers;
}

/**
 * Natywna Obsługa Formularza Kontaktowego via AJAX
 */
function buczek_handle_contact_form(): void {
    // 1. Weryfikacja bezpieczeństwa (Nonce)
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'buczek_contact_nonce')) {
        wp_send_json_error(['message' => 'Błąd bezpieczeństwa. Odśwież stronę i spróbuj ponownie.']);
    }

    // 2. Honeypot - zabezpieczenie przed spam-botami
    if (!empty($_POST['website_hp'])) {
        wp_send_json_success(['message' => 'Wiadomość wysłana pomyślnie!']);
    }

    // 3. Walidacja i Sanityzacja pól
    $name    = isset($_POST['client_name']) ? sanitize_text_field($_POST['client_name']) : '';
    $email   = isset($_POST['client_email']) ? sanitize_email($_POST['client_email']) : '';
    $phone   = isset($_POST['client_phone']) ? sanitize_text_field($_POST['client_phone']) : '';
    $message = isset($_POST['client_message']) ? sanitize_textarea_field($_POST['client_message']) : '';

    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error(['message' => 'Wypełnij wszystkie wymagane pola.']);
    }

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Podaj poprawny adres e-mail.']);
    }

    // 4. Konstrukcja i wysyłka e-maila
    $to      = get_option('admin_email');
    $subject = 'Nowe zapytanie ofertowe ze strony: ' . get_bloginfo('name');
    
    $body  = "Otrzymałeś nową wiadomość z formularza kontaktowego:\n\n";
    $body .= "Imię i nazwisko: $name\n";
    $body .= "E-mail: $email\n";
    $body .= "Telefon: " . (!empty($phone) ? $phone : 'Nie podano') . "\n\n";
    $body .= "Treść wiadomości:\n$message\n";

    $headers = buczek_get_mail_headers($name, $email);

    if (wp_mail($to, $subject, $body, $headers)) {
        wp_send_json_success(['message' => 'Dziękujemy! Twoja wiadomość została wysłana pomyślnie.']);
    } else {
        wp_send_json_error(['message' => 'Wystąpił błąd serwera. Spróbuj ponownie później.']);
    }
}
add_action('wp_ajax_buczek_contact', 'buczek_handle_contact_form');
add_action('wp_ajax_nopriv_buczek_contact', 'buczek_handle_contact_form');
