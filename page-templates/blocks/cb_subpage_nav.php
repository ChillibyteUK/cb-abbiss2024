<section class="subpage_nav py-5">
    <div class="container-xl">
        <div class="subpage_nav__grid">
            <?php
    $child_pages = get_pages(array(
        'child_of' => get_the_ID(),
        'parent' => get_the_ID(),
        'sort_column' => 'menu_order', // Optional: you can sort by title or date as well
        'sort_order' => 'ASC' // Optional: ASC for ascending order, DESC for descending order
    ));

            if (!empty($child_pages)) {
                foreach ($child_pages as $page) {
                    // Display the title and link of each child page
                    echo '<a href="' . get_permalink($page->ID) . '">' . $page->post_title . '</a>';
                }
            }
            ?>
        </div>
    </div>
</section>