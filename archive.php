<?php get_header(); ?>

<main class="blog-archive">
    <div class="container">

        <header class="blog-archive__header">
            <h1 class="blog-archive__title">
                Blog
            </h1>
        </header>

        <div class="blog-archive__grid">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article class="post-card">

                <a href="<?php the_permalink(); ?>" class="post-card__image">
                    <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('medium_large', ['loading' => 'lazy', 'decoding' => 'async', 'sizes' => '(max-width: 768px) 100vw, 360px']); ?>
                    <?php endif; ?>
                </a>

                <div class="post-card__content">
                    <h2 class="post-card__title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <p class="post-card__excerpt">
                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                    </p>

                    <a href="<?php the_permalink(); ?>" class="post-card__link">
                        Czytaj więcej →
                    </a>
                </div>

            </article>

            <?php endwhile; endif; ?>

        </div>

    </div>
</main>

<?php get_footer(); ?>
