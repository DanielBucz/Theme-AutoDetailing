<?php
$before = function_exists('get_field') ? get_field('before_image') : null;
$after  = function_exists('get_field') ? get_field('after_image') : null;
$desc   = function_exists('get_field') ? get_field('short_desc') : '';
?>

<article class="realization-card">
    <a class="realization-card__link" href="<?php the_permalink(); ?>">

        <div class="realization-card__images">
            <div class="realization-card__image">
                <?php if (!empty($before['url'])) : ?>
                <img src="<?php echo esc_url($before['url']); ?>" alt="Przed realizacją">
                <?php elseif (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large'); ?>
                <?php endif; ?>

                <span class="realization-card__badge realization-card__badge--before">
                    Przed
                </span>
            </div>

            <div class="realization-card__image">
                <?php if (!empty($after['url'])) : ?>
                <img src="<?php echo esc_url($after['url']); ?>" alt="Po realizacji">
                <?php elseif (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large'); ?>
                <?php endif; ?>

                <span class="realization-card__badge realization-card__badge--after">
                    Po
                </span>
            </div>
        </div>

        <div class="realization-card__content">
            <h2 class="realization-card__title"><?php the_title(); ?></h2>

            <?php if ($desc) : ?>
            <p class="realization-card__text">
                <?php echo esc_html($desc); ?>
            </p>
            <?php endif; ?>
        </div>

    </a>
</article>