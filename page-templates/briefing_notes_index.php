<?php
/**
 * Template Name: Briefing Notes Index
 *
 * @package cb-abbiss2024
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$page = get_page_by_path('knowledge');
$content = $page->post_content;
$blocks = parse_blocks($content);
$background_value = '';
foreach ($blocks as $block) {
    if ($block['blockName'] === 'acf/cb-hero') {
        // Get the background field value
        if (isset($block['attrs']['data']['background'])) {
            $background_value = $block['attrs']['data']['background'];
        }
        break;
    }
}
?>
<main>
    <section class="hero page-hero mb-4">
        <?=wp_get_attachment_image($background_value, 'full', false, array('class' => 'hero__bg', 'alt' => 'Knowledge'))?>
        <div class="container-xl hero__inner">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-insights--wo.svg"
                class="hero__icon" alt="<?=get_the_title()?>">
            <h1 class="hero__content">
                <?=get_the_title()?>
            </h1>
        </div>
    </section>
    <section class="breadcrumbs mb-4">
        <div class="container-xl">
            <?php
        if (function_exists('yoast_breadcrumb')) {
            // yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
            yoast_breadcrumb();
        }
?>
        </div>
    </section>
    <div class="container-xl">
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="sidebar_menu">
                    <?php

if (strpos($_SERVER['REQUEST_URI'], '/corridor/') !== false) {
    $menu_id = 'Corridor Knowledge Hub';
    $intro = get_field('corridor_knowledge_hub_intro', 'options');
    $section = 'corridor';
} else {
    $menu_id = 'Knowledge Hub';
    $intro = get_field('knowledge_hub_intro', 'options');
    $section = 'for-businesses';
}

$menu = wp_get_nav_menu_object($menu_id);

if ($menu_id) {
    if (stripos($menu->name, 'corridor') !== false) {
        ?>
                    <img src="<?=get_stylesheet_directory_uri()?>/img/icon-corridor-full.svg"
                        class="w-75 mb-4" alt="CORRIDOR">
                    <?php
    } else {
        ?>
                    <div class="h3"><?=$menu->name?></div>
                    <?php
    }
    wp_nav_menu(array('menu' => $menu));
}
?>
                </div>
            </div>
            <div class=" col-md-9">
                <?=$intro?>
                <?php
                $q = new WP_Query(
                    array(
                        'post_type' => 'briefing_notes',
                        'posts_per_page' => -1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'section',
                                'field' => 'slug',
                                'terms' => array($section)
                            )
                        )
                    )
                );
?>
                <div class="small pb-4 post__count">
                    <?=$q->found_posts.' briefing notes'?>
                </div>
                <div id="response" class=" note container-xl">

                    <?php
if ($q->have_posts()) { ?>
                    <?php
    while ($q->have_posts()) {
        $q->the_post();
        $pdf = get_field('pdf_file');
        // $url = $pdf['url'];
        $url = get_the_permalink();
        $filename = $pdf['filename'];
        ?>
                    <a class="note__card" href="<?=$url?>">
                        <div class="overlay"></div>
                        <div class="note__title">
                            <?=get_the_title()?>
                        </div>
                        <div class="note__img">
                            <?=wp_get_attachment_image($pdf['ID'], array(140,200), false, array('class' => 'note__thumb'))?>
                        </div>
                    </a>
                    <?php
    }
    ?>
                    <?php
}
?>
                    <div class="pt-4">
                        <?=understrap_pagination()?>
                    </div>
                </div>
            </div>
        </div>
        <section class="colour_cta mb-5">
            <div class="container-xl">
                <a href="https://www.celiaalliance.com/" target="_blank"
                    class="colour_cta__card bg-blue-500 text-white">
                    <div class="overlay"></div>
                    <div class="colour_cta__inner">
                        <h2>
                            Find out more about our international network
                        </h2>
                        <div>Visit the CELIA Alliance website
                        </div>
                    </div>
                </a>
            </div>
        </section>
    </div>
</main>
<?php

get_footer();
?>