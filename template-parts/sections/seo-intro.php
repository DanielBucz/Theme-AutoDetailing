<?php
$seo_intro_enabled = function_exists('get_field') ? get_field('seo_intro_enabled') : false;
$seo_intro_title = function_exists('get_field') ? get_field('seo_intro_title') : '';
$seo_intro_text = function_exists('get_field') ? get_field('seo_intro_text') : '';

if (!$seo_intro_enabled || empty($seo_intro_text)) {
    return;
}
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
