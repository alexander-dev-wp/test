<?php
/**
 * Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <!-- Set up Meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta charset="<?php bloginfo('charset'); ?>">

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Remove Microsoft Edge's & Safari phone-email styling -->
    <meta name="format-detection" content="telephone=no,email=no,url=no">
    <!-- Color mobile browser tab -->
    <!--	<meta name="theme-color" content="#4285f4" />-->

    <!-- Add external fonts below (Typekit Only!) -->
    <!--<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@400&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">-->

    <?php wp_head(); ?>


    <script>
        // setTimeout(() => {
        //     (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        //             new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        //         j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        //         'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        //     })(window,document,'script','dataLayer','GTM-MJCX7SR');
        //
        // }, 30000);
    </script>
<!-- Google Tag Manager -->
<!--<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':-->
<!--new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],-->
<!--j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=-->
<!--'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);-->
<!--})(window,document,'script','dataLayer','GTM-MJCX7SR');-->
<!---->
<!---->
<!---->
<!--</script>-->
<!-- End Google Tag Manager -->
</head>

<body <?php  body_class('no-outline'); ?>>

<!-- Google Tag Manager (noscript) -->
<script>
    // setTimeout(() => {
    //     const noscript = document.createElement('noscript');
    //     noscript.innerHTML = '<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MJCX7SR" height="0" width="0" style="display:none;visibility:hidden"></iframe>';
    //     document.body.appendChild(noscript);
    // }, 30000);
</script>
<!--<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MJCX7SR"-->
<!--height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>-->
<!-- End Google Tag Manager (noscript) -->




<?php  wp_body_open(); ?>
<!--<div class="test" style="height: 100vh; width: 100%; background-color: red; font-size: 28px;">-->
<!--    hi world-->
<!--</div>-->

<!-- <div class="preloader hide-for-medium">
	<div class="preloader__icon"></div>
</div> -->
<?php
$link = get_field('sub_header_link', 'options');
$is_activate_hire_link = get_field('activate_hire_link', 'options');
$hiring_arr = get_field('hiring_link', 'options');
?>

<!-- BEGIN of header -->
<header class="header">
    <div class="menu-grid-container">
        <div class="grid-x grid-padding-x align-middle">
            <div class="large-3 medium-12 small-12 cell header__logo-box">
                <div class="header__menu-toggle">
                    <div class="title-bar hide-for-large" data-responsive-toggle="main-menu" data-hide-for="large">
                        <button class="menu-icon" type="button" data-toggle aria-label="Menu" aria-controls="main-menu">
                            <span></span></button>
                    </div>
                </div>
                <div class="logo text-center medium-text-left">
                    <?php show_custom_logo(); ?></span>
                </div>
                <?php $search = get_field('search_link', 'options');
                $contact = get_field('contact_link', 'options');
                ?>
                <?php if ($search || $contact): ?>
                    <div class="hide-for-large mobile__buttons">
                        <?php if ($search): ?>
                            <div class="search__button-mobile">
                                <a href="<?php echo $search["url"] ?>">
                                    <img src="<?php echo IMAGE_ASSETS . 'search.svg' ?>" alt="Search icon">
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($contact): ?>
                            <div class="contact__button-mobile">
                                    <a href="<?php echo $contact["url"] ?>">
                                        <img src="<?php echo IMAGE_ASSETS . 'call.svg' ?>" alt="Call icon">
                                    </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="sub__header hide-for-large">
                <div class="sub__header__wrapper">
                    <?php
                    if ($link || $hiring_arr): ?>
                        <div class="sub__header-links">
                            <?php if ($hiring_arr && $is_activate_hire_link): ?>
                                <a class="sub__hiring-link" href="<?php echo $hiring_arr['url']; ?>"
                                   target="<?php echo $hiring_arr['target']; ?>">
                                    <?php echo $hiring_arr['title']; ?>
                                </a>
                            <?php endif; ?>

                            <a href="<?php $link["url"] ?>">
                                <?php if ($image = get_field('sub_header_link_icon', 'options')): ?>
                                    <span><?php echo wp_get_attachment_image($image["id"], 'full') ?></span>
                                <?php endif; ?>
                                <?php echo $link["title"] ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="large-9 medium-12 small-12 cell menu-wrapper">
                <?php if (has_nav_menu('header-menu')) : ?>
                    <nav class="top-bar" id="main-menu">
                        <div class="hide-for-medium-only hide-for-small-only">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'header-menu',
                                'menu_class' => 'menu header-menu',
                                'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion large-dropdown" data-submenu-toggle="true" data-multi-open="false" data-close-on-click-inside="false">%3$s</ul>',
                                'walker' => new Starter_Navigation()
                            )); ?>
                        </div>
                        <div class="hide-for-large">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'mobile-menu',
                                'menu_class' => 'menu header-menu',
                                'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion large-dropdown" data-submenu-toggle="true" data-multi-open="false" data-close-on-click-inside="false">%3$s</ul>',
                                'walker' => new Starter_Navigation()
                            )); ?>
                        </div>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="sub__header hide-for-medium-only hide-for-small-only">
        <div class="sub__header__wrapper">
            <?php if (has_nav_menu('sub-header-menu')) : ?>
                <nav id="sub-menu" class="hide-for-medium-only hide-for-small-only">
                    <?php wp_nav_menu(array(
                        'theme_location' => 'sub-header-menu',
                        'menu_class' => 'menu header-menu',
                        'items_wrap' => '<ul>%3$s</ul>',
                        'walker' => new Starter_Navigation()
                    )); ?>
                </nav>
            <?php endif; ?>

            <?php if ($link || $hiring_arr): ?>
                <div class="sub__header-links">
                    <?php if ($hiring_arr && $is_activate_hire_link): ?>
                        <a class="sub__hiring-link" href="<?php echo $hiring_arr['url']; ?>"
                           target="<?php echo $hiring_arr['target']; ?>">
                            <?php echo $hiring_arr['title']; ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo $link["url"] ?>">
                        <?php if ($image = get_field('sub_header_link_icon', 'options')): ?>
                            <span><?php echo wp_get_attachment_image($image["id"], 'full') ?></span>
                        <?php endif; ?>
                        <?php echo $link["title"] ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</header>
<!-- END of header -->
