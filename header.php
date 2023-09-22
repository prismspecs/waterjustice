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
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400&family=Ubuntu:ital,wght@0,300;0,400;0,500;1,300&display=swap"
        rel="stylesheet">


</head>

<body <?php body_class(); ?>>

    <nav class="navbar">
        <div class="logo">
            <img src="<?php echo get_template_directory_uri(); ?>/images/logo-highDPI-light.png" alt="Logo">
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