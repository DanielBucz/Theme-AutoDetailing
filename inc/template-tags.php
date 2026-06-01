<?php
/**
 * Zoptymalizowane Tagi Szablonu (Template Tags) z obsługą Transients API
 * Lokalizacja: /inc/template-tags.php
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Pobiera zoptymalizowane zapytanie dla najnowszych realizacji (np. na stronę główną)
 * Zwraca obiekt WP_Query bezpośrednio z pamięci podręcznej lub bazy danych.
 *
 * @param int $limit Liczba realizacji do pobrania. Default 6.
 * @return WP_Query
 */
function buczek_get_cached_realizacje($limit = 6) {
    $transient_name = 'buczek_realizacje_home_query';
    $cached_query   = get_transient($transient_name);

    // Jeśli cache nie istnieje, wykonujemy zapytanie do bazy danych
    if (false === $cached_query) {
        $args = [
            'post_type'              => 'realizacje',
            'posts_per_page'         => $limit,
            'post_status'            => 'publish',
            'no_found_rows'          => true, // Krytyczne dla wydajności: pomija liczenie wszystkich rekordów (brak paginacji na home)
            'update_post_meta_cache' => true, // Zostawiamy true jeśli używasz ACF w pętli
            'update_post_term_cache' => false, // Wyłączamy, jeśli na home nie wyświetlasz taksonomii przy każdym wpisie
        ];

        $cached_query = new WP_Query($args);

        // Zapisujemy wynik do pamięci podręcznej na 12 godzin
        set_transient($transient_name, $cached_query, 12 * HOUR_IN_SECONDS);
    }

    return $cached_query;
}

/**
 * Pobiera zoptymalizowane zapytanie dla opinii klientów (np. do slidera)
 *
 * @return WP_Query
 */
function buczek_get_cached_opinie() {
    $transient_name = 'buczek_opinie_slider_query';
    $cached_query   = get_transient($transient_name);

    if (false === $cached_query) {
        $args = [
            'post_type'              => 'opinie',
            'posts_per_page'         => -1, // Pobieramy wszystkie opinie do slidera
            'post_status'            => 'publish',
            'no_found_rows'          => true, // Brak paginacji
            'update_post_meta_cache' => true, // Potrzebne dla ocen gwiazdkowych z ACF
            'update_post_term_cache' => false,
        ];

        $cached_query = new WP_Query($args);

        set_transient($transient_name, $cached_query, 12 * HOUR_IN_SECONDS);
    }

    return $cached_query;
}