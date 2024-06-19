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
                            data-bs-toggle="collapse" data-bs-target="#filterbox">Filters</button>
                    </div>
                </div>
                <div class="border-top border-bottom collapse" id="filterbox">
                    <form
                        action="<?=site_url()?>/wp-admin/admin-ajax.php"
                        method="post" id="newsfilter" class="py-4">
                        <input type="hidden" name="post_type" value="post">
                        <div class="row g-2 mb-3">
                            <div class="col-lg-6">
                                <div class="bg-grey-500 h-100 p-3 pt-4">
                                    <input type="text" name="keyword" id="keyword" placeholder="Title or topic"
                                        class="w-100">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="bg-grey-500 h-100 px-3 pb-2" style="padding-top:0.33rem">
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
                            <div class="col-lg-6">
                                <div class="bg-grey-500 h-100 p-3">
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
                            <div class="col-lg-6">
                                <div class="bg-grey-500 h-100 p-3">
                                    <?php
    $authors = get_all_authors();
echo '<select name="authorfilter" class="w-100"><option value="" selected>Author</option>';
foreach ($authors as $a) {
    if ($a['post_count'] < 1) {
        continue;
    }
    echo '<option value="' . $a['id'] . '">' . $a['name'] . '</option>'; // ID of the category as the value of an option
}
echo '</select>';
?>
                                </div>
                            </div>

                        </div>
                        <button class="button button-black button-sm me-4">Apply filters</button>
                        <button class="button button-grey button-sm reset" id="resetButton">Reset</button>
                        <input type="hidden" name="action" value="newsfilter">
                    </form>
                </div>
                <div id="response" class=" post container-xl">

                    <div class="small py-4 post__count">
                        <?=$wp_query->found_posts.' of '.$wp_query->found_posts.' posts'?>
                    </div>

                    <?php
                if (have_posts()) { ?>
                    <?php
                    while (have_posts()) {
                        the_post();
                        ?>
                    <a class="post__card"
                        href="<?=get_the_permalink()?>">
                        <div class="post__type">
                            <div class="post__icon bg-beige-400">
                                <img src="<?=get_stylesheet_directory_uri()?>/img/icon-news.svg"
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
add_action('wp_footer', function () {
    ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var newsFilter = document.getElementById('newsfilter');
        if (newsFilter) {
            newsFilter.addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(newsFilter);
                var xhr = new XMLHttpRequest();
                var actionUrl = newsFilter.getAttribute('action'); // Get the correct action attribute

                // console.log('Form action URL:', actionUrl); // Debugging statement

                xhr.open(newsFilter.getAttribute('method'), actionUrl, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            document.getElementById('response').innerHTML = xhr.responseText;
                            newsFilter.querySelector('button').textContent = 'Apply filter';
                        }
                    }
                };

                var urlEncodedData = '';
                formData.forEach((value, key) => {
                    if (urlEncodedData.length > 0) {
                        urlEncodedData += '&';
                    }
                    urlEncodedData += encodeURIComponent(key) + '=' + encodeURIComponent(value);
                });

                // console.log('Encoded form data:', urlEncodedData); // Debugging statement

                xhr.send(urlEncodedData);
                newsFilter.querySelector('button').textContent = 'Processing...';
            });
        }

        var filterButtons = document.querySelectorAll('.filter');
        filterButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var filterBox = document.getElementById('filterbox');
                if (filterBox) {
                    filterBox.classList.remove('show');
                }
                var xhr = new XMLHttpRequest();
                xhr.open('POST',
                    "<?php echo site_url() ?>/wp-admin/admin-ajax.php",
                    true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            document.getElementById('response').innerHTML = xhr
                                .responseText;
                        }
                    }
                };
                xhr.send('action=catfilter&catid=' + encodeURIComponent(button.value));
            });
        });

        function toggleIcon(e) {
            var filterToggle = document.querySelector('.filtertoggle');
            if (filterToggle) {
                filterToggle.classList.toggle('closed');
                filterToggle.classList.toggle('open');
            }
        }

        var filterBox = document.getElementById('filterbox');
        if (filterBox) {
            filterBox.addEventListener('hidden.bs.collapse', toggleIcon);
            filterBox.addEventListener('shown.bs.collapse', toggleIcon);
        }

        var resetButton = document.getElementById('resetButton');
        if (resetButton) {
            resetButton.addEventListener('click', function() {
                newsFilter.reset(); // Reset the form fields

                event.preventDefault();
                var formData = new FormData(newsFilter);
                var xhr = new XMLHttpRequest();
                var actionUrl = newsFilter.getAttribute('action'); // Get the correct action attribute

                // console.log('Form action URL:', actionUrl); // Debugging statement

                xhr.open(newsFilter.getAttribute('method'), actionUrl, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            document.getElementById('response').innerHTML = xhr.responseText;
                            newsFilter.querySelector('button').textContent = 'Apply filter';
                        }
                    }
                };

                var urlEncodedData = '';
                formData.forEach((value, key) => {
                    if (urlEncodedData.length > 0) {
                        urlEncodedData += '&';
                    }
                    urlEncodedData += encodeURIComponent(key) + '=' + encodeURIComponent(value);
                });

                // console.log('Encoded form data:', urlEncodedData); // Debugging statement

                xhr.send(urlEncodedData);

                // document.getElementById('response').innerHTML = ''; // Clear the response area
            });
        }
    });
</script>
<?php
}, 9999);

get_footer();
?>