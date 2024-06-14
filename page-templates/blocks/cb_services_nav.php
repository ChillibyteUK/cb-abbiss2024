<?php
$class = $block['className'] ?? 'pb-5';
$bg = get_field('grey_bg') ? 'bg-grey-500' : '';
$style = (get_field('compact')[0] ?? null) === 'Yes' ? 'services_nav__compact' : '';

$link = wp_make_link_relative(get_permalink());
?>
<section
    class="services_nav <?=$bg?> <?=$class?> <?=$style?>">
    <div class="container-xl">
        <?php
        $active = $link == '/for-businesses/all-services/communications/' ? 'active' : '';
?>
        <a class="services_nav__card <?=$active?>"
            href="/for-businesses/all-services/communications/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-communications.svg"
                alt="Communications">
            <div>Communications</div>
        </a>
        <?php
$active = $link == '/for-businesses/all-services/people-consulting/' ? 'active' : '';
?>
        <a class="services_nav__card <?=$active?>"
            href="/for-businesses/all-services/people-consulting/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-people-consulting.svg"
                alt="People Consulting">
            <div>People<br>Consulting</div>
        </a>
        <?php
$active = $link == '/for-businesses/all-services/law-tax/' ? 'active' : '';
?>
        <a class="services_nav__card <?=$active?>"
            href="/for-businesses/all-services/law-tax/">
            <img src="<?=get_stylesheet_directory_uri()?>/img/icon-law.svg"
                alt="Law & Tax">
            <div>Law<br>&amp; Tax</div>
        </a>
    </div>
</section>