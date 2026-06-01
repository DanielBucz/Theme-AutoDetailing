<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'buczek-main',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        filemtime(get_template_directory() . '/assets/css/main.css')
    );
    wp_enqueue_script(
        'buczek-main-js',
        THEME_URI . '/assets/js/main.js',
        [],
        file_exists($js_file) ? filemtime($js_file) : null,
        true // 🔥 ładuje w footerze
    );
});