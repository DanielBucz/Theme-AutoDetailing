<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    register_post_type('opinie', [
        'labels' => [
            'name' => 'Opinie',
            'singular_name' => 'Opinia',
        ],
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => ['title', 'editor'],
        'rewrite' => ['slug' => 'opinie'],
        'show_in_rest' => true,
    ]);
});