<?php

if (!defined('ABSPATH')) {
    exit;
}

function buczek_site_icon_url(): string
{
    return get_template_directory_uri() . '/assets/img/site-icon-buczek.png';
}

function buczek_front_page_seo_title(): string
{
    return 'Polerowanie lamp Lublin - renowacja reflektorów | Buczek Poleruje';
}

function buczek_front_page_seo_description(): string
{
    return 'Polerowanie lamp samochodowych w Lublinie. Renowacja zmatowiałych reflektorów, zabezpieczenie UV i szybka wycena od 120 zł. Buczek Poleruje.';
}

function buczek_is_front_page_seo(): bool
{
    return !is_admin() && (is_front_page() || is_home());
}

function buczek_has_yoast_seo(): bool
{
    return defined('WPSEO_VERSION') || class_exists('WPSEO_Options');
}

add_filter('get_site_icon_url', static function ($url = '', $size = 512, $blog_id = 0): string {
    return buczek_site_icon_url();
}, 10, 3);

add_filter('pre_get_document_title', static function (string $title): string {
    if (!buczek_is_front_page_seo() || buczek_has_yoast_seo()) {
        return $title;
    }

    return buczek_front_page_seo_title();
});

add_filter('document_title_parts', static function (array $parts): array {
    if (!buczek_is_front_page_seo() || buczek_has_yoast_seo()) {
        return $parts;
    }

    $parts['title'] = buczek_front_page_seo_title();
    unset($parts['tagline'], $parts['site']);

    return $parts;
});

add_action('wp_head', static function (): void {
    $site_icon_url = esc_url(buczek_site_icon_url());

    echo '<link rel="icon" href="' . $site_icon_url . '" sizes="512x512">' . "\n";
    echo '<link rel="apple-touch-icon" href="' . $site_icon_url . '">' . "\n";
}, 99);

add_action('wp_head', static function (): void {
    if (!buczek_is_front_page_seo() || buczek_has_yoast_seo()) {
        return;
    }

    $description = buczek_front_page_seo_description();
    $title = buczek_front_page_seo_title();
    $url = home_url('/');
    $logo_url = get_template_directory_uri() . '/assets/img/logo-buczek-poleruje.png';

    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";

    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'AutoRepair',
        '@id' => $url . '#polerowanie-lamp',
        'name' => 'Buczek Poleruje - polerowanie lamp',
        'url' => $url,
        'image' => $logo_url,
        'logo' => $logo_url,
        'telephone' => '+48668974402',
        'description' => $description,
        'areaServed' => [
            '@type' => 'City',
            'name' => 'Lublin',
        ],
        'priceRange' => 'od 120 PLN',
        'makesOffer' => [
            [
                '@type' => 'Offer',
                'name' => 'Polerowanie lamp samochodowych',
                'priceSpecification' => [
                    '@type' => 'PriceSpecification',
                    'price' => '120',
                    'priceCurrency' => 'PLN',
                ],
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => 'Renowacja i polerowanie reflektorów samochodowych',
                    'areaServed' => 'Lublin',
                ],
            ],
        ],
        'sameAs' => [
            'https://instagram.com/buczek.poleruje',
        ],
    ];

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}, 30);
