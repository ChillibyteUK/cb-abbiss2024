<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package cb-abbiss
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

session_start();

$container = get_theme_mod('understrap_container_type');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta name="google-site-verification" content="wczm1rgEOtO30V7jJnjSFHSmvP8eWuuudCp0YxPysig" />
    <meta
        charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="preload"
        href="<?=get_stylesheet_directory_uri()?>/fonts/jost-v15-latin-300.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload"
        href="<?=get_stylesheet_directory_uri()?>/fonts/jost-v15-latin-300italic.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">
    <link rel="preload"
        href="<?=get_stylesheet_directory_uri()?>/fonts/jost-v15-latin-regular.woff2"
        as="font" type="font/woff2" crossorigin="anonymous">

    <?php
    if (get_field('gtm_property', 'options')) {
        ?>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer',
            '<?=get_field('gtm_property', 'options')?>'
        );
    </script>
    <!-- End Google Tag Manager -->
    <?php
    }


if (is_front_page() || is_page('contact-us')) {
    ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Abbiss Cadres",
            "legalName": "Abbiss Cadres LLP",
            "url": "https://www.abbisscadres.com/",
            "logo": "https://abbisscadres.com/wp-content/uploads/2021/03/ac-logo-large.png",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "11 Ironmonger Lane",
                "addressLocality": "London",
                "postalCode": "EC2V 8EY",
                "addressCountry": "United Kingdom"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "customer support",
                "telephone": "[+44 (0) 203 051 5711]",
                "email": "info@abbisscadres.com"
            },
            "sameAs": [
                "https://twitter.com/Abbiss_Cadres",
                "https://www.linkedin.com/company/abbiss-cadres-llp"
            ]
        }
    </script>
    <?php
}

// check for hero images and preload
/*
<link rel="preload"
    href="<?=wp_get_attachment_image_url(get_field('background'), 'full', false)?>"
    as="image" fetchpriority="high" crossorigin>
*/
global $post;
$content = $post->post_content;
$blocks = parse_blocks($content);
$hero_image_id = '';
foreach ($blocks as $block) {
    if ($block['blockName'] === 'acf/cb-hero') {
        // Get the 'background' field
        if (isset($block['attrs']['data']['background'])) {
            $hero_image_id = $block['attrs']['data']['background'];
        }
        break;
    }
}
if ($hero_image_id) {
    ?>
    <link rel="preload"
        href="<?=wp_get_attachment_image_url($hero_image_id, 'full', false)?>"
        as="image" fetchpriority="high">
    <?php
}

?>
    <?php wp_head(); ?>
    <!-- <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff"> -->


</head>

<body <?php body_class(); ?>>
    <?php
do_action('wp_body_open');

if (get_field('gtm_property', 'options')) {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe
            src="https://www.googletagmanager.com/ns.html?id=<?=get_field('ga_property', 'options')?>"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}

$prenav_fb = 'active';
$prenav_co = 'inactive';
$home = '/';

if (strpos($_SERVER['REQUEST_URI'], '/corridor/') !== false || check_corridor_cookie() == 'Corridor') {
    $prenav_fb = 'inactive';
    $prenav_co = 'active';
    $home = '/corridor/';
}

?>
    <header>
        <nav class="prenav px-0">
            <div class="d-flex w-100">
                <a href="/"
                    class="text-center flex-fill p-1 <?=$prenav_fb?>">
                    For Businesses
                </a>
                <a href="/corridor/"
                    class="text-center flex-fill p-1 <?=$prenav_co?>">
                    For Professional Services
                </a>
            </div>
        </nav>

        <nav id="navbar" class="navbar navbar-expand-lg" aria-labelledby="main-nav-label">
            <div class="container-xl pt-4 pb-3">
                <a href="<?=$home?>"><img
                        src="<?=get_stylesheet_directory_uri()?>/img/abbiss-cadres-logo--dark.svg"
                        width=224 height=84 alt="Abbiss Cadres"></a>
                <button class="navbar-toggler input-button" id="navToggle" data-bs-toggle="collapse"
                    data-bs-target=".navbars" type="button" aria-label="Navigation"><i
                        class="fa fa-navicon"></i></button>
                <?php
                $menu = strpos($_SERVER['REQUEST_URI'], '/corridor/') !== false ? 'primary_nav_co' : 'primary_nav_fb';
if (check_corridor_cookie() == 'Corridor') {
    $menu = 'primary_nav_co';
}
wp_nav_menu(
    array(
        'theme_location'  => $menu,
        'container_class' => 'collapse navbar-collapse navbars',
        'container_id'    => 'primaryNav',
        'menu_class'      => 'navbar-nav w-100 justify-content-end gap-lg-4',
        'menu_id'         => 'main-menu',
        'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
    )
);
?>
            </div>
        </nav>

    </header>