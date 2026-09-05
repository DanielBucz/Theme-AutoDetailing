<?php

if (!defined('ABSPATH')) {
    exit;
}

function buczek_site_icon_url(): string
{
    return get_template_directory_uri() . '/assets/img/site-icon-buczek.png';
}

add_filter('get_site_icon_url', static function ($url = '', $size = 512, $blog_id = 0): string {
    return buczek_site_icon_url();
}, 10, 3);

add_action('wp_head', static function (): void {
    $site_icon_url = esc_url(buczek_site_icon_url());

    echo '<link rel="icon" href="' . $site_icon_url . '" sizes="512x512">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . $site_icon_url . '">' . "\n";
}, 99);
