<?php
$section = get_field('section');
?>
<section class="news_insights_events py-5">
    <div class="container-xl">
        <div class="news_insights_events__grid">
            <div class="news_insights_events__news">
                <h3 class="overline-title">News</h3>
                <?php
$p = new WP_Query(
    array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'tax_query' =>     array(
            'taxonomy' => 'section',
            'field' => 'slug',
            'terms' => array($section)
        )
    )
);

while ($p->have_posts()) {
    $p->the_post();
    ?>
                <div class="news_insights_events__news_post">
                    <img src="<?=get_stylesheet_directory_uri()?>/img/icon-news.svg"
                        class="icon-sm">
                    <?=get_the_date()?>

                </div>
                <?php
    echo get_the_title();
    ?>
                <div>
                    <?= wp_strip_all_tags(wp_trim_words(get_the_content(), '20'));?>
                </div>
                <?php
}


if ($section == 'corridor') {
    echo '<div class="link-arrow-inline"><a href="/corridor/knowledge/news/">View all Corridor news</a></div>';
} else {
    echo '<div class="link-arrow-inline"><a href="/knowledge/news/">View all news</a></div>';
}
?>
            </div>
            <div class="news_insights_events__insights">
                <h3 class="overline-title">Insights</h3>
                TWO
            </div>
        </div>
    </div>
</section>