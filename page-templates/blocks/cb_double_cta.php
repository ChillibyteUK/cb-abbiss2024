<?php
$l = get_field('link_left');
$r = get_field('link_right');
?>
<section class="cta_reviews pb-5">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-lg-6 d-flex flex-column">
                <?php
                if (get_field('title_left') ?? null) {
                    ?>
                <h3 class="pt-2 border-top">
                    <?=get_field('title_left')?>
                </h3>
                <?php
                }
?>
                <a class="cta_reviews__card cta_reviews__card--square p-5"
                    href="<?=$l['url']?>">
                    <?=wp_get_attachment_image(get_field('background_left'), 'full', false, array('class' => 'cta_reviews__background'))?>
                    <div class="overlay"></div>
                    <?php
    if (get_field('icon_left') ?? null) {
        ?>
                    <img src="<?=get_field('icon_left')?>"
                        class="cta_reviews__icon">
                    <?php
    }
?>
                    <span
                        class="button button-white"><?=$l['title']?></span>
                </a>
            </div>
            <div class="col-lg-6 d-flex flex-column">
                <?php
                if (get_field('title_right') ?? null) {
                    ?>
                <h3 class="pt-2 border-top">
                    <?=get_field('title_right')?>
                </h3>
                <?php
                }
?>
                <a class="cta_reviews__card cta_reviews__card--square p-5"
                    href="<?=$r['url']?>">
                    <?=wp_get_attachment_image(get_field('background_right'), 'full', false, array('class' => 'cta_reviews__background'))?>
                    <div class="overlay"></div>
                    <?php
    if (get_field('icon_right') ?? null) {
        ?>
                    <img src="<?=get_field('icon_right')?>"
                        class="cta_reviews__icon">
                    <?php
    }
?>
                    <span
                        class="button button-white"><?=$r['title']?></span>
                </a>
            </div>
        </div>
    </div>
</section>