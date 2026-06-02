<?php
/**
 * Zoptymalizowane Tagi Szablonu (Template Tags)
 * Ścieżka: wp-content/themes/theme-autodetailing/inc/template-tags.php
 * * Wydajne pobieranie danych z warstwą cachującą zapobiegającą obciążeniom MySQL.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Pobiera zoptymalizowane zapytanie dla najnowszych realizacji (strona główna).
 *
 * @param int $limit Liczba wpisów.
 * @return WP_Query
 */
function buczek_get_cached_realizacje(int $limit = 6): WP_Query {
    $transient_name = 'buczek_realizacje_home_query';
    $cached_query   = get_transient($transient_name);

    if (false === $cached_query) {
        $args = [
            'post_type'              => 'realizacje',
            'posts_per_page'         => $limit,
            'post_status'            => 'publish',
            'no_found_rows'          => true, // Pomija liczenie stron (wzrost wydajności MySQL)
            'update_post_meta_cache' => true, // Zezwala na pobranie metadanych ACF w jednym zapytaniu
            'update_post_term_cache' => false,
        ];

        $cached_query = new WP_Query($args);
        set_transient($transient_name, $cached_query, 12 * HOUR_IN_SECONDS);
    }

    return $cached_query;
}

/**
 * Pobiera zoptymalizowane zapytanie dla opinii klientów (np. slider).
 *
 * @return WP_Query
 */
function buczek_get_cached_opinie(): WP_Query {
    $transient_name = 'buczek_opinie_slider_query';
    $cached_query   = get_transient($transient_name);

    if (false === $cached_query) {
        $args = [
            'post_type'              => 'opinie',
            'posts_per_page'         => -1,
            'post_status'            => 'publish',
            'no_found_rows'          => true,
            'update_post_meta_cache' => true,
            'update_post_term_cache' => false,
        ];

        $cached_query = new WP_Query($args);
        set_transient($transient_name, $cached_query, 12 * HOUR_IN_SECONDS);
    }

    return $cached_query;
}