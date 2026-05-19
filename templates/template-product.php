<?php
/**
 * Template Name: Product
 */
get_header(); ?>
    <main>
        <section class="hero__section" id="top">
            <div class="grid-container">
                <div class="text-large">
                    <?php the_content() ?>
                </div>
            </div>
        </section>
        <?php get_template_part('parts/slider'); ?>
        <?php if (have_rows('products')): ?>
            <?php $counter = 0 ?>
            <section class="products__section">
                <div class="grid-container">
                    <div class="products__wrapper">
                        <?php while (have_rows('products')):the_row(); ?>
                            <?php
                            $image = get_sub_field('image');
                            $text = get_sub_field('text');
                            $sub_text = get_sub_field('image_text');
                            $link = get_sub_field('link');
                            $counter++
                            ?>
                            <div class="product__item <?php echo $counter % 2 == 0 ? 'product__item-left' : 'product__item-right'; ?>">
                                <div class="product__content">
                                    <?php if ($text): ?>
                                        <div class="text-large">
                                            <?php echo $text ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($link): ?>
                                        <a class="product__link button__link" href="<?php echo $link["url"] ?>">
                                            Learn More
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <?php if ($image): ?>
                                    <div class="product__image">
                                        <?php echo wp_get_attachment_image($image["id"], 'full_hd') ?>
                                        <?php if ($sub_text): ?>
                                            <div class="product__image-text">
                                                <?php echo $sub_text ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php get_template_part('parts/showroom') ?>
        <?php get_template_part('parts/google') ?>

        <div class="page__anchor-wrapper product__anchor">
            <div class="page__anchor">
                <a href="#top">
                    <i class="fa-solid fa-arrow-up"></i>
                    <div>Go Back To Top</div>
                </a>
            </div>
        </div>
    </main>

<?php get_footer(); ?>