<?php
/**
 * Template Name: Hiring Page New
 */

get_header();
$hiring_title = get_field('hiring_title');
$vacancies_list = get_field('vacancies_list');
?>

<main>
    <?php $background = get_field('hiring_hero_background') ?>
    <?php $background_mobile = get_field('hiring_hero_background_mobile') ?>

    <div class="hiring__hero" <?php echo bg($background) ?>>
        <div class="grid-container">
            <div class="hiring__hero-new-wrapper">
                <?php if ($title = get_field('hiring_hero_title')): ?>
                    <?php echo $title ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="hiring__hero-mobile" <?php echo bg($background_mobile) ?>>
        <div class="grid-container">
            <div class="hiring__hero-new-wrapper">
                <?php if ($title = get_field('hiring_hero_title')): ?>
                    <?php echo $title ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <section class="hiring-new">
        <div class="grid-container grid-container--wide">
            <div class="hiring__wrapper-new">
                <div class="hiring__content-new">
                    <?php if ($hiring_title): ?>
                        <h2><?php echo $hiring_title; ?></h2>
                    <?php endif; ?>

                    <?php if ($vacancies_list): ?>

                        <div class="grid-x grid-padding-x grid-padding-y align-justify align-">
                            <?php foreach ($vacancies_list as $vacancy):
                                $vacancy_title = $vacancy['vacancy_title'];
                                $subtitle = $vacancy['subtitle'];
                                $vacancy_description = $vacancy['vacancy_description'];
                                $job_type = $vacancy['job_type'];
                                $working_hours = $vacancy['working_hours'];
                                $button = $vacancy['button'];
                                ?>
                                <div class="cell large-4 medium-6 small-12">
                                    <div class="vacancy-card">
                                        <h4><?php echo $vacancy_title; ?></h4>
                                        <span class="location">
                                            <?php echo $subtitle; ?>
                                        </span>
                                        <div class="vacancy-description">
                                            <?php echo $vacancy_description; ?>
                                        </div>
                                        <div class="job-type-wrap">
                                            <div class="job-type">
                                                <span>Job Type</span><p><?php echo $job_type; ?><p>
                                            </div>
                                            <div class="working-hours">
                                                <span>Working Hours</span><p><?php echo $working_hours; ?></p>
                                            </div>
                                        </div>
                                        <?php
                                        if( $button ):
                                            $button_url = $button['url'];
                                            $button_title = $button['title'];
                                            $button_target = $button['target'] ? $link['target'] : '_self';
                                            ?>
                                            <a class="button" href="<?php echo esc_url( $button_url ); ?>" target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="aditional-content">
                        <?php
                        $image = get_field('logo');
                        $cta_text = get_field('cta_text');
                        if( !empty( $image ) ): ?>
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                        <?php endif; ?>
                        <?php if( !empty( $cta_text ) ): ?>
                            <?php echo $cta_text; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="cell page__anchor-wrapper hiring__anchor align-center">
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


