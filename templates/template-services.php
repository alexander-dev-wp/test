<?php
/**
 * Template Name: Services
 */
get_header(); ?>
    <main>
        <section id="top" class="hero__section services__hero-section">
            <div class="grid-container">
                <div class="text-large">
                    <?php the_content() ?>
                </div>
            </div>
        </section>
        <?php get_template_part('parts/slider'); ?>


        <?php if (have_rows('tab')): ?>
            <section class="tab__section">
                <div class="grid-container">
                    <div class="tab__wrapper">
                        <div class="tab__title-wrapper">
                            <ul class="tabs vertical" data-tabs id="example-tabs" role="tablist">
                                <?php while (have_rows('tab')): the_row(); ?>
                                    <?php $title = get_sub_field('tab_title'); ?>
                                    <?php $icon = get_sub_field('tab_icon'); ?>
                                    <li class="tabs-title <?php echo get_row_index() == 1 ? 'is-active' : ''; ?>">
                                        <a href="#<?php echo sanitize_title($title); ?>" role="tab"
                                           number="<?php echo get_row_index() ?>"
                                           aria-controls="<?php echo sanitize_title($title); ?>"
                                            <?php echo get_row_index() == 1 ? 'aria-selected="true"' : ''; ?>><?php echo $icon ? wp_get_attachment_image($icon["id"], 'full_hd') : '' ?>
                                            <h6><?php echo $title; ?></h6></a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                            <?php if ($link = get_field('finance_link')): ?>
                                <div class="tab__finance-link">
                                    <a target="_blank" href="<?php echo $link["url"] ?>">
                                        <?php $icon = get_field('finance_link_icon') ?>
                                        <?php echo $icon ? wp_get_attachment_image($icon["id"], 'full_hd') : '' ?>
                                        <h6><?php echo $link["title"] ?></h6>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php while (have_rows('tab')): the_row(); ?>
                                <?php $title = get_sub_field('tab_title'); ?>
                                <div class="tab__showroom hide-for-medium-only hide-for-small-only <?php echo get_row_index() == 1 ? 'showroom__active' : '' ?>  tab__showroom-<?php echo get_row_index() ?>">
                                    <?php $background = get_sub_field('tab_showroom_background') ?>
                                    <div class="showroom__wrapper"
                                         style="background: url('<?php echo $background["url"] ?>') no-repeat; background-size: cover">
                                        <div class="showroom__content">
                                            <h4 class="text-medium">Visit Our Showroom Today!</h4>
                                            <?php if ($link = get_sub_field('tab_showroom_link')): ?>
                                                <a href="<?php echo $link["url"] ?>"
                                                   class="showroom__link button__link">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    <span><?php echo $link["title"] ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="tabs-content" data-tabs-content="example-tabs">
                            <?php while (have_rows('tab')): the_row(); ?>
                                <?php $title = get_sub_field('tab_title'); ?>
                                <?php $content = get_sub_field('tab_text'); ?>
                                <?php $link = get_sub_field('tab_link'); ?>
                                <div class="tabs-panel <?php echo get_row_index() == 1 ? 'is-active' : ''; ?>"
                                     role="tabpanel"
                                     id="<?php echo sanitize_title($title); ?>">
                                    <div class="text-medium"><?php echo $content; ?></div>
                                    <?php if ($link): ?>
                                        <div class="tab__link button__link">
                                            <?php acf_link($link) ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($title = get_sub_field('tab_post_title')): ?>
                                        <h5 class="tab__post-title"><?php echo $title ?></h5>
                                    <?php endif; ?>

                                    <?php
                                    $featured_posts = get_sub_field('tab_posts');
                                    if ($featured_posts): ?>
                                        <div class="tab__post-wrapper">
                                            <?php
                                            global $post;
                                            $original_post = $post;
                                            foreach ($featured_posts as $post):
                                                setup_postdata($post)
                                                ?>
                                                <div class="tab__post-item">
                                                    <?php $title = get_the_title($post->ID); ?>
                                                    <?php if (has_post_thumbnail()): ?>
                                                        <div class="tab__post__thumbnail">
                                                            <?php the_post_thumbnail('large') ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="tab__post__thumbnail">
                                                            <img src="<?php echo IMAGE_ASSETS . 'placeholder.jpg' ?>"
                                                                 alt="">
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="tab__post-info">
                                                        <div class="blog__date"><?php the_date(); ?></div>
                                                        <a href="<?php the_permalink() ?>">
                                                            <h5 class=""><?php the_title() ?></h5>
                                                        </a>
                                                        <div class="blog__taxonomy">
                                                            <?php
                                                            $terms = get_the_terms(get_the_ID(), 'blog-topics');
                                                            if ($terms && !is_wp_error($terms)) :
                                                                foreach ($terms as $term) {
                                                                    echo '<div class="blog__term">' . esc_html($term->name) . '</div>';
                                                                }
                                                            endif;
                                                            ?>
                                                            <?php
                                                            $terms = get_the_terms(get_the_ID(), 'guide-and-tools');
                                                            if ($terms && !is_wp_error($terms)) :
                                                                foreach ($terms as $term) {
                                                                    echo '<div class="blog__term">' . esc_html($term->name) . '</div>';
                                                                }
                                                            endif;
                                                            ?>
                                                            <?php if ($read = get_field('min_read')): ?>
                                                                <div class="blog__read"><?php echo $read ?> min read
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach;
                                            wp_reset_postdata();
                                            $post = $original_post;
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="hide-for-large tab__showroom">
                                        <?php $background = get_sub_field('tab_showroom_background') ?>
                                        <div class="showroom__wrapper"
                                             style="background: url('<?php echo $background["url"] ?>') no-repeat; background-size: cover">
                                            <div class="showroom__content">
                                                <h4 class="text-medium">Visit Our Showroom Today!</h4>
                                                <?php if ($link = get_sub_field('tab_showroom_link')): ?>
                                                    <a href="<?php echo $link["url"] ?>"
                                                       class="showroom__link button__link">
                                                        <i class="fa-solid fa-location-dot"></i>
                                                        <span><?php echo $link["title"] ?></span>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <?php if ($video = get_field('video')): ?>
            <section class="video__section">
                <div class="grid-container">
                    <div class="video__wrapper">
                        <video autoplay muted loop>
                            <source src="<?php echo esc_url($video["url"]) ?>" type="video/mp4">
                        </video>
                    </div>
                </div>
            </section>
        <?php endif; ?>
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