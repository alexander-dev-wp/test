<?php
/**
 * Template Name: Hiring Page
 */

get_header();
$hiring_subtitle = get_field('hiring_subtitle');
$vacancies_list = get_field('vacancies_list');
?>

<main>
    <?php $background = get_field('hiring_hero_background') ?>

    <div class="hiring__hero" <?php echo bg($background) ?>>
        <div class="grid-container">
            <div class="hiring__hero-wrapper">
                <?php if ($title = get_field('hiring_hero_title')): ?>
                    <h1><?php echo $title ?></h1>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <section class="hiring">
        <div class="grid-container grid-container--wide">
            <div class="hiring__wrapper">
                <div class="hiring__content">
                    <?php if ($hiring_subtitle): ?>
                        <p class="hiring__subtitle"><?php echo $hiring_subtitle; ?></p>
                    <?php endif; ?>

                    <?php if ($vacancies_list): ?>
                    <div class="hiring__vacancies">
                        <?php foreach ($vacancies_list

                                       as $vacancy):
                        $vacancy_title = $vacancy['vacancy_title'];
                        $vacancy_short_info = $vacancy['vacancy_short_info'];
                        $vacancy_description = $vacancy['vacancy_description'];
                        $vacancy_short_arr = $vacancy['vacancy_short_arr'];
                        ?>

                        <div class="hiring__vacancy vacancy-h">
                            <?php if ($vacancy_title): ?>
                                <h1 class="vacancy-h__title"><?php echo $vacancy_title; ?></h1>
                            <?php endif; ?>

                            <?php if (!empty($vacancy_short_arr)): ?>
                                <ul class="vacancy-h__short-info">
                                    <?php foreach ($vacancy_short_arr as $short_item): ?>

                                        <?php if ($short_item): ?>
                                            <li class="vacancy-h__short">
                                                <?php
                                                $short_title = $short_item['short_title'];
                                                $short_text_type = $short_item['short_text_type'];
                                                $short_text = $short_item['short_text'];
                                                $short_link_arr = $short_item['short_link'];
                                                $short_image_id = $short_item['short_image'];
                                                ?>

                                                <?php echo wp_get_attachment_image($short_image_id ?? 0, 'thumbnail', false, array('class' => 'vacancy-h__image', 'data-no-lazy' => '1')); ?>

                                                <div>
                                                    <?php if ($short_title): ?>
                                                        <span><?php echo $short_title; ?></span>
                                                    <?php endif; ?>
                                                    <?php if (!$short_text_type && $short_text): ?>
                                                        <p><?php echo $short_text; ?></p>
                                                    <?php elseif ($short_text_type && $short_link_arr): ?>
                                                        <a href="<?php echo $short_link_arr['url']; ?>"
                                                           target="<?php echo $short_link_arr['target']; ?>"><?php echo $short_link_arr['title']; ?></a>
                                                    <?php endif; ?>
                                                </div>

                                            </li>
                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($vacancy_description): ?>
                            <div class="vacancy-h__description">
                                <?php echo $vacancy_description; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (class_exists('GFAPI') && ($contact_form = get_field('contact_form')) && is_array($contact_form)): ?>
                    <div class="hiring__form-wrapper">
                        <?php if ($title = get_field('form_title')): ?>
                            <h2 class="hiring__form-title"><?php echo $title ?></h2>
                        <?php endif; ?>
                        <div class="hiring__form">
                            <?php echo do_shortcode("[gravityform id='{$contact_form['id']}' title='false' description='false' ajax='true']"); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="cell page__anchor-wrapper hiring__anchor">
                    <div class="page__anchor">
                        <a href="#top">
                            <i class="fa-solid fa-arrow-up"></i>
                            <div>Go Back To Top</div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>


