<?php
$class = $block['className'] ?? 'py-5';
?>
<section class="subpage_nav <?=$class?>">
    <div class="container-xl">
        <div class="subpage_nav__grid">
            <?php
            global $post;
$parent_id = $post->post_parent ? $post->post_parent : $post->ID;

$sibling_pages = get_pages(array(
   'child_of' => $parent_id,
   'parent' => $parent_id,
   'sort_column' => 'post_title',
   'sort_order' => 'ASC'
));


if (!empty($sibling_pages)) {
    foreach ($sibling_pages as $page) {
        $active = $page->ID === get_the_ID() ? 'active' : '';
        echo '<a href="' . get_permalink($page->ID) . '" class="' . $active . '">' . $page->post_title . '</a>';
    }
}
?>
        </div>
    </div>
</section>