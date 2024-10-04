<section class="subpage_nav py-5">
    <div class="container-xl">
        <div class="subpage_nav__grid">
            <?php
    $child_pages = get_pages(array(
        'child_of' => get_the_ID(),
        'parent' => get_the_ID(),
        'sort_column' => 'post_title',
        'sort_order' => 'ASC'
    ));

    var_dump($child_pages);

            if (!empty($child_pages)) {
                foreach ($child_pages as $page) {
                    // Display the title and link of each child page
                    echo '<a href="' . get_permalink($page->ID) . '" class="">' . $page->post_title . '</a>';
                }
            }
            ?>
        </div>
    </div>
</section>