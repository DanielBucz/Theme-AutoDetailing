<?php
/**
 * System Dystrybucji i Optymalizacji Assetów
 * Ścieżka: wp-content/themes/theme-autodetailing/inc/enqueue.php
 * 
 * Zgodność ze standardami WordPress Coding Standards (WPCS) oraz PHP 8.x.
 * Optymalizacja pod kątem wskaźników LCP (Largest Contentful Paint) oraz INP (Interaction to Next Paint).
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', function () {
    // Definicja stałych ścieżek wewnętrznych (fallback w przypadku braku definicji globalnej)
    $theme_dir = get_template_directory();
    $theme_uri = get_template_directory_uri();

    // --- 1. KOMPILACJA I OPTYMALIZACJA STYLÓW CSS (Core Web Vitals) ---
    
    // Arkusz podstawowy (Reset, struktura globalna, Header, Footer)
    $main_min_css = '/assets/css/main.min.css';
    $main_dev_css = '/assets/css/main.css';
    $main_to_load = file_exists($theme_dir . $main_min_css) ? $main_min_css : $main_dev_css;
    $main_path    = $theme_dir . $main_to_load;
    $main_version = file_exists($main_path) ? filemtime($main_path) : '1.0.0';

    wp_enqueue_style(
        'buczek-main',
        $theme_uri . $main_to_load,
        [],
        $main_version,
        'all'
    );

    // Warunkowe ładowanie stylów dla Strony Głównej (Sekcja Hero, formularze główne)
    if (is_front_page()) {
        $home_min = '/assets/css/home.min.css';
        $home_dev = '/assets/css/home.css';
        $home_to_load = file_exists($theme_dir . $home_min) ? $home_min : $home_dev;
        $home_path    = $theme_dir . $home_to_load;
        
        if (file_exists($home_path)) {
            wp_enqueue_style(
                'buczek-home',
                $theme_uri . $home_to_load,
                ['buczek-main'],
                filemtime($home_path),
                'all'
            );
        }
    }

    // Warunkowe ładowanie stylów dla modułu Realizacji (CPT: realizacje)
    if (is_post_type_archive('realizacje') || is_singular('realizacje') || is_tax('realizacje-category')) {
        $realizacje_min = '/assets/css/realizacje.min.css';
        $realizacje_dev = '/assets/css/realizacje.css';
        $realizacje_to_load = file_exists($theme_dir . $realizacje_min) ? $realizacje_min : $realizacje_dev;
        $realizacje_path    = $theme_dir . $realizacje_to_load;

        if (file_exists($realizacje_path)) {
            wp_enqueue_style(
                'buczek-realizacje',
                $theme_uri . $realizacje_to_load,
                ['buczek-main'],
                filemtime($realizacje_path),
                'all'
            );
        }
    }

    // Warunkowe ładowanie stylów dla modułu Usług (CPT: uslugi)
    if (is_post_type_archive('uslugi') || is_singular('uslugi')) {
        $uslugi_min = '/assets/css/uslugi.min.css';
        $uslugi_dev = '/assets/css/uslugi.css';
        $uslugi_to_load = file_exists($theme_dir . $uslugi_min) ? $uslugi_min : $uslugi_dev;
        $uslugi_path    = $theme_dir . $uslugi_to_load;

        if (file_exists($uslugi_path)) {
            wp_enqueue_style(
                'buczek-uslugi',
                $theme_uri . $uslugi_to_load,
                ['buczek-main'],
                filemtime($uslugi_path),
                'all'
            );
        }
    }

    // --- 2. OBSŁUGA SKRYPTÓW JAVASCRIPT (Asynchroniczność i nieblokowanie DOM) ---
    
    $js_relative_path = '/assets/js/main.js';
    $js_file_path     = $theme_dir . $js_relative_path;
    $js_version       = file_exists($js_file_path) ? filemtime($js_file_path) : '1.0.0';

    
    wp_enqueue_script(
        'buczek-main-js',
        $theme_uri . $js_relative_path,
        [],
        $js_version,
        [
            'strategy'  => 'defer', // Zapobiega blokowaniu parsera HTML
            'in_footer' => true     // Ładowanie przed tagiem zamykającym </body>
        ]
    );
    if (is_front_page()) {
    $quote_js_relative_path = '/assets/js/quote-calculator.js';
    $quote_js_file_path     = $theme_dir . $quote_js_relative_path;

    if (file_exists($quote_js_file_path)) {
       wp_enqueue_script(
    'buczek-quote-calculator-js',
    $theme_uri . $quote_js_relative_path,
    ['buczek-main-js'],
    filemtime($quote_js_file_path),
    [
        'strategy'  => 'defer',
        'in_footer' => true,
    ]

    );
    }
}

    // Przekazywanie bezpiecznych zmiennych kontekstowych do skryptu JS (AJAX / Nonce)
    if (is_front_page() || is_page_template('templates/page-kontakt.php')) {
        wp_localize_script('buczek-main-js', 'buczekThemeData', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce('buczek_contact_nonce')
        ]);
    }
});

add_action('wp_head', static function (): void {
    if (!is_front_page()) {
        return;
    }

    $hero_bg = function_exists('get_field') ? get_field('hero_background_image') : null;
    $hero_bg_url = !empty($hero_bg['url'])
        ? $hero_bg['url']
        : get_template_directory_uri() . '/assets/img/hero/hero-default.jpg';

    $attributes = [
        'rel'           => 'preload',
        'as'            => 'image',
        'href'          => $hero_bg_url,
        'fetchpriority' => 'high',
    ];

    if (!empty($hero_bg['ID'])) {
        $srcset = wp_get_attachment_image_srcset((int) $hero_bg['ID'], 'full');

        if ($srcset) {
            $attributes['imagesrcset'] = $srcset;
            $attributes['imagesizes'] = '(max-width: 768px) 100vw, 1400px';
        }
    }

    $markup = '<link';

    foreach ($attributes as $name => $value) {
        $markup .= ' ' . esc_attr($name) . '="' . esc_attr((string) $value) . '"';
    }

    echo $markup . '>' . "\n";
}, 1);

add_action('wp_enqueue_scripts', static function (): void {
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('global-styles');
        wp_dequeue_style('classic-theme-styles');
    }
}, 20);

add_action('init', static function (): void {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
});

add_action('wp_footer', static function (): void {
    if (!is_singular()) {
        wp_deregister_script('wp-embed');
    }
});
