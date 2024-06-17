<section class="job_listings pb-5">
    <div class="container-xl">
        <?php
$q = new WP_Query(array(
    'posts_per_page' => -1,
    'post_type' => 'careers',
    'post_status' => 'publish'
));

        if ($q->have_posts()) {

            while ($q->have_posts()) {
                $q->the_post();
                ?>
        <a class="joblisting" href="<?php the_permalink(); ?>">
            <div class="joblisting__title">
                <?=get_the_title()?>
            </div>
            <div class="joblisting__detail">
                <strong>Posted:</strong> <?=get_the_date()?>
            </div>
            <div class="joblisting__salary"><strong>Salary:</strong> <?php
                if (have_rows('base_salary', get_the_ID())) {
                    while (have_rows('base_salary', get_the_ID())) {
                        the_row();
                        if (get_sub_field('text', get_the_ID()) ?? null) {
                            echo get_sub_field('text');
                        } else {
                            while (have_rows('numeric_salary', get_the_ID())) {
                                the_row();
                                echo '£' . number_format(get_sub_field('minValue'));
                                if (get_sub_field('maxValue')) {
                                    echo ' - £' . number_format(get_sub_field('maxValue'));
                                }
                                echo ' per ' . strtolower(get_sub_field('QuantitativeValue'));
                            }
                        }
                    }
                }
                ?>
            </div>
        </a>
        <?php
            }
        } else {
            echo 'We do not have any positions available at this time. Check back later to see new postings.';
        }
        ?>
    </div>
</section>