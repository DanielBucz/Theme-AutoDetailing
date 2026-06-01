<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {

    register_post_type('realizacje', [
        'labels' => [
            'name' => 'Realizacje',
            'singular_name' => 'Realizacja',
            'add_new' => 'Dodaj realizację',
            'add_new_item' => 'Dodaj nową realizację',
            'edit_item' => 'Edytuj realizację',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-format-gallery',
        'has_archive' => true,
        'rewrite' => ['slug' => 'realizacje'],
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);

});