<?php

if (!defined('ABSPATH')) {
    exit;
}

acf_add_local_field_group([
    'key' => 'group_buczek_home_seo',
    'title' => 'SEO strony głównej',
    'fields' => [
        [
            'key' => 'field_buczek_seo_intro_enabled',
            'label' => 'Pokaż blok SEO',
            'name' => 'seo_intro_enabled',
            'type' => 'true_false',
            'ui' => 1,
            'default_value' => 0,
        ],
        [
            'key' => 'field_buczek_seo_intro_title',
            'label' => 'Nagłówek SEO',
            'name' => 'seo_intro_title',
            'type' => 'text',
            'instructions' => 'Np. Polerowanie lamp Lublin',
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_buczek_seo_intro_enabled',
                        'operator' => '==',
                        'value' => '1',
                    ],
                ],
            ],
        ],
        [
            'key' => 'field_buczek_seo_intro_text',
            'label' => 'Tekst SEO / wstęp',
            'name' => 'seo_intro_text',
            'type' => 'wysiwyg',
            'instructions' => 'Krótki akapit z frazą kluczową. Ten tekst pojawi się pod pierwszą sekcją strony.',
            'tabs' => 'visual',
            'toolbar' => 'basic',
            'media_upload' => 0,
            'delay' => 0,
            'conditional_logic' => [
                [
                    [
                        'field' => 'field_buczek_seo_intro_enabled',
                        'operator' => '==',
                        'value' => '1',
                    ],
                ],
            ],
        ],
    ],
    'location' => [
        [
            [
                'param' => 'page_type',
                'operator' => '==',
                'value' => 'front_page',
            ],
        ],
    ],
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
]);
