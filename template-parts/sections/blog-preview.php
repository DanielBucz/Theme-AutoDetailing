<?php
$query = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 3,
]);
?>

<section class="blog-preview" id="blog">
    <div class="container">

        <div class="blog-preview__header">
            <p class="blog-preview__eyebrow">Porady</p>

            <h2 class="blog-preview__title">
                Porady o lampach
            </h2>

            <p class="blog-preview__text">
                Sprawdź, kiedy warto polerować reflektory, jak dbać o klosze i dlaczego zabezpieczenie UV ma znaczenie.
            </p>
        </div>

        <div class="blog-preview__grid">

            <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>

            <article class="post-card">

                <a href="<?php the_permalink(); ?>" class="post-card__image">
                    <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('medium_large', ['loading' => 'lazy', 'decoding' => 'async', 'sizes' => '(max-width: 768px) 100vw, 360px']); ?>
                    <?php endif; ?>
                </a>

                <div class="post-card__content">
                    <h3 class="post-card__title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>

                    <p class="post-card__excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 16); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>" class="post-card__link">
                        Czytaj więcej
                    </a>
                </div>

            </article>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
            <?php endif; ?>

        </div>

    </div>
</section>
