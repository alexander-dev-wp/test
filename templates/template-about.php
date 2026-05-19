<?php
/**
 * Template Name: About Us
 */
get_header(); ?>
    <main>
        <div id="top">
            <section class="hero__section">
                <div class="grid-container">
                    <?php if ($text = get_field('hero_text')): ?>
                        <div class="text-large">
                            <?php echo $text ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
        <?php if ($video = get_field('video')): ?>
            <section class="video__section about-video__section">
                <div class="grid-container">
                    <div class="video__wrapper">
                        <video autoplay muted loop>
                            <source src="<?php echo esc_url($video["url"]) ?>" type="video/mp4">
                        </video>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php get_template_part('parts/review'); ?>
        <?php get_template_part('parts/options') ?>
        <div class="page__anchor-wrapper about__anchor">
            <div class="page__anchor">
                <a href="#top">
                    <i class="fa-solid fa-arrow-up"></i>
                    <div>Go Back To Top</div>
                </a>
            </div>
        </div>
    </main>

<?php get_footer(); ?>