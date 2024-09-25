<?php
/**
 * The template for displaying single people
 *
 * @package cb-abbiss2024
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>
<main class="single_people">
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
    <section class="single_people__hero">
        <div class="container-xl">
            <div class="row">
                <div class="d-none d-lg-block col-lg-4 col-xl-3 p-4 my-auto">
                    <img src="<?=get_stylesheet_directory_uri()?>/img/icon-person.svg"
                        class="icon-small">
                </div>
                <div class="col-lg-8 col-xl-9 my-auto">
                    <h1 class="h2"><?=get_the_title()?></h1>
                    <div class="h3">
                        <?=get_field('title')?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container-xl">
        <div class="row">
            <div class="d-none d-lg-block col-lg-3">
                <div class="sidebar_menu">
                    <?php
$menu_id = 35;
$menu = wp_get_nav_menu_object($menu_id);
if ($menu_id) {
    ?>
                    <div class="h3"><?=$menu->name?></div>
                    <?php
    wp_nav_menu(array('menu' => $menu_id));
}
?>
                </div>
            </div>
            <div class=" col-lg-9">
                <div class="single_people__summary mb-5">
                    <?=get_the_post_thumbnail(get_the_ID(), 'full', array('class' => 'single_people__image', 'alt' => get_the_title()))?>
                    <div class="single_people__links">
                        <?php
                    $contact = get_field('contact_details');
if ($contact['linkedin_url'] ?? null) {
    ?>
                        <a href="<?=$contact['linkedin_url']?>"
                            target="_blank"><span class="fa-stack fa-2x"><i
                                    class="fa fa-circle fa-stack-2x text-white"></i><i
                                    class="fa-brands fa-linkedin-in fa-stack-1x"></i></span></a>
                        <?php
}
if ($contact['twitter_url'] ?? null) {
    ?>
                        <a href="<?=$contact['twitter_url']?>"
                            target="_blank"><span class="fa-stack fa-2x"><i
                                    class="fa fa-circle fa-stack-2x text-white"></i><i
                                    class="fa-brands fa-x-twitter fa-stack-1x"></i></span></a>
                        <?php
}
if ($contact['message'] ?? null) {
    ?>
                        <span type="button" data-bs-toggle="modal" data-bs-target="#modal"><span
                                class="fa-stack fa-2x"><i class="fa fa-circle fa-stack-2x text-white"></i><i
                                    class="fa-regular fa-envelope-open fa-stack-1x"></i></span></span>
                        <?php
}
?>
                    </div>
                    <div class="single_people__specialisms">
                        <?php
                    if (have_rows('specialisms')) {
                        ?>
                        <ul class="single_people__list">
                            <?php
                        while (have_rows('specialisms')) {
                            the_row(); ?>
                            <li><?=get_sub_field('specialism')?>
                            </li>
                            <?php
                        }
                    }
?>
                    </div>
                    <div class="single_people__contact">
                        <?php
if ($contact['direct_dial_phone'] ?? null) {
    ?>
                        <div><span>D:</span>
                            <a
                                href="tel:<?=parse_phone($contact['direct_dial_phone'])?>"><?=$contact['direct_dial_phone']?></a>
                        </div>
                        <?php
}
if ($contact['switchboard'] ?? null) {
    ?>
                        <div><span>T:</span>
                            <a
                                href="tel:<?=parse_phone($contact['switchboard'])?>"><?=$contact['switchboard']?></a>
                        </div>
                        <?php
}
if ($contact['fax_number'] ?? null) {
    ?>
                        <div><span>F:</span>
                            <?=$contact['fax_number']?>
                        </div>
                        <?php
}
?>
                    </div>
                </div>

                <?=get_field('biography')?>

                <?php
if (get_field('user_id') != '') {
    $authors_posts = get_posts(array(  'post_type' => array('post','insights'), 'author' => get_field('user_id'), 'posts_per_page' => 3 ));
    if ($authors_posts) {
        ?>
                <section class="latest_insights pt-5">
                    <h3 class="pt-2 border-top">
                        Articles by <?=get_the_title()?></h3>
                    <div class="latest_insights__grid mb-4">
                        <?php
        foreach ($authors_posts as $authors_post) {
            if ($authors_post->post_type == 'post') {
                $icon = 'icon-news.svg';
                $bg = 'bg-beige-400';
                $post_type = 'news';
            }
            if ($authors_post->post_type == 'insights') {
                $icon = 'icon-insights.svg';
                $bg = 'bg-blue-400';
                $post_type = 'insights';
            }
            ?>
                        <a href="<?=get_the_permalink($authors_post->ID)?>"
                            class="news_insights_events__news_post <?=$bg?>">
                            <div class="overlay"></div>
                            <div class="news_insights_events__content">
                                <div class="news_insights_events__meta">
                                    <img src="<?=get_stylesheet_directory_uri()?>/img/<?=$icon?>"
                                        class="icon-sm" alt="News">
                                    <span
                                        class="fs-200"><?=get_the_date('', $authors_post->ID)?></span>
                                </div>
                                <h3 class="fs-500">
                                    <?=get_the_title($authors_post->ID)?>
                                </h3>
                            </div>
                        </a>
                        <?php
        } ?>
                    </div>
                </section>
                <?php
    }
}
?>

                <?php
        get_template_part('page-templates/blocks/cb_subscribe_cta');
?>


            </div>
        </div>
    </div>
</main>
<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Person",
        "image": "<?=$image?>",
        "sameAs": "<?=$contact['linkedin_url']?>",
        "address": {
            "@type": "PostalAddress",
            "mainEntityOfPage": "https://abbisscadres.com/contact-us/",
            "email": "info@abbisscadres.com",
            "telephone": "+442030515711",
            "addressCountry": "GB",
            "addressLocality": "London",
            "addressRegion": "",
            "postalCode": "EC2N 2HE",
            "streetAddress": "4th Floor (South), 14 Austin Friars"
        },
        "email": "<?=$contact['email_address']?>",
        <?php
$n = explode(' ', get_the_title());
?>
        "familyName": "<?=$n[1]?>",
        "givenName": "<?=$n[0]?>",
        "jobTitle": "<?=get_field('title')?>",
        "telephone": "<?=$contact['direct_dial_phone']?>",
        "worksFor": {
            "@type": "Organization",
            "name": "Abbiss Cadres LLP",
            "mainEntityOfPage": "https://abbisscadres.com/",
            "areaServed": ["London"],
            "logo": "https://abbisscadres.com/wp-content/themes/abbiss/img/abbiss-cadres-logo.svg"
        }
    }
</script>
<?php
if ($contact['message'] ?? null) {
    ?>
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="h5 modal-title" id="modalLabel">Contact
                    <?=get_the_title()?>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?=do_shortcode('[gravityform id="8" title="false" description="false" ajax="true" field_values="email=' . $contact['email_address'] . '"]')?>
            </div>
        </div>
    </div>
</div>
<?php
}

get_footer();
?>