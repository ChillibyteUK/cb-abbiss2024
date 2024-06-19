<?php
/**
 * The main template file
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
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-news--wo.svg"
                class="hero__icon" alt="<?=get_the_title()?>">
            <h1 class="hero__content">
                News
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
        <div class="row">
            <div class="col-md-3">
                <div class="sidebar_menu">
                    <?php
        $menu_id = 'Knowledge Hub';
$menu = wp_get_nav_menu_object($menu_id);

if ($menu_id) {
    if ($menu->name === 'CORRIDOR') {
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
                <?=get_field('knowledge_hub_intro', 'options')?>
                <div id="response" class="container">

                    <div class="small pt-4 pb-2">
                        <?=$wp_query->found_posts.' of '.$wp_query->found_posts.' posts'?>
                    </div>

                    <?php
                if (have_posts()) { ?>
                    <?php
                    while (have_posts()) {
                        the_post();
                        ?>
                    <div class="row border-bottom">
                        <div class="col-1 my-4 news-indicator">
                            <a href="<?=get_permalink()?>"></a>
                        </div>
                        <div class="col-11 my-4">
                            <div class="small">
                                <?=get_the_date()?>
                            </div>
                            <div class="font-weight-bold py-2"><a
                                    href="<?=get_permalink()?>"><?=get_the_title()?></a>
                            </div>
                            <div>
                                <?=wp_trim_words(get_the_content(), 30)?>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <?php
                } else {
                    ?>
                    <?php get_template_part('loop-templates/content', 'none'); ?>
                    <?php
                }
?>
                    <div class="pt-4">
                        <?=understrap_pagination()?>
                    </div>
                </div>
            </div><!-- .row -->
        </div><!-- #content -->

    </div><!-- .section-wrap -->
</main>
<?php

get_footer();
?>