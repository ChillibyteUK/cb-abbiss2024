<?php
/**
 * The template for displaying single careers
 *
 * @package cb-abbiss2024
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();
?>
<main class="job_listing">
    <section class="breadcrumbs mb-4">
        <div class="container-xl">
            <?php
            if (function_exists('yoast_breadcrumb')) {
                // yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                yoast_breadcrumb();
            }
?>
        </div>
    </section>

    <section class="single_people__hero">
        <div class="container-xl">
            <div class="row">
                <div class="d-none d-lg-block col-lg-4 col-xl-3 p-4 my-auto">
                    <img src="<?=get_stylesheet_directory_uri()?>/img/icon-person.svg"
                        class="icon-small">
                </div>
                <div class="col-lg-8 col-xl-9 my-auto">
                    <h1><?=get_the_title()?></h1>
                </div>
            </div>
        </div>
    </section>
    <div class="container-xl">

        <div class="row">
            <div class="col-md-3">
                <div class="job_listing__spec">
                    <div class="job_listing__feature">Employment Type</div>
                    <?php
                    $emp = array(
                        'FULL_TIME' => 'Full time',
                        'PART_TIME' => 'Part time',
                        'CONTRACTOR' => 'Contract',
                        'TEMPORARY' => 'Temporary',
                        'INTERN' => 'Intern',
                        'VOLUNTEER' => 'Volunteer',
                        'PER_DIEM' => 'Per diem',
                        'OTHER' => 'Other'
                    );
echo '<div class="mb-4">' . $emp[ get_field('employment_type') ] . '</div>';
?>
                    <div class="job_listing__feature">Salary</div>
                    <?php
                    $baseSalary = '';
if (have_rows('base_salary')) {
    while (have_rows('base_salary')) {
        the_row();
        if (get_sub_field('text')) {
            echo '<div class="mb-4">' . get_sub_field('text') . '</div>';
        } else {
            while (have_rows('numeric_salary')) {
                the_row();
                echo '<div class="mb-4">£' . number_format(get_sub_field('minValue'));
                $baseSalary = get_sub_field('minValue');
                $per = get_sub_field('QuantitativeValue');
                if (get_sub_field('maxValue')) {
                    echo ' - £' . number_format(get_sub_field('maxValue'));
                }
                echo ' per ' . strtolower(get_sub_field('QuantitativeValue'));
                echo '</div>';
            }
        }
    }
}

if (get_field('reporting_to')) {
    ?>
                    <div class="job_listing__feature">Reporting to</div>
                    <div class="mb-4">
                        <?=get_field('reporting_to')?>
                    </div>
                    <?php
}

if (get_field('office')) {
    ?>
                    <div class="job_listing__feature">Location</div>
                    <?php
    $locas = array();
    foreach (get_field('office') as $o) {
        // $loca = get_term_by('id', $o, 'locations');
        // array_push($locas, $loca->name);
        array_push($locas, $o->name);
    }
    echo '<div class="mb-4">' . implode(', ', $locas) . '</div>';
}
?>

                </div>
            </div>
            <div class="col-md-9">
                <?php

$banner = get_field('banner');
if ($banner) {
    echo '<div class="larger pb-4">' . $banner . '</div>';
}

$role = get_field('purpose');
if($role) {
    echo '<h2>Role Purpose</h2>';
    echo '<div class="pb-2">' . $role . '</div>';
}
?>

                <h2>Key Responsibilities</h2>
                <?php

$res = get_field('responsibilities');
echo '<ul>';
foreach ($res as $r) {
    echo '<li>' . $r['responsibility'] . '</li>';
}
echo '</ul>';


$skills = get_field('skills');
if ($skills) {
    echo '<h2 class="pt-2">Skills and Experience</h2>';
    echo '<ul>';
    foreach ($skills as $s) {
        echo '<li>' . $s['skill'] . '</li>';
    }
    echo '</ul>';
}
?>

                <div class="py-2">
                    <h2>Next Steps</h2>
                    <?php
echo get_field('contact_details');
?>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "JobPosting",
        "title": "<?=get_the_title()?>",
        "description": "<?=$role?>",
        "hiringOrganization": {
            "@type": "Organization",
            "name": "Abbiss Cadres LLP",
            "logo": "https://abbisscadres.com/wp-content/uploads/2021/03/ac-logo-large.png",
            "sameAs": "https://www.abbisscadres.com/",
        },
        "datePosted": "<?=get_the_date(); ?>",
        "validThrough": "2030-01-01T00:00",
        "employmentType": "<?=get_field('employment_type'); ?>",
        "jobLocation": {
            "@type": "Place",
            <?php
            $loca = get_field('office');
echo $loca[0]->description;
?>
        }
        <?php
        if ($baseSalary != '') {
            ?>
        ,
        "baseSalary": {
            "@type": "MonetaryAmount",
            "currency": "GBP",
            "value": {
                "@type": "QuantitativeValue",
                "value": <?=$baseSalary?> ,
                "unitText": "<?=$per?>"
            }
        }
        <?php
        }
?>
    }
</script>
<?php
get_footer();
?>