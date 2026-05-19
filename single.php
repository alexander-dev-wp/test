<?php
/**
 * Single
 *
 * Loop container for single post content
 */
get_header(); ?>
    <main class="single__main" id="top">
        <div class="grid-container">
            <?php
            if (function_exists('yoast_breadcrumb')) {
                yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
            }
            ?>

            <div class="single__wrapper">
                <!-- BEGIN of post content -->
                <div class="">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="single">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div title="<?php the_title_attribute(); ?>" class="single__thumbnail entry__thumb">
                                        <?php the_post_thumbnail('large'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="blog__date"><?php the_date() ?></div>
                                <h1 class="page-title entry__title"><?php the_title(); ?></h1>
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
                                        <div class="blog__read"><?php echo $read ?> min read</div>
                                    <?php endif; ?>
                                </div>
                                <div class="entry__content clearfix gb-content">
                                    <?php the_content('', true); ?>
                                </div>
                            </article>
                            <div class="blog__share-bottom hide-for-small-only hide-for-medium-only">
                                <div class="share-box">


                                   <!-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 354 71" fill="none"
                                    ">
                                    <g opacity="0.2">
                                        <g opacity="0.2" filter="url(#filter0_d_446_1052)">
                                            <path d="M138.838 -132.5C179.108 -132.5 217.728 -116.503 246.203 -88.0278C274.678 -59.5526 290.676 -20.9321 290.676 19.3378C290.676 59.6076 274.678 98.2282 246.203 126.703C217.728 155.178 179.108 171.176 138.838 171.176H5.97972C0.955256 171.176 -3.86421 169.183 -7.42206 165.635C-10.9799 162.088 -12.9858 157.274 -13 152.249L-13 19.3378C-13 -20.9321 2.99715 -59.5526 31.4722 -88.0278C59.9474 -116.503 98.5679 -132.5 138.838 -132.5Z"
                                                  fill="white"/>
                                        </g>
                                        <g style="mix-blend-mode:soft-light">
                                            <path d="M202.162 -70.0657C242.432 -70.0657 281.053 -54.0685 309.528 -25.5934C338.003 2.88168 354 41.5022 354 81.7721V214.684C354 219.717 352 224.545 348.441 228.104C344.882 231.664 340.054 233.663 335.02 233.663H202.162C161.885 233.663 123.258 217.663 94.7779 189.183C66.2978 160.703 50.2979 122.076 50.2979 81.7989C50.2979 41.5219 66.2978 2.89455 94.7779 -25.5856C123.258 -54.0657 161.885 -70.0657 202.162 -70.0657Z"
                                                  fill="white"/>
                                        </g>
                                        <g style="mix-blend-mode:exclusion" opacity="0.2">
                                            <path d="M78.6795 170.425C62.4413 147.807 52.756 121.148 50.6892 93.3817C48.6223 65.615 54.2539 37.8161 66.9645 13.0431C79.6751 -11.7299 98.9722 -32.5173 122.733 -47.0323C146.494 -61.5473 173.798 -69.2276 201.641 -69.2282H202.642C227.196 -69.2643 251.388 -63.3007 273.112 -51.8562C285.331 -28.7882 291.379 -2.95296 290.667 23.1417C289.956 49.2363 282.51 74.7039 269.053 97.072C255.595 119.44 236.583 137.949 213.862 150.802C191.141 163.654 165.483 170.414 139.379 170.425H78.6795Z"
                                                  fill="#0A1C8F"/>
                                        </g>
                                    </g>
                                    <defs>
                                        <filter id="filter0_d_446_1052" x="-29" y="-136.5" width="335.676"
                                                height="335.676" filterUnits="userSpaceOnUse"
                                                color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                           values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                                                           result="hardAlpha"/>
                                            <feOffset dy="12"/>
                                            <feGaussianBlur stdDeviation="8"/>
                                            <feColorMatrix type="matrix"
                                                           values="0 0 0 0 0.137255 0 0 0 0 0.0431373 0 0 0 0 0.627451 0 0 0 0.239 0"/>
                                            <feBlend mode="normal" in2="BackgroundImageFix"
                                                     result="effect1_dropShadow_446_1052"/>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_446_1052"
                                                     result="shape"/>
                                        </filter>
                                    </defs>
                                    </svg> -->


                                    <h6 class="share-box__title"><?php _e('Like what you see? Share with a friend.'); ?></h6>
                                    <ul class="share-box__links share-links">
                                        <?php
                                        $share_links = [
                                            'facebook' => 'fa-brands fa-square-facebook',
                                            'twitter' => 'fa-brands fa-square-x-twitter',
                                            'linkedin' => 'fa-brands fa-linkedin',
                                        ];

                                        foreach ($share_links as $network => $icon):
                                            // Skip pinterest if post does not have thumbnail
                                            if ($network == 'pinterest' && !has_post_thumbnail(get_the_ID())) {
                                                continue;
                                            }
                                            ?>
                                            <li class="share-links__item">
                                                <a href="<?php echo get_share_link_url(get_the_ID(), $network); ?>"
                                                   class="share-links__link <?php echo $network !== 'email' ? 'js-share-link' : ''; ?>"
                                                   target="_blank">
                                                    <span class="<?php echo $icon; ?>"></span></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>

                <!-- END of post content -->

                <!-- BEGIN of sidebar -->
                <div class="single__aside">
                    <?php if ($image = get_field('single_image', 'options')): ?>
                        <?php echo wp_get_attachment_image($image['id'], 'full') ?>
                    <?php endif; ?>
                    <div class="entry__share">
                        <?php show_template('share-links'); ?>
                    </div>
                    <div class="page__anchor-wrapper single__anchor hide-for-medium-only hide-for-small-only">
                        <div class="page__anchor">
                            <a href="#top">
                                <i class="fa-solid fa-arrow-up"></i>
                                <div>Go Back To Top</div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- END of sidebar -->
            </div>
            <?php $query_arg = array(
                'post_type' => 'post',
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'posts_per_page' => 3,
                'post_status' => 'publish'
            );
            $the_query = new WP_Query($query_arg);
            if ($the_query->have_posts()) : ?>
                <div class="related__posts">
                    <h5>Related Articles</h5>
                    <div class="related__posts-wrapper">
                        <?php while ($the_query->have_posts()) :
                            $the_query->the_post(); ?>
                            <article>
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large') ?>
                                <?php else: ?>
                                    <img src="<?php echo IMAGE_ASSETS . 'placeholder.jpg' ?>" alt="">
                                <?php endif; ?>
                                <h6><?php the_title(); ?></h6>
                                <div class="related-info-wrapper">
                                    <div><?php the_date('M d') ?></div>
                                    <?php if ($time = get_field('min_read')): ?>
                                        <div class="dot"></div>
                                        <div><?php echo $time ?> min read</div>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif;
            wp_reset_query(); ?>
            <div class="page__anchor-wrapper single__anchor hide-for-large">
                <div class="page__anchor">
                    <a href="#top">
                        <i class="fa-solid fa-arrow-up"></i>
                        <div>Go Back To Top</div>
                    </a>
                </div>
            </div>
        </div>
    </main>

<?php get_footer(); ?>