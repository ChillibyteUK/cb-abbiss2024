<?php
$class = $block['className'] ?? 'pb-5';
$bg = get_field('grey_bg') ? 'bg-grey-500' : '';
$style = (get_field('compact')[0] ?? null) === 'Yes' ? 'services_nav__compact' : '';

$section = strpos($_SERVER['REQUEST_URI'], '/corridor/') !== false ? '/corridor' : '/for-businesses/all-services';

$link = wp_make_link_relative(get_permalink());
?>
<section
    class="services_nav <?=$bg?> <?=$class?> <?=$style?>">
    <div class="container-xl">
        <?php
        $active = $link == $section . '/communications/' ? 'active' : '';
?>
        <a class="services_nav__card <?=$active?>"
            href="<?=$section?>/communications/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-communications.svg"
                alt="Communications Icon">
            <div>Communications</div>
        </a>
        <?php
$active = $link == $section . '/people-consulting/' ? 'active' : '';
?>
        <a class="services_nav__card <?=$active?>"
            href="<?=$section?>/people-consulting/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-people-consulting.svg"
                alt="People Consulting Icon">
            <div>People<br>Consulting</div>
        </a>
        <?php
$active = $link == $section . '/law-tax/' ? 'active' : '';
?>
        <a class="services_nav__card <?=$active?>"
            href="<?=$section?>/law-tax/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-law.svg"
                alt="Law & Tax Icon">
            <div>Law<br>&amp; Tax</div>
        </a>
    </div>
</section>