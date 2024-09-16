<section class="people_slider">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-sm-4 col-md-3 col-lg-2">
                <div class="swiper people_slider__slider">
                    <div class="swiper-wrapper">
                        <?php
                        $people = get_field('people');
                        foreach ($people as $p) {
                            ?>
                        <div class="swiper-slide people_slider__slide">
                            <img src="<?=get_the_post_thumbnail_url($p, 'large')?>"
                                    class="people_slider__image pb-2">
                            <div class="font-weight-bold text-center">
                                <?=get_the_title($p)?>
                            </div>
                            <div class="text-center"><?=get_field('title', $p)?></div>
                        </div>
                            <?php
                        }   
                    ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-md-9 col-lg-10">
                <h2><?=get_field('title') ?? null?></h2>
                <p><?=get_field('content') ?? null?></p>
                <?php
                $l = get_field('link') ?? null;
                ?>
                <a href="<?=$l['url']?>" class="button button-black button-sm" target="<?=$l['target']?>"><?=$l['title']?></a>
            </div>
        </div>
    </div>
</section>
<?php

add_action('wp_footer', function () {
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var peopleSlider = new Swiper('.people_slider__slider', {
        loop: true,
        autoplay: {
            delay: 3500,
            disableOnInteraction: true,
        },
        slidesPerView: 1,
        slidesPerGroup: 1,
        spaceBetween: 18
    });
});
</script>
    <?php
});