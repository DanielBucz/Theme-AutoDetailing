<?php
$seo_intro_enabled = function_exists('get_field') ? get_field('seo_intro_enabled') : false;
$seo_intro_title = function_exists('get_field') ? get_field('seo_intro_title') : '';
$seo_intro_text = function_exists('get_field') ? get_field('seo_intro_text') : '';

$default_title = 'Polerowanie lamp Lublin';
$default_text = 'Buczek Poleruje wykonuje polerowanie lamp w Lublinie dla kierowców, którzy chcą poprawić wygląd auta i widoczność po zmroku bez wymiany reflektorów. Renowacja zmatowiałych kloszy pomaga usunąć żółty nalot, mleczne przebarwienia i drobne ślady zużycia, a na koniec lampy są zabezpieczane przed ponownym matowieniem. Jeśli nie wiesz, czy Twoje reflektory nadają się do odnowienia, wyślij zdjęcie auta i poproś o wycenę.';

$seo_intro_title = $seo_intro_enabled && !empty($seo_intro_title)
    ? $seo_intro_title
    : $default_title;

$seo_intro_text = $seo_intro_enabled && !empty($seo_intro_text)
    ? $seo_intro_text
    : $default_text;
?>

<section class="seo-intro" id="polerowanie-lamp-lublin">
    <div class="container seo-intro__inner">
        <?php if (!empty($seo_intro_title)) : ?>
            <h2 class="seo-intro__title">
                <?php echo esc_html($seo_intro_title); ?>
            </h2>
        <?php endif; ?>

        <div class="seo-intro__text">
            <?php echo wp_kses_post(wpautop($seo_intro_text)); ?>
        </div>
    </div>
</section>
