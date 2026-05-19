<?php
/**
 * Home
 *
 * Standard loop for the blog-page
 */
get_header(); ?>

    <main>
       
        <?php
        $subtitle = get_field('blog_subtitle', 'options');
        $title = get_field('blog_title', 'options'); 
        ?>
        <?php if ($subtitle || $title): ?>
            <section class="blog__hero-section" id="top">
                <div class="grid-container">
                    <div class="blog__hero-wrapper">
                        <?php if ($subtitle): ?>
                            <div class="subtitle blog__subtitle"><?php echo $subtitle ?></div>
                        <?php endif; ?>
                        <?php if ($title): ?>
                            <h1 class="blog__title"><?php echo $title ?></h1>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
        test 2
        <?php
        $arg = array(
            'post_type' => 'post',
            'order' => 'DESK',
            'orderby' => 'date',
            'posts_per_page' => 6,
        );
        $the_query = new WP_Query($arg);
        if ($the_query->have_posts()) : ?>
            <section class="blog__section">
                <div class="grid-container">
                    <div class="search__wrapper">
                        <div class="blog__trend">
                            <?php
                            $terms = get_field('trending_topics', 'options');
                            $toolterms = get_field('trending_tools', 'options');
                            if ($terms || $toolterms): ?>
                                <div class="blog__trend-title">Trending Topics</div>
                                <div class="blog__trend-wrapper">
                                    <?php if ($terms): ?>
                                        <?php foreach ($terms as $term): ?>
                                            <button class="btn-topic" data-value="<?php echo esc_attr($term->slug); ?>">
                                                <?php echo esc_html($term->name); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if ($toolterms): ?>
                                        <?php foreach ($toolterms as $term): ?>
                                            <button class="btn-tools" data-value="<?php echo esc_attr($term->slug); ?>">
                                                <?php echo esc_html($term->name); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="blog__search">
                            <input placeholder="search..." type="text" id="search_blog">
                            <i class="blog__search-button fa-solid fa-arrow-right"></i>
                        </div>
                    </div>
                    <div class="blog__wrapper">
                        <div class="blog__filters">
                            <?php
                            $terms = get_terms([
                                'taxonomy' => 'blog-topics',
                            ]);

                            if (!empty($terms) && !is_wp_error($terms)) {
                                echo '<div class="blog__topics">
<div class="blog__taxonomy-title">Blog Topics</div>';
                                ?>

                                <?php foreach ($terms as $term): ?>
                                    <button class="btn-topic" data-value="<?php echo esc_attr($term->slug); ?>">
                                        <?php echo esc_html($term->name); ?>
                                    </button>
                                <?php endforeach; ?>
                                <?php
                                echo '</div>';
                            }
                            ?>

                            <?php
                            $terms = get_terms([
                                'taxonomy' => 'guide-and-tools',
                            ]);

                            if (!empty($terms) && !is_wp_error($terms)) {
                                echo '<div class="blog__tools">
<div class="blog__taxonomy-title">Guide and Tools</div>';
                                ?>
                                <?php foreach ($terms as $term): ?>
                                    <button class="btn-tools" data-value="<?php echo esc_attr($term->slug); ?>">
                                        <?php echo esc_html($term->name); ?>
                                    </button>
                                <?php endforeach; ?>
                                <?php
                                echo '</div>';
                            }
                            ?>

                        </div>

                        <div class="blog__pagination-wrapper">
                            <div class="blog__scroll-wrapper">
                                <div class="blog__item-wrapper ajax-overlay">
                                    <?php while ($the_query->have_posts()) :
                                        $the_query->the_post(); ?>
                                        <article class="blog__item">
                                            <div class="blog__content">
                                                <div class="blog__date"><?php the_date(); ?></div>
                                                <a href="<?php the_permalink() ?>"><h5><?php the_title() ?></h5></a>
                                                <div class="blog__text">
                                                    <?php echo wp_trim_words(get_the_content(), 27, ''); ?>
                                                </div>
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
                                            </div>
                                            <div class="blog__thumbnail">
                                                <?php if (has_post_thumbnail()): ?>
                                                    <?php the_post_thumbnail('large') ?>
                                                <?php else: ?>
                                                    <img src="<?php echo IMAGE_ASSETS . 'placeholder.jpg' ?>" alt="">
                                                <?php endif; ?>
                                            </div>
                                        </article>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <div class="blog__pagination"></div>
                        </div>

                    </div>

                    <div class="page__anchor-wrapper blog__anchor">
                        <div class="page__anchor">
                            <a href="#top">
                                <i class="fa-solid fa-arrow-up"></i>
                                <div>Go Back To Top</div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <i class="fa-solid fa-angle-up"></i>
            <i class="fa-solid fa-angle-down"></i>
        <?php endif; ?>



    </main>
    <script>
        jQuery(document).ready(function ($) {

            function filter(page = 1) {
                var blogTopics = $('.btn-topic.active').map(function () {
                    return $(this).data('value');
                }).get()
                var blogTools = $('.btn-tools.active').map(function () {
                    return $(this).data('value');
                }).get()

                let ammountOfPosts = window.innerWidth < 1024 ? 3 : 6
                var searchBlog = $('#search_blog').val();
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'filter_events',
                        blogTopics: blogTopics,
                        blogTools: blogTools,
                        searchBlog: searchBlog,
                        paged: page,
                        ammountOfPosts: ammountOfPosts
                    },
                    beforeSend: function () {
                        $('.blog__item-wrapper').addClass('ajax-overlay--active')
                    },
                    success: function (response) {
                        $('.blog__item-wrapper').html(response.posts);
                        $('.blog__pagination').html(response.pagination);
                        $('.blog__pagination li').removeClass('active');
                        $(`.blog__pagination a[data-page="${page}"]`).parent().addClass('active');

                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.error(xhr.responseText);
                    },
                    complete: function () {
                        $('.blog__item-wrapper').removeClass('ajax-overlay--active')
                        $(".blog__scroll-wrapper").mCustomScrollbar("update");
                    },
                });


            }

            $('#search_blog').on('keypress', function (e) {
                if (e.which === 13) {
                    filter();
                }
            });
            $('.blog__search-button').on('click', function () {
                filter();
            });

            $('.btn-topic, .btn-tools').on('click', function () {
                $(this).toggleClass('active');
                filter();
            });



            $(document).on('click', '.blog__pagination a', function (e) {
                e.preventDefault();
                var page = $(this).data('page');
                filter(page);
            });
            filter();
        })
    </script>

<?php get_footer(); ?>