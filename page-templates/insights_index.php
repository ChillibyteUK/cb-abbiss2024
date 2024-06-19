<?php
/**
 * Template Name: Insights Index
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
                <div id="response" class=" post container-xl">
                    <?php
                                    $q = new WP_Query(
                                        array(
                                                                                                                                                                                                                                                                                                                'post_type' => 'insights',
                                                                                                                                                                                                                                                                                                                'posts_per_page' => -1,
                                                                                                                                                                                                                                                                                                            )
                                    );
?>
                    <div class="small pb-4 post__count">
                        <?=$q->found_posts.' insights'?>
                    </div>

                    <?php
if ($q->have_posts()) { ?>
                    <?php
    while ($q->have_posts()) {
        $q->the_post();
        ?>
                    <a class="post__card"
                        href="<?=get_the_permalink()?>">
                        <div class="post__type">
                            <div class="post__icon bg-blue-400">
                                <img src="<?=get_stylesheet_directory_uri()?>/img/icon-insights.svg"
                                    alt="">
                            </div>
                        </div>
                        <div class="post__detail">
                            <div class="small">
                                <?=get_the_date()?>
                            </div>
                            <div class="font-weight-bold py-2">
                                <?=get_the_title()?>
                            </div>
                            <div>
                                <?=wp_trim_words(get_the_content(), 30)?>
                            </div>
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