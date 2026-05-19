<?php
/**
 * Template Name: Area Rugs
 */
get_header(); ?>
    <main>
        <section id="top" class="product__hero-section">
            <div class="product__hero-image">
                <?php the_post_thumbnail() ?>
                <img class="product__hero-vector" src="<?php echo IMAGE_ASSETS . 'product-vector.svg' ?>" alt="product vector">
            </div>
            <div class="grid-container">
                <div class="breadcrumbs__wrapper">
                    <?php
                    if (function_exists('custom_breadcrumbs')) {
                        custom_breadcrumbs();
                    }
                    ?>
                </div>
                <div class="product__hero-wrapper">
                    <div class="product__hero-title">
                        <h1><?php the_title() ?></h1>
                    </div>
                    <div class="product__hero-content text-medium">
                        <?php the_content() ?>
                    </div>
                </div>
                <div class="explore__product-slider">
                    <?php get_template_part('parts/explore-slider'); ?>
                </div>
            </div>
        </section>

        <?php if ($text = get_field('laminate_text')): ?>
            <section class="laminate__text-section area__rugs-text">
                <div class="grid-container">
                    <div class="laminate__text-wrapper">
                        <?php echo $text ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php if ($images = get_field('gallery')): ?>
            <section class="gallery__section">
                <div class="grid-container">
                    <div class="gallery__wrapper">
                        <?php foreach ($images as $image): ?>
                            <div class="gallery__item">
                                <?php echo wp_get_attachment_image($image['id'], 'full_hd', false, array('class' => '')); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php get_template_part('parts/accordion'); ?>
        <?php get_template_part('parts/process'); ?>
        <?php get_template_part('parts/showroom'); ?>
        <?php get_template_part('parts/faq'); ?>
        <div class="page__anchor-wrapper center__anchor area__anchor">
            <div class="page__anchor">
                <a href="#top">
                    <i class="fa-solid fa-arrow-up"></i>
                    <div>Go Back To Top</div>
                </a>
            </div>
        </div>
    </main>

<?php get_footer(); ?>