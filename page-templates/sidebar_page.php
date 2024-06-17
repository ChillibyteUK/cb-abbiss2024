<?php
/*
Template Name: Sidebar Page
*/

// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header();
?>
<main id="main">
    <h1>SIDEBAR</h1>
    <?php
    the_post();
the_content();
?>
</main>
<?php
get_footer();
?>