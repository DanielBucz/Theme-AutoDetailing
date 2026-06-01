<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    register_post_type('realizacje', [
        'labels' => [
            'name' => 'Realizacje',
            'singular_name' => 'Realizacja',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'realizacje'],
        'show_in_rest' => true,
    ]);
});