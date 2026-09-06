<?php get_header(); ?>

<main class="single-post">
    <div class="container">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <article class="single-post__article">

            <header class="single-post__header">
                <h1 class="single-post__title">
                    <?php the_title(); ?>
                </h1>

                <p class="single-post__meta">
                    <?php echo get_the_date(); ?>
                </p>
            </header>

            <?php if (has_post_thumbnail()) : ?>
            <div class="single-post__image">
                <?php the_post_thumbnail('large', ['loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async', 'sizes' => '(max-width: 768px) 100vw, 960px']); ?>
            </div>
            <?php endif; ?>

            <div class="single-post__content">
                <?php the_content(); ?>
            </div>

        </article>

        <?php endwhile; endif; ?>

    </div>
</main>

<?php get_footer(); ?>
