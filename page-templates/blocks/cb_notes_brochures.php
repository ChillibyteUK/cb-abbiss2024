<?php
$class = $block['className'] ?? 'pb-5';

$section = get_field('section');
$tax_query = array(
    array(
        'taxonomy' => 'section',
        'field' => 'slug',
        'terms' => array($section)
    )
);

$bn = new WP_Query(
    array(
        'post_type' => 'briefing_notes',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'tax_query' => $tax_query
    )
);

$br = new WP_Query(
    array(
        'post_type' => 'brochures',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'tax_query' => $tax_query
    )
);

?>
<section class="notes_brochures <?=$class?>">
    <div class="container-xl notes_brochures__grid">
        <?php
        if ($bn->have_posts()) {
            $bn->the_post();
            $pdf = get_field('pdf_file', get_the_ID());
            $url = $pdf['url'];
            $filename = $pdf['filename'];
            ?>
        <div class="notes_brochures__col">
            <h3>Briefing Notes</h3>
            <a class="notes_brochures__card" href="<?=$url?>" download="<?=$filename?>">
                <div class="overlay"></div>
                <div class="notes_brochures__title"><?=get_the_title()?></div>
                <div class="notes_brochures__date"><?=get_the_date()?></div>
            </a>
            <?php
            if ($section == 'corridor') {
                echo '<div class="link-arrow-inline"><a href="/corridor/knowledge/insights/">View all Corridor insights</a></div>';
            }
            else {
                echo '<div class="link-arrow-inline"><a href="/knowledge/insights/">View all insights</a></div>';
            }
            ?>
        </div>
            <?php
        }
        if ($br->have_posts()) {
            $br->the_post();
            $pdf = get_field('pdf_file', get_the_ID());
            $url = $pdf['url'];
            $filename = $pdf['filename'];
            ?>
        <div class="notes_brochures__col">
            <h3>Brochures</h3>
            <a class="notes_brochures__card" href="<?=$url?>" download="<?=$filename?>">
                <div class="overlay"></div>
                <div class="notes_brochures__title"><?=get_the_title()?></div>
                <div class="notes_brochures__date"><?=get_the_date()?></div>
            </a>
            <?php
            if ($section == 'corridor') {
                echo '<div class="link-arrow-inline"><a href="/corridor/knowledge/brochures/">View all Corridor brochures</a></div>';
            }
            else {
                echo '<div class="link-arrow-inline"><a href="/knowledge/brochures/">View all brochures</a></div>';
            }
            ?>
        </div>
            <?php
        }
        ?>
    </div>
</section>