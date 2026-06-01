<?php
$testimonials = [
    [
        'name' => 'Klient z Lublina',
        'text' => 'Super efekt i bardzo dobry kontakt. Lampa po renowacji wygląda jak nowa.',
    ],
    [
        'name' => 'Właściciel BMW',
        'text' => 'Auto odzyskało świeżość, a wnętrze po praniu wyglądało dużo lepiej niż się spodziewałem.',
    ],
    [
        'name' => 'Stały klient',
        'text' => 'Dokładna robota i bez ściemy. Na pewno wrócę z kolejnym autem.',
    ],
];
?>

<section class="testimonials" id="opinie">
    <div class="container">
        <div class="testimonials__header">
            <p class="testimonials__eyebrow">Opinie</p>
            <h2 class="testimonials__title">Dlaczego klienci wracają</h2>
            <p class="testimonials__text">
                Liczy się efekt, kontakt i dbałość o detale. Właśnie na tym opiera się Buczek Poleruje.
            </p>
        </div>

        <div class="testimonials__grid">
            <?php foreach ($testimonials as $testimonial) : ?>
            <article class="testimonial-card">
                <div class="testimonial-card__stars">★★★★★</div>

                <p class="testimonial-card__text">
                    “<?php echo esc_html($testimonial['text']); ?>”
                </p>

                <p class="testimonial-card__name">
                    <?php echo esc_html($testimonial['name']); ?>
                </p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- <?php
// Wywołanie zoptymalizowanego tagu szablonu z cache
$opinie_query = buczek_get_cached_opinie();

if ($opinie_query->have_posts()) : ?>
<section class="testimonials-section">
    <div class="container">
        <div class="testimonials-slider">
            <?php while ($opinie_query->have_posts()) : $opinie_query->the_post(); ?>
            <div class="testimonial-item">
                <h3><?php the_title(); ?></h3>
                <div class="testimonial-content">
                    <?php the_content(); ?>
                </div>
                <?php 
                        // Przykład pobierania pola ACF (np. ocena)
                        $rating = get_field('ocena_gwiazdkowa'); 
                        if ($rating) : ?>
                <div class="stars"><?php echo str_repeat('★', intval($rating)); ?></div>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php 
    wp_reset_postdata(); // Bezwarunkowy reset globalnego obiektu $post
endif; 
?> -->