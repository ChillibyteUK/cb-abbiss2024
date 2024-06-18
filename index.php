<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
<section
    class="hero <?=$page?> <?=$class?>">
    <?=wp_get_attachment_image($background_value, 'full', false, array('class' => 'hero__bg', 'alt' => 'Knowledge'))?>
    <div class="container-xl hero__inner">
        <img src="<?=get_stylesheet_directory_uri()?>/img/icon-news.svg"
            class="hero__icon" alt="<?=get_the_title()?>">
        <?php
if (get_field('content') ?? null) {
    ?>
        <h1 class="hero__content">
            <?=get_field('content')?>
        </h1>
        <?php
}
?>
    </div>
</section>
<?php

?><div>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;<br>&nbsp;</div><?php

echo 'BG: ' .  $background_value;

?>
<section class="section-wrap">
    <div id="single-wrapper">
        <div class="container" id="content">

            <div class="row">
                <div class="col-lg-8 offset-lg-4 col-xl-9 offset-xl-3">
                    <?php
                if (function_exists('yoast_breadcrumb')) {
                    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                }
?>
                </div>
            </div>
            <div class="row">
                <div class="d-none d-lg-block col-lg-4 col-xl-3 py-5" id="left-sidebar" role="complementary">
                    <div class="sticky-top sticky-offset">
                        <div class="nav-title"><a href="/knowledge/">Knowledge Hub</a></div>
                        <ul class="top-page">
                            <li><a href="/knowledge/news/" class="active">News</a></li>
                            <li><a href="/knowledge/insights/">Insights</a></li>
                            <li><a href="/knowledge/briefing-notes/">Briefing Notes</a></li>
                            <li><a href="/knowledge/brochures/">Brochures</a></li>
                            <!-- <li><a href="/knowledge/events/">Events</a></li> -->
                            <!-- <li><a href="/knowledge/useful-links/">Useful Links</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9 content-area" id="primary">
                    <main class="site-main" id="main" role="main">
                        <div class="pt-4 mt-4 pb-4">
                            <?=get_field('knowledge_hub_intro', 'options')?>
                        </div>
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
                                    <a
                                        href="<?=get_permalink()?>"></a>
                                </div>
                                <div class="col-11 my-4">
                                    <div class="small">
                                        <?=get_the_date()?></div>
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

<?php

get_footer();
?>