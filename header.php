<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php wp_title(); ?>
    </title>
    <?php wp_head(); ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

</head>

<body <?php body_class(); ?>>
    <main>

    <nav class="navbar">
        <div class="logo">
            <!-- <img class="desktop-logo" src="<?php echo get_template_directory_uri(); ?>/images/logo-desktop-light.png">
            <img class="mobile-logo" src="<?php echo get_template_directory_uri(); ?>/images/logo-mobile-light.png"> -->
            <img class="" src="<?php echo get_template_directory_uri(); ?>/images/logo-twolines-light.png">
        </div>

        <nav class="nav-container">
            <div class="menu-toggle">
                <span class="toggle-icon"></span>
            </div>
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'main-menu',
                    'container' => 'div',
                    'container_class' => 'menu-items',
                    'menu_class' => 'nav-menu',
                )
            );
            ?>
        </nav>
    </nav>

    <nav class="navbar-dropper">
        <div class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/images/wjt.png" alt="Logo">
        </div>
        <nav class="nav-container-dropper">
            <div class="menu-toggle-dropper">
                <span class="toggle-icon"></span>
            </div>
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'main-menu',
                    'container' => 'div',
                    'container_class' => 'menu-items-dropper',
                    'menu_class' => 'nav-menu',
                )
            );
            ?>
        </nav>
    </nav>

    <!-- FOOTNOTE HOVER OVERLAY -->
    <div id="footnote-overlay"></div>
    <div id="author-overlay"></div>
    <div id="fullcover"></div>