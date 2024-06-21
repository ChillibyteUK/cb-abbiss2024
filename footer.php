<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package cb-abbiss
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

if (strpos($_SERVER['REQUEST_URI'], '/corridor/') == false || check_corridor_cookie() != 'Corridor') {

    echo 'COOKIE: ' . check_corridor_cookie();
    ?>
<div class="bottom-cta py-4">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-8">
                <div class="h5">International reach</div>
                <div>We have helped clients meet their HR needs in over 70 countries across five continents.</div>
            </div>
            <div class="col-md-4 text-end my-auto">
                <a class="button button-white" href="/about-us/international/">Find out more</a>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<footer>
    <div class="container-xl pt-5">
        <div class="row g-4 pb-5">
            <div class="col-md-4">
                <div class="menu-title">Information</div>
                <?php wp_nav_menu(array('theme_location' => 'footer_menu_fb')); ?>
            </div>
            <div class="col-md-3">
                <div class="menu-title">Contact</div>
                <div class="pb-2">
                    <?=do_shortcode('[contact_phone]')?>
                </div>
                <div class="pb-3">
                    <?=do_shortcode('[contact_email]')?>
                </div>
                <div class="pb-2 socials">
                    <?=do_shortcode('[social_tw_icon]')?>
                    <?=do_shortcode('[social_in_icon]')?>
                </div>
            </div>
            <div class="col-md-5">
                <div class="menu-title">Subscribe</div>
                <p>Stay up to the minute on our latest news and insights</p>
            </div>
        </div>
    </div>
    <div class="container-xl colophon pb-4">
        <div class="row g-4">
            <div class="col-md-6 order-2 order-md-1">
                &copy; <?=date('Y')?> Abbiss
                Cadres LLP
            </div>
            <div class="col-md-6 order-1 order-md-2 d-flex align-items-center justify-content-md-end flex-wrap gap-1">
                <a href="/privacy-policy/">Privacy Policy</a> |
                <a href="https://www.chillibyte.co.uk/" rel="nofollow noopener" target="_blank" class="cb"
                    title="Digital Marketing by Chillibyte"></a>
            </div>
        </div>
    </div>
</footer>
<?php
/*
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WHXTFPP" height="0" width="0"
        style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->



<script type="text/javascript">
    _linkedin_partner_id = "2852233";
    window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
    window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script>
<script type="text/javascript">
    (function(l) {
        if (!l) {
            window.lintrk = function(a, b) {
                window.lintrk.q.push([a, b])
            };
            window.lintrk.q = []
        }
        var s = document.getElementsByTagName("script")[0];
        var b = document.createElement("script");
        b.type = "text/javascript";
        b.async = true;
        b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
        s.parentNode.insertBefore(b, s);
    })(window.lintrk);
</script>
<noscript>
    <img height="1" width="1" style="display:none;" alt=""
        src="https://px.ads.linkedin.com/collect/?pid=2852233&fmt=gif" />
</noscript>

*/
?>
<?php wp_footer(); ?>

</body>

</html>