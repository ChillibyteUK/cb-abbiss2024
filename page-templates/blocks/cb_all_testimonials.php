<?php
$q = new WP_query(array(
    'post_type' => 'testimonials',
    'post_status' => 'publish',
    'posts_per_page' => -1
));

if ($q->have_posts()) {
    while ($q->have_posts()) {
        $q->the_post();
        $slug = $q->post_name;
        ?>
<hr>
<a class="anchor" id="<?=$slug?>"></a>
<div class="row mb-2">
    <div class="col-lg-3">
        <?=wp_get_attachment_image(get_field('logo', get_the_ID()), 'full', false, '')?>
    </div>
    <div class="col-lg-9">
        <div class="testimonial-preview">
            <?=apply_filters('the_content', get_field('testimonial', get_the_ID()))?>
        </div>
        <div class="text-right font-weight-bold">
            <?php
                    echo get_field('author', get_the_ID());
        if (get_field('position') ?? null) {
            echo ' - ' . get_field('position', get_the_ID());
        }
        ?>
        </div>
    </div>
</div>
<?php
    }
    ?>
<?php
}
?>