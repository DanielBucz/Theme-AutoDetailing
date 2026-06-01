<?php

add_action('wp_enqueue_scripts', function () {
    
    // --- 1. OBSŁUGA STYLÓW (CSS) Z MINIFIKACJĄ I CACHE BUSTINGIEM ---
    $minified_css = '/assets/css/main.min.css';
    $default_css  = '/assets/css/main.css';
    
    // Sprawdzamy fizycznie na serwerze, który plik istnieje (priorytet ma min.css z produkcji)
    $css_to_load = file_exists(get_template_directory() . $minified_css) ? $minified_css : $default_css;
    $css_path    = get_template_directory() . $css_to_load;
    
    wp_enqueue_style(
        'buczek-main',
        get_template_directory_uri() . $css_to_load,
        [],
        file_exists($css_path) ? filemtime($css_path) : '1.0.0'
    );


    // --- 2. OBSŁUGA SKRYPTÓW (JS) Z NAPRAWIONYM BŁĘDEM I DEFER ---
    $js_relative_path = '/assets/js/main.js';
    $js_file_path     = get_template_directory() . $js_relative_path; // Poprawne zdefiniowanie ścieżki systemowej
    
    wp_enqueue_script(
        'buczek-main-js',
        THEME_URI . $js_relative_path,
        [],
        file_exists($js_file_path) ? filemtime($js_file_path) : '1.0.0',
        [
            'strategy'  => 'defer', // 🔥 Kluczowe dla Core Web Vitals: skrypt nie blokuje renderowania strony
            'in_footer' => true     // Ładuje w stopce (tak jak miałeś)
        ]
    );
});