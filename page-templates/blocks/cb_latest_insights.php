<?php
$section = get_field('section') ?? null;
$topic = get_field('topic') ?? null;

$class = $block['className'] ?? 'pb-5';

$title = 'Latest insights';

$tax_query = array(
    array(
        'taxonomy' => 'section',
        'field' => 'slug',
        'terms' => array($section)
    )
);

if (is_array($topic) && !empty($topic)) {
    $tax_query[] = array(
        'taxonomy' => 'category',
        'field' => 'term_id',
        'terms' => $topic
    );
    $title = 'Related insights';
}

$p = new WP_Query(
    array(
        'post_type' => 'insights',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'tax_query' => $tax_query
    )
);

?>
<section class="latest_insights <?=$class?>">
    <div class="container-xl">
        <h2 class="h3 pt-2 border-top">
            <?=$title?></h3>
            <div class="latest_insights__grid mb-4">
                <?php

while ($p->have_posts()) {
    $p->the_post();
    ?>
                <a href="<?=get_the_permalink()?>"
                    class="news_insights_events__news_post bg-blue-400">
                    <div class="overlay"></div>
                    <div class="news_insights_events__content news_insights_events__content--noimage">
                        <div class="news_insights_events__meta">
                            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-insights.svg"
                                class="icon-sm" alt="Insights Icon">
                            <span
                                class="fs-200"><?=get_the_date()?></span>
                        </div>
                        <h3 class="fs-500"><?=get_the_title()?>
                        </h3>
                        <div class="news_insights_events__excerpt">
                            <?= wp_strip_all_tags(wp_trim_words(get_the_content(), '20'));?>
                        </div>
                    </div>
                </a>
                <?php
}
?>
            </div>
            <?php
        if ($section == 'corridor') {
            echo '<a class="link-arrow-inline" href="/corridor/knowledge/insights/">View all Corridor insights</a>';
        } else {
            echo '<a class="link-arrow-inline" href="/knowledge/insights/">View all insights</a>';
        }
?>
    </div>
</section>