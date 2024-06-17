<?php
$class = $block['className'] ?? 'mb-5';

$tax = get_field('testimonial_area') ?? null;

if ($tax != '') {
    $tax_query = array(
        array(
            'taxonomy' => 'testimonial_areas',
            'field' => 'term_id',
            'terms' => $tax
        )
        );
}

$p = new WP_Query(
    array(
        'post_type' => 'testimonials',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => $tax_query
    )
);

// $size = ($size) ? $size : 30;
$size = 30;

?>
<div class="testimonial_slider <?=$class?>">
    <div class="container-xl testimonial_slider__inner p-5">
        <div class="swiper testimonial_slider__slider">
            <div class="swiper-wrapper pb-4">
                <?php
            if ($p->have_posts()) {
                while($p->have_posts()) {
                    $p->the_post();
                    $image_id = get_field('logo', get_the_ID());
                    $image = $image_id ? wp_get_attachment_image($image_id, 'large', false, array('class' => 'testimonial_slider__logo')) : null;
                    if ($image ?? null) {
                        ?>
                <div class="testimonial_slider__slide swiper-slide py-4">
                    <?=$image?>
                    <div class="testimonial_slider__excerpt">
                        <?=wp_trim_words(get_field('testimonial', get_the_ID()), $size)?>
                    </div>
                </div>
                <?php
                    }
                }
            }
?>
            </div>
            <div class="swiper-pagination swiper-pagination-testimonials"></div>
        </div>
        <div class="text-center">
            <a href="/about-us/testimonials/" class="mx-auto button button-sm button-outline">View all</a>
        </div>
    </div>
</div>
<?php

add_action('wp_footer', function () {
    ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        function setEqualHeight(slider) {
            let maxHeight = 0;
            const slides = document.querySelectorAll(slider);

            // Remove existing heights to recalculate
            slides.forEach(slide => {
                slide.style.height = 'auto';
            });

            // Find the maximum height
            slides.forEach(slide => {
                if (slide.offsetHeight > maxHeight) {
                    maxHeight = slide.offsetHeight;
                }
            });

            // Set all slides to the maximum height
            slides.forEach(slide => {
                slide.style.height = `${maxHeight}px`;
            });
        }

        var latestSlider = new Swiper('.testimonial_slider__slider', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: true,
            },
            pagination: {
                el: '.swiper-pagination-testimonials',
                clickable: true,
                dynamicBullets: true,
            },
            slidesPerView: 1,
            slidesPerGroup: 1,
            spaceBetween: 18, // Adjust this value to match your design
            on: {
                init: function() {
                    setEqualHeight('.testimonial_slider__slide');
                },
                resize: function() {
                    setEqualHeight('.testimonial_slider__slide');
                }
            }
        });

        window.addEventListener('load', setEqualHeight('.testimonial_slider__slide'));

    });
</script>
<?php
}, 9999);

?>