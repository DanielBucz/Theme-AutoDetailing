<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    register_post_type('uslugi', [
        'labels' => [
            'name' => 'Usługi',
            'singular_name' => 'Usługa',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'uslugi'],
        'show_in_rest' => true,
    ]);
});
