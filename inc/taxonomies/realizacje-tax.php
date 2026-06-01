<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function () {
    register_taxonomy('realizacja_typ', ['realizacje'], [
        'labels' => [
            'name' => 'Typy realizacji',
            'singular_name' => 'Typ realizacji',
        ],
        'public' => true,
        'hierarchical' => true,
        'rewrite' => ['slug' => 'typ-realizacji'],
        'show_in_rest' => true,
    ]);
});