<?php
/**
 * System Optymalizacji Wydajności - Zarządzanie Transients API
 * Lokalizacja: /inc/helpers.php
 * * Ten plik odpowiada za automatyczną inwalidację (czyszczenie) pamięci podręcznej
 * w momencie modyfikacji wpisów CPT (realizacje, usługi, opinie).
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
function buczek_clear_cpt_transients($post_type) {
    // Definiujemy mapę transientów powiązanych z konkretnymi typami wpisów
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
 * Automatyczne czyszczenie transientów przy zapisie, edycji lub usuwaniu wpisów.
 * Obsługuje hook 'save_post', reagując tylko na specyficzne CPT.
 *
 * @param int $post_id ID modyfikowanego wpisu.
 * @param WP_Post $post Obiekt modyfikowanego wpisu.
 * @param bool $update Czy wpis jest aktualizowany (true) czy tworzony (false).
 */
function buczek_on_post_save_clear_cache($post_id, $post, $update) {
    // Ignorujemy automatyczne zapisy szkiców (autosave)
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Ignorujemy rewizje wpisów
    if (wp_is_post_revision($post_id)) {
        return;
    }

    // Wywołujemy czyszczenie transientów dla typu wpisu
    buczek_clear_cpt_transients($post->post_type);
}
add_action('save_post', 'buczek_on_post_save_clear_cache', 10, 3);

/**
 * Dodatkowe zabezpieczenie: czyszczenie przy usuwaniu wpisu do kosza 
 * oraz przed trwałym usunięciem.
 */
add_action('wp_trash_post', function($post_id) {
    $post_type = get_post_type($post_id);
    buczek_clear_cpt_transients($post_type);
});

add_action('before_delete_post', function($post_id) {
    $post_type = get_post_type($post_id);
    buczek_clear_cpt_transients($post_type);
});