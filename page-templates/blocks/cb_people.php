<?php
$class = $block['className'] ?? 'pb-5';
?>
<section class="people <?=$class?>">
    <div class="container-xl">
        <?php
        $p = new WP_Query(array(
            'post_type' => 'people',
            'post_status' => 'publish',
            'posts_per_page' => -1
        ));
if ($p->have_posts()) {
    ?>
        <div class="row">
            <?php
    while ($p->have_posts()) {
        $p->the_post();
        $contact = get_field('contact_details', get_the_ID());
        ?>
            <div class="col-lg-6 col-xl-4 g-4">
                <div class="people__card">
                    <div class="people__name">
                        <img src="<?=get_the_post_thumbnail_url(get_the_ID(), 'large')?>"
                            class="people__image pb-2">
                        <div class="font-weight-bold">
                            <?=get_the_title()?>
                        </div>
                        <?=get_field('title', get_the_ID())?>
                    </div>
                    <ul class="people__specialisms">
                        <?php
                if (have_rows('specialisms', get_the_ID())) {
                    while (have_rows('specialisms', get_the_ID())) {
                        the_row(); ?>
                        <li>
                            <?=get_sub_field('specialism')?>
                        </li><?php
                    }
                }
        ?>
                    </ul>
                    <div class="people__links">
                        <a class="link-arrow-inline"
                            href="<?=get_permalink()?>">View
                            profile</a>
                        <?php
            if ($contact['linkedin_url'] ?? null) {
                ?>
                        <a href="<?=$contact['linkedin_url']?>"
                            target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                        <?php
            }
        ?>
                    </div>
                </div>
            </div>
            <?php
    }
    ?>
        </div>
        <?php
}
?>
    </div>
</section>