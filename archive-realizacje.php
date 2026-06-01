<?php get_header(); ?>

<main class="realizations-archive">
    <div class="container">

        <header class="realizations-archive__header">
            <p class="realizations-archive__eyebrow">Portfolio</p>
            <h1 class="realizations-archive__title">Wszystkie realizacje</h1>
            <p class="realizations-archive__text">
                Zobacz efekty mojej pracy: renowacja lamp, polerowanie i detailing.
            </p>
        </header>

        <?php if (have_posts()) : ?>
        <div class="realizations-archive__grid">
            <?php while (have_posts()) : the_post(); ?>
            <?php get_template_part('template-parts/components/realization-card'); ?>
            <?php endwhile; ?>
        </div>
        <?php else : ?>
        <div class="realizations-archive__empty">
            <p>Na ten moment nie ma jeszcze dodanych realizacji.</p>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php get_footer(); ?>