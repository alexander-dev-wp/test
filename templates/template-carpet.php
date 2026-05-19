<?php
/**
 * Template Name: Carpet Page
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

        <?php get_template_part('parts/accordion'); ?>
        <?php get_template_part('parts/process'); ?>
        <?php get_template_part('parts/showroom'); ?>
        <?php get_template_part('parts/faq'); ?>
        <div class="page__anchor-wrapper carpet__anchor">
            <div class="page__anchor">
                <a href="#top">
                    <i class="fa-solid fa-arrow-up"></i>
                    <div>Go Back To Top</div>
                </a>
            </div>
        </div>
    </main>

<?php get_footer(); ?>