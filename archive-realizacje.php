<?php
/**
 * Szablon Archiwum dla Typu Wpisów: Realizacje
 * Ścieżka: wp-content/themes/theme-autodetailing/archive-realizacje.php
 * 
 * Optymalizacja: Wykorzystanie Transients API do buforowania struktury HTML renderowanej pętli.
 * Bezpieczeństwo: Pełne escapowanie zmiennych wyjściowych (XSS Mitigation).
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); ?>

<main id="primary" class="site-main realizations-archive">
    <header class="archive-header text-center">
        <div class="container">
            <h1 class="archive-title">
                <?php echo esc_html(post_type_archive_title('', false)); ?>
            </h1>
            <?php 
            $archive_description = get_the_archive_description();
            if ($archive_description) : ?>
            <div class="archive-description text-muted">
                <?php echo wp_kses_post($archive_description); ?>
            </div>
            <?php endif; ?>
        </div>
    </header>

    <div class="container section-spacing">
        <?php
        // Definicja nazwy klucza transientu dla paginacji archiwum realizacje
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $transient_key = 'buczek_realizacje_archive_page_' . $paged;
        $cached_html = get_transient($transient_key);

        if (false === $cached_html) {
            ob_start();

            if (have_posts()) : ?>
        <div class="realizations-grid row">
            <?php
                    while (have_posts()) :
                        the_post();
                        
                        // Pobieranie danych niestandardowych (ACF / Meta)
                        $service_performed = get_post_meta(get_the_ID(), 'wykonana_usluga', true);
                        $car_model         = get_post_meta(get_the_ID(), 'model_samochodu', true);
                        ?>
            <article id="post-<?php the_ID(); ?>"
                <?php post_class('col-md-4 col-sm-6 col-xs-12 realization-card-wrapper'); ?>>
                <div class="realization-card">
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="realization-thumbnail">
                        <a href="<?php echo esc_url(get_permalink()); ?>"
                            aria-label="<?php echo esc_attr(get_the_title()); ?>">
                            <?php 
                                            the_post_thumbnail('medium_large', [
                                                'class' => 'img-responsive',
                                                'loading' => 'lazy',
                                                'alt'   => esc_attr(get_the_title())
                                            ]); 
                                            ?>
                        </a>
                    </div>
                    <?php endif; ?>

                    <div class="realization-content">
                        <h2 class="realization-card-title">
                            <a href="<?php echo esc_url(get_permalink()); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <?php if (!empty($car_model) || !empty($service_performed)) : ?>
                        <div class="realization-meta">
                            <?php if (!empty($car_model)) : ?>
                            <span class="car-model">
                                <strong>Pojazd:</strong> <?php echo esc_html($car_model); ?>
                            </span>
                            <?php endif; ?>
                            <?php if (!empty($service_performed)) : ?>
                            <span class="service-type">
                                <strong>Zakres:</strong> <?php echo esc_html($service_performed); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>

                        <div class="realization-excerpt">
                            <?php echo wp_kses_post(wp_trim_words(get_the_excerpt(), 20, '...')); ?>
                        </div>

                        <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-link link-view-more">
                            <?php esc_html_e('Zobacz szczegóły', 'buczek-theme'); ?>
                        </a>
                    </div>
                </div>
            </article>
            <?php
                    endwhile;
                    ?>
        </div>

        <div class="pagination-wrapper text-center">
            <?php
                    echo paginate_links([
                        'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format'       => '?paged=%#%',
                        'current'      => max(1, get_query_var('paged')),
                        'total'        => $wp_query->max_num_pages,
                        'type'         => 'list',
                        'prev_text'    => esc_html__('&laquo; Poprzednie', 'buczek-theme'),
                        'next_text'    => esc_html__('Następne &raquo;', 'buczek-theme'),
                    ]);
                    ?>
        </div>

        <?php
            else :
                get_template_part('template-parts/content', 'none');
            endif;

            $cached_html = ob_get_clean();
            // Zapis bufora do transientu na okres 12 godzin
            set_transient($transient_key, $cached_html, 12 * HOUR_IN_SECONDS);
        }

        // Renderowanie przygotowanego lub pobranego z cache kodu HTML
        echo $cached_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        ?>
    </div>
</main>

<?php
get_footer();