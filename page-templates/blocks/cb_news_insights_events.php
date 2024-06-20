<?php
$section = get_field('section') ?? null;
?>
<section class="news_insights_events pb-5">
    <div class="container-xl">
        <div class="news_insights_events__grid">
            <div class="news_insights_events__news">
                <h2 class="h3 overline-title">News</h3>
                    <?php
$p = new WP_Query(
    array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
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
                            <h3 class="fs-500"><?=get_the_title()?>
                            </h3>
                            <div>
                                <?= wp_strip_all_tags(wp_trim_words(get_the_content(), '20'));?>
                            </div>
                        </div>
                        <?=get_the_post_thumbnail(get_the_ID(), 'large', array('class' => 'news_insights_events__image'))?>
                    </a>
                    <?php
}


if ($section == 'corridor') {
    echo '<a class="link-arrow-inline" href="/corridor/knowledge/news/">View all Corridor news</a>';
} else {
    echo '<a class="link-arrow-inline" href="/knowledge/news/">View all news</a>';
}
?>
            </div>
            <div class="news_insights_events__insights">
                <h2 class="h3 overline-title">Insights</h3>
                    <?php
                $p = new WP_Query(
                    array(
'post_type' => 'insights',
'post_status' => 'publish',
'posts_per_page' => 2,
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
                        class="news_insights_events__news_post bg-blue-400">
                        <div class="overlay"></div>
                        <div class="news_insights_events__content">
                            <div class="news_insights_events__meta">
                                <img src="<?=get_stylesheet_directory_uri()?>/img/icon-insights.svg"
                                    class="icon-sm" alt="Insights Icon">
                                <span
                                    class="fs-200"><?=get_the_date()?></span>
                            </div>
                            <h3 class="fs-500"><?=get_the_title()?>
                            </h3>
                            <div>
                                <?= wp_strip_all_tags(wp_trim_words(get_the_content(), '20'));?>
                            </div>
                        </div>
                    </a>
                    <?php
}
if ($section == 'corridor') {
    echo '<a class="link-arrow-inline" href="/corridor/knowledge/insights/">View all Corridor insights</a>';
} else {
    echo '<a class="link-arrow-inline" href="/knowledge/insights/">View all insights</a>';
}
?>
            </div>
        </div>
    </div>
</section>