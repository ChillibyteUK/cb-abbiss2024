<?php
$section = get_field('section') ?? null;
?>
<section class="latest_insights pb-5">
    <div class="container-xl">
        <h3 class="pt-2 border-top">
            Latest insights</h3>
        <?php
$p = new WP_Query(
    array(
        'post_type' => 'insights',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'tax_query' =>     array(
            'taxonomy' => 'section',
            'field' => 'slug',
            'terms' => array($section)
        )
    )
);
while ($p->have_posts()) {
    $p->the_post();
    echo get_the_title();
}
?>
    </div>
</section>