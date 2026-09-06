<?php
$hero_title = function_exists('get_field') && get_field('hero_title')
    ? get_field('hero_title')
    : 'Buczek Poleruje';

$hero_subtitle = function_exists('get_field') && get_field('hero_subtitle')
    ? get_field('hero_subtitle')
    : 'Renowacja i polerowanie lamp samochodowych • Lublin';

$hero_text = function_exists('get_field') && get_field('hero_text')
    ? get_field('hero_text')
    : 'Zmatowiałe reflektory? Przywracam przejrzystość lamp, poprawiam wygląd auta i zabezpieczam klosze przed szybkim matowieniem.';

$hero_button_text = function_exists('get_field') && get_field('hero_button_text')
    ? get_field('hero_button_text')
    : 'Umów termin';

$hero_button_url = function_exists('get_field') && get_field('hero_button_url')
    ? get_field('hero_button_url')
    : '#kontakt';

$hero_bg = function_exists('get_field') ? get_field('hero_background_image') : null;
$hero_bg_url = !empty($hero_bg['url'])
    ? $hero_bg['url']
    : get_template_directory_uri() . '/assets/img/hero/hero-default.jpg';

$hero_bg_alt = !empty($hero_bg['alt'])
    ? $hero_bg['alt']
    : $hero_title;
?>

<section class="hero" id="top">
    <div class="hero-container">
        <div class="hero__bg">
            <img class="hero__bg-image" src="<?php echo esc_url($hero_bg_url); ?>"
                alt="<?php echo esc_attr($hero_bg_alt); ?>">
            <div class="hero__overlay"></div>
        </div>

        <div class="hero__container container">
            <div class="hero__content">
                <p class="hero__eyebrow">Polerowanie lamp</p>

                <h1 class="hero__title">
                    <?php echo esc_html($hero_title); ?>
                </h1>

                <p class="hero__subtitle">
                    <?php echo esc_html($hero_subtitle); ?>
                </p>

                <p class="hero__text">
                    <?php echo esc_html($hero_text); ?>
                </p>

                <div class="hero__actions">
                    <a class="btn btn--primary hero__button" href="<?php echo esc_url($hero_button_url); ?>">
                        <?php echo esc_html($hero_button_text); ?>
                    </a>

                    <a class="btn btn--ghost hero__button" href="#realizacje">
                        Zobacz efekty
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
