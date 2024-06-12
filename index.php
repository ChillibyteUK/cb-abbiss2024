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

$container = 'container';

// the_post();
// $imageID = get_field('hero_image');
// $imageURL = wp_get_attachment_image_src($imageID, 'full');
$imageURL = '/wp-content/uploads/2020/11/knowledge-hub.jpg';

// $overlay = get_field('hero_overlay');
$overlay = '
<div class="text-center">
    <img src="' . get_stylesheet_directory_uri(__FILE__) . '/img/icon-knowledge-hub.svg" class="icon-large">
    <div class="row pt-4">
        <div class="col-12">
            <div class="h2">Knowledge Hub</div>
        </div>
    </div>
</div>';

?>
<section class="section-wrap">
    <div id="single-wrapper">
        <?php
    if ($imageURL) {
        ?>
        <div class="page-hero"
            style="background-image:url(<?php echo $imageURL; ?>)">
            <div class="hero-content <?=$container?>">
                <?=$overlay?>
            </div>
        </div>
        <?php
    }
?>
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
                        <?=subscribe_cta_sm()?>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9 content-area" id="primary">
                    <main class="site-main" id="main" role="main">
                        <div class="pt-4 mt-4 pb-4">
                            <?=get_field('knowledge_hub_intro', 'options')?>
                        </div>
                        <div class="border-top border-bottom py-4 d-flex justify-content-between">
                            <form id="catfilter d-inline">
                                <?php
                $uk_news = get_category_by_slug('uk-news');
$int_news = get_category_by_slug('international-assignments');
$ac_news = get_category_by_slug('abbiss-cadres-news');
?>
                                <button class="ac-btn-text filter"
                                    value="<?=$uk_news->term_id?>">UK
                                    News</button>
                                <button class="ac-btn-text filter"
                                    value="<?=$int_news->term_id?>">International
                                    News</button>
                                <button class="ac-btn-text filter"
                                    value="<?=$ac_news->term_id?>">Abbiss
                                    Cadres News</button>

                            </form>
                            <div>
                                <button class="ac-btn-text text-right filtertoggle closed" type="button"
                                    data-toggle="collapse" data-target="#filterbox">Filters</button>
                            </div>
                        </div>
                        <div class="border-top border-bottom py-4 collapse" id="filterbox">
                            <form
                                action="<?php echo site_url() ?>/wp-admin/admin-ajax.php"
                                method="POST" id="newsfilter">
                                <input type="hidden" name="post_type" value="post">
                                <div class="row">
                                    <div class="col-lg-6 mb-2">
                                        <div class="bg-light-grey h-100 p-4">
                                            <input type="text" name="keyword" id="keyword" placeholder="Title or topic"
                                                class="w-100">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <div class="bg-light-grey h-100 px-3 pb-3 pt-1">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="small">Date from</div>
                                                    <select name="datefrommonth">
                                                        <?=option_months()?>
                                                    </select>
                                                    <select name="datefromyear">
                                                        <?php
                        $oldest = oldest_post();
$year = date('Y');
for ($y = $oldest; $y <= $year; $y++) {
    echo '<option value="' . $y . '">' . $y . '</option>';
}
?>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <div class="small">Date to</div>
                                                    <select name="datetomonth">
                                                        <?=option_months(1)?>
                                                    </select>
                                                    <select name="datetoyear">
                                                        <?php
$oldest = oldest_post();
$year = date('Y');
for ($y = $oldest; $y <= $year; $y++) {
    $selected = ($y == $year) ? 'selected' : '';
    echo '<option value="' . $y . '" ' . $selected . '>' . $y . '</option>';
}
?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <div class="bg-light-grey h-100 p-4">
                                            <?php
                                        if ($terms = get_terms(array( 'taxonomy' => 'category', 'orderby' => 'name' ))) :
                                
                                            echo '<select name="categoryfilter" class="w-100"><option value="" selected>Service category</option>';
                                            foreach ($terms as $term) :
                                                echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; // ID of the category as the value of an option
                                            endforeach;
                                            echo '</select>';
                                        endif;
?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <div class="bg-light-grey h-100 p-4">
                                            <?php
    $authors = get_all_authors();
echo '<select name="authorfilter" class="w-100"><option value="" selected>Author</option>';
foreach ($authors as $a) {
    echo '<option value="' . $a['id'] . '">' . $a['name'] . '</option>'; // ID of the category as the value of an option
}
echo '</select>';
?>
                                        </div>
                                    </div>

                                </div>
                                <button class="ac-btn-dk">Apply filters</button>
                                <input type="hidden" name="action" value="newsfilter">
                            </form>
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
                                        href="<?=get_permalink()?>"><?=icon_news()?></a>
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

                        <?=celia_cta()?>
                </div><!-- .row -->
            </div><!-- #content -->

        </div><!-- .section-wrap -->

        <?php
add_action('wp_footer', function () {
    ?>
        <script>
            jQuery(function($) {
                $('#newsfilter').submit(function() {
                    var filter = $('#newsfilter');
                    $.ajax({
                        url: filter.attr('action'),
                        data: filter.serialize(), // form data
                        type: filter.attr('method'), // POST
                        beforeSend: function(xhr) {
                            filter.find('button').text(
                            'Processing...'); // changing the button label
                        },
                        success: function(data) {
                            filter.find('button').text(
                            'Apply filter'); // changing the button label back
                            $('#response').html(data); // insert data
                        }
                    });
                    return false;
                });
            });
            jQuery(function($) {
                $('.filter').click(function(e) {
                    e.preventDefault();
                    $('#filterbox').collapse('hide');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url() ?>/wp-admin/admin-ajax.php",
                        data: {
                            action: 'catfilter',
                            catid: $(this).val(),
                        },
                        success: function(data) {
                            $('#response').html(data); // insert data
                        }
                    });
                    return false;
                });
            });

            function toggleIcon(e) {
                jQuery(e.target)
                jQuery(".filtertoggle")
                    .toggleClass('closed open');
            }
            jQuery('#filterbox').on('hidden.bs.collapse', toggleIcon);
            jQuery('#filterbox').on('shown.bs.collapse', toggleIcon);
        </script>
        <?php
});

get_footer();
?>