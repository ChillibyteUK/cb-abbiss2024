<?php
$section = get_field('section') ?? null;
$class = $block['className'] ?? 'pt-5';
?>
<section class="latest_insights <?=$class?>">
    <div class="container-xl">
        <h3 class="pt-2 border-top">
            Latest Abbiss Cadres news</h3>
        <div class="latest_insights__grid mb-4">
            <?php
$p = new WP_Query(
    array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 3,
        'tax_query' =>     array(
            array(
                'taxonomy' => 'section',
                'field' => 'slug',
                'terms' => array($section)
            )
        )
    )
);
while ($p->have_posts()) {
    $p->the_post();
    ?>
            <a href="<?=get_the_permalink()?>"
                class="news_insights_events__news_post bg-beige-400">
                <div class="overlay"></div>
                <div class="news_insights_events__content">
                    <div class="news_insights_events__meta">
                        <img src="<?=get_stylesheet_directory_uri()?>/img/icon-news.svg"
                            class="icon-sm" alt="News Icon">
                        <span
                            class="fs-200"><?=get_the_date()?></span>
                    </div>
                    <h3 class="fs-500"><?=get_the_title()?></h3>
                    <div>
                        <?= wp_strip_all_tags(wp_trim_words(get_the_content(), '20'));?>
                    </div>
                </div>
            </a>
            <?php
}
?>
        </div>
        <a class="link-arrow-inline" href="/knowledge/news/">View all news</a>
    </div>
</section>