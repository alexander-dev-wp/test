<?php
/**
 * Template Name: Home Page
 */
get_header(); ?>
    <main>
        <!--HOME PAGE SLIDER-->
        <div id="top">
            <?php home_slider_template(); ?>
        </div>
        <!--END of HOME PAGE SLIDER-->
        <!-- BEGIN of main content -->
        <?php get_template_part('parts/review'); ?>
        <section class="explore__section">
            <div class="grid-container">
                <div class="explore__wrapper">
                    <?php if ($subtitle = get_field('explore_subtitle')): ?>
                        <div class="subtitle explore__subtitle"><?php echo $subtitle ?></div>
                    <?php endif; ?>
                    <?php if ($text = get_field('explore_text')): ?>
                        <div class="explore__text">
                            <div class="text-medium"><?php echo $text ?></div>
                        </div>
                    <?php endif; ?>
                    <?php if (have_rows('explore_links')): ?>
                        <div class="explore__cards">
                            <?php $counter = 0 ?>
                            <?php while (have_rows('explore_links')):
                                the_row();
                                $counter++;
                                $link = get_sub_field('link')
                                ?>
                                <div class="explore__card-item">
                                    <a href="<?php echo $link["url"] ?>">
                                        <?php if ($image = get_sub_field('image')): ?>
                                            <?php echo wp_get_attachment_image($image["id"], 'full', false, array('class' => 'explore__card-image')); ?>
                                        <?php endif; ?>
                                        <div class="explore__card-content">
                                            <div class="explore__card-title"
                                                 style="background: url('<?php echo IMAGE_ASSETS . 'svg-crop.svg' ?>')">
                                                <div class="explore__card-number"><?php echo $counter < 10 ? '0' : '' ?><?php echo $counter ?></div>
                                                <?php if ($title = get_sub_field('title')): ?>
                                                    <h5><?php echo $title ?></h5>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($text = get_sub_field('text')): ?>
                                                <div class="explore__card-text">
                                                    <div><p><?php echo $text ?></p></div>
                                                    <div class="explore__card-link"><i
                                                                class="fa-solid fa-arrow-right"></i>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                    <?php get_template_part('parts/explore-slider') ?>
                </div>
            </div>
        </section>


        <?php get_template_part('parts/process'); ?>
        <section class="extensive__section">
            <div class="grid-container">
                <div class="extensive__wrapper">
                    <div class="extensive__column">
                        <?php if ($logo = get_field('video_logo')): ?>
                            <?php echo wp_get_attachment_image($logo["id"], 'large') ?>
                        <?php endif; ?>
                        <?php if ($video = get_field('video')): ?>
                            <video autoplay muted loop>
                                <source src="<?php echo esc_url($video["url"]) ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>
                    </div>
                    <div class="extensive__text">
                        <?php if ($subtitle = get_field('video_subtitle')): ?>
                            <div class="extensive__subtitle subtitle"><?php echo $subtitle ?></div>
                        <?php endif; ?>
                        <?php if ($text = get_field('video_text')): ?>
                            <div class="text-medium">
                                <?php echo $text ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php $background = get_field('ready_background') ?>
        <section class="ready__section"
                 style="background: url('<?php echo $background["url"] ?>') no-repeat; background-size: cover">
            <div class="grid-container">
                <div class="ready__wrapper">
                    <?php if ($text = get_field('ready_content')): ?>
                        <div class="text-medium"><?php echo $text ?></div>
                    <?php endif ?>
                    <?php if ($link = get_field('ready_link')): ?>
                        <a href="<?php echo $link["url"] ?>" class="ready__link button__link">
                            <?php if ($icon = get_field('ready_link_icon')): ?>
                                <?php echo wp_get_attachment_image($icon["id"], 'full'); ?>
                            <?php endif; ?>
                            <span><?php echo $link["title"] ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($logo = get_field('ready_logo')): ?>
                <?php echo wp_get_attachment_image($logo["id"], 'full', false, array('class' => 'ready__logo')) ?>
            <?php endif; ?>
        </section>
        <section class="form__section" id="home-form">
            <div class="grid-container">
                <div class="form__wrapper">
                    <div class="form__text-wrapper">
                        <?php if ($image = get_field('form_logo')): ?>
                            <div class="form__text-logo"><?php echo wp_get_attachment_image($image["id"], 'full') ?></div>
                        <?php endif; ?>
                        <?php
                        $subtitle = get_field('form_subtitle');
                        $text = get_field('form_text');
                        if ($subtitle || $text):
                            ?>
                            <div class="form__text">
                                <?php if ($subtitle): ?>
                                    <div class="form__subtitle subtitle"><?php echo $subtitle ?></div>
                                <?php endif; ?>
                                <?php if ($text): ?>
                                    <div class="text-medium"><?php echo $text ?></div>
                                <?php endif ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (class_exists('GFAPI') && ($contact_form = get_field('form')) && is_array($contact_form)): ?>
                        <div class="homepage-form-wrapper">
                            <div class="homepage__form">
                                <?php echo do_shortcode("[gravityform id='{$contact_form['id']}' title='false' description='false' ajax='true']"); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="page__anchor-wrapper home__anchor">
                    <div class="page__anchor">
                        <a href="#top">
                            <i class="fa-solid fa-arrow-up"></i>
                            <div>Go Back To Top</div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- END of main content -->
    </main>

<?php get_footer(); ?>