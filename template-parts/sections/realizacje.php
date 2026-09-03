<?php
$section_title = function_exists('get_field') && get_field('realizations_title')
    ? get_field('realizations_title')
    : 'Efekty renowacji lamp';

$section_text = function_exists('get_field') && get_field('realizations_text')
    ? get_field('realizations_text')
    : 'Zobacz różnicę przed i po. To właśnie efekt, który najbardziej sprzedaje usługę.';

$before_image = function_exists('get_field') ? get_field('before_image') : null;
$after_image  = function_exists('get_field') ? get_field('after_image') : null;

$before_url = !empty($before_image['url'])
    ? $before_image['url']
    : get_template_directory_uri() . '/assets/img/realizacje/lampa-przed.jpg';

$after_url = !empty($after_image['url'])
    ? $after_image['url']
    : get_template_directory_uri() . '/assets/img/realizacje/lampa-po.jpg';

$cta_title = function_exists('get_field') && get_field('realizations_cta_title')
    ? get_field('realizations_cta_title')
    : 'Tylko 2 godziny i lampy jak nowe';

$cta_text = function_exists('get_field') && get_field('realizations_cta_text')
    ? get_field('realizations_cta_text')
    : 'Renowacja lamp poprawia nie tylko wygląd auta, ale też widoczność i bezpieczeństwo jazdy.';

$cta_button_text = function_exists('get_field') && get_field('realizations_cta_button_text')
    ? get_field('realizations_cta_button_text')
    : 'Chcę taką renowację';

$cta_button_url = function_exists('get_field') && get_field('realizations_cta_button_url')
    ? get_field('realizations_cta_button_url')
    : '#kontakt';
?>

<section class="realizations" id="realizacje">
    <div class="realizations__container container">
        <div class="realizations__header">
            <p class="realizations__eyebrow">Przykładowa realizacja</p>

            <h2 class="realizations__title">
                <?php echo esc_html($section_title); ?>
            </h2>

            <p class="realizations__text">
                <?php echo esc_html($section_text); ?>
            </p>
        </div>

        <div class="before-after">
            <article class="before-after__item before-after__item--before">
                <div class="before-after__media">
                    <img class="before-after__image" src="<?php echo esc_url($before_url); ?>"
                        alt="Lampa przed renowacją" loading="lazy">
                    <span class="before-after__badge before-after__badge--before">
                        Przed
                    </span>
                </div>
            </article>

            <article class="before-after__item before-after__item--after">
                <div class="before-after__media">
                    <img class="before-after__image" src="<?php echo esc_url($after_url); ?>" alt="Lampa po renowacji"
                        loading="lazy">
                    <span class="before-after__badge before-after__badge--after">
                        Po
                    </span>
                </div>
            </article>
        </div>

        <div class="realizations__cta">
            <h3 class="realizations__cta-title">
                <?php echo esc_html($cta_title); ?>
            </h3>

            <p class="realizations__cta-text">
                <?php echo esc_html($cta_text); ?>
            </p>

            <div class="realizations__cta-actions">
                <a href="<?php echo esc_url($cta_button_url); ?>" class="btn btn--primary realizations__cta-button">
                    <?php echo esc_html($cta_button_text); ?>
                </a>

                <!-- <a class="btn btn--ghost realizations__cta-button realizations__cta-button--ghost"
                    href="<?php echo esc_url(get_post_type_archive_link('realizacje')); ?>">
                    Zobacz wszystkie realizacje
                </a> -->
            </div>
        </div>
        <div class="realizations__featured">
            <div class="realizations__featured-media">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/realizacje/realizacja-poziomaa.jpg"
                    alt="Odnowione reflektory po polerowaniu" loading="lazy">
            </div>

            <div class="realizations__featured-content">
                <p class="realizations__featured-eyebrow">Kolejna realizacja</p>

                <h3 class="realizations__featured-title">
                    Odzyskana przejrzystość reflektorów
                </h3>

                <p class="realizations__featured-text">
                    Usunięcie mlecznego nalotu, wypolerowanie kloszy i zabezpieczenie lamp przed szybkim ponownym
                    matowieniem.
                </p>

                <!-- <a href="#kontakt" class="btn btn--ghost realizations__featured-button">
                    Zobacz realizację
                </a> -->
            </div>
        </div>

    </div>
</section>
