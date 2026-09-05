<?php

if (!defined('ABSPATH')) {
    exit;
}

define('THEME_PATH', get_template_directory());
define('THEME_URI', get_template_directory_uri());

require_once THEME_PATH . '/inc/setup.php';
require_once THEME_PATH . '/inc/enqueue.php';

// 1
require_once THEME_PATH . '/inc/theme-support.php';

// 2
require_once THEME_PATH . '/inc/helpers.php';

// 3
require_once THEME_PATH . '/inc/template-tags.php';

// 4
require_once THEME_PATH . '/inc/seo.php';

// 5
require_once THEME_PATH . '/inc/cpt/realizacje.php';

//6
require_once THEME_PATH . '/inc/cpt/uslugi.php';

// 7
require_once THEME_PATH . '/inc/cpt/opinie.php';

// 8
require_once THEME_PATH . '/inc/taxonomies/realizacje-tax.php';

// 9
if (function_exists('acf_add_local_field_group')) {
    require_once THEME_PATH . '/inc/acf/fields-realizacje.php';
    require_once THEME_PATH . '/inc/acf/fields-home.php';
    require_once THEME_PATH . '/inc/acf/fields-options.php';
}


add_action('wp_ajax_buczek_quote_form', 'buczek_handle_quote_form');
add_action('wp_ajax_nopriv_buczek_quote_form', 'buczek_handle_quote_form');

function buczek_handle_quote_form() {
    check_ajax_referer('buczek_contact_nonce', 'security');

    $client_name  = isset($_POST['clientName']) ? sanitize_text_field(wp_unslash($_POST['clientName'])) : '';
    $client_phone = isset($_POST['clientPhone']) ? sanitize_text_field(wp_unslash($_POST['clientPhone'])) : '';
    $lamp_condition = isset($_POST['lampCondition']) ? sanitize_text_field(wp_unslash($_POST['lampCondition'])) : '';
    $lamp_count     = isset($_POST['lampCount']) ? sanitize_text_field(wp_unslash($_POST['lampCount'])) : '';
    $quote_value  = isset($_POST['quoteValue']) ? sanitize_text_field(wp_unslash($_POST['quoteValue'])) : '';

    $addons = isset($_POST['addons']) ? array_map('sanitize_text_field', wp_unslash((array) $_POST['addons'])) : [];

    if (empty($client_name) || empty($client_phone)) {
        wp_send_json_error([
            'message' => 'Uzupełnij imię i telefon.',
        ]);
    }

    $to      = get_option('admin_email');
    $subject = 'Nowa wycena renowacji lamp - Buczek Poleruje';

    $condition_labels = [
        'light'  => 'Lekko zmatowiałe',
        'medium' => 'Widocznie żółte lub mleczne',
        'heavy'  => 'Mocno zniszczone / głębokie zmatowienie',
    ];

    $lamp_count_labels = [
        'single' => 'Jedna lampa',
        'pair'   => 'Komplet przednich lamp',
    ];

    $addon_labels = [
        'uv'         => 'Zabezpieczenie UV',
        'deep'       => 'Dodatkowe szlifowanie głębokich zmatowień',
        'inspection' => 'Kontrola efektu świecenia',
        'travel'     => 'Dojazd na terenie Lublina',
    ];

    $selected_addons = array_map(
        static function ($addon) use ($addon_labels) {
            return $addon_labels[$addon] ?? $addon;
        },
        $addons
    );

    $message  = "Nowe zapytanie o renowację lamp:\n\n";
    $message .= "Imię: {$client_name}\n";
    $message .= "Telefon: {$client_phone}\n";
    $message .= "Stan lamp: " . ($condition_labels[$lamp_condition] ?? $lamp_condition) . "\n";
    $message .= "Liczba lamp: " . ($lamp_count_labels[$lamp_count] ?? $lamp_count) . "\n";
    $message .= "Dodatki: " . (!empty($selected_addons) ? implode(', ', $selected_addons) : 'Brak') . "\n";
    $message .= "Informacja o cenie: {$quote_value}\n";

    $sent = wp_mail($to, $subject, $message, buczek_get_mail_headers($client_name));

    if (!$sent) {
        wp_send_json_error([
            'message' => 'Nie udało się wysłać formularza. Spróbuj ponownie.',
        ]);
    }

    wp_send_json_success([
        'message' => 'Dziękujemy! Skontaktujemy się w sprawie renowacji lamp.',
    ]);
}
