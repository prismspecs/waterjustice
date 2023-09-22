<!-- 
    TO DO:
    
    - Generate the emails!
        info@waterjustice.tech.org
        press@waterjustice-tech.org 
        tjd@waterjustice-tech.org 
        matt@waterjustice-tech.org 
        amrah@waterjustice-tech.org
    - add coming soon to vol2
    - on About page "Website developed in collaboration with Grayson Earle" ... and the open source code link

    - make PDF?

 -->

<?php
/*
Template Name: Front Page
*/
get_header(); // Include the header template
?>



<!-- HERO -->
<section class="hero" style="background-image:url(<?php echo get_the_post_thumbnail_url(); ?>)">
    <div class="hero-caption">
        <?php display_photo_attribution(false); ?>
    </div>
</section>


<!-- QUOTE -->
<section class="flex">
    <div class="quote">
        <p id="random-question"></p>
        <script>
            const questions = [
                "Which lives have access to water and why?",
                "How is water justice about more than only equitable access to clean water?",
                "How does tech-driven policy work to deprive water from life? Whose life is sacrificed in this equation?",
                "How did the COVID-19 crisis reinforce water injustice instead of becoming a turning point toward water justice and a catalyst for deep and meaningful change?"
            ];

            // Function to randomly select a sentence
            function getRandomQuestion() {
                const randomIndex = Math.floor(Math.random() * questions.length);
                return questions[randomIndex];
            }

            // Get a random sentence and display it
            const randomQuestion = getRandomQuestion();
            document.getElementById("random-question").textContent = randomQuestion;
        </script>
    </div>
</section>


<!-- WATER STORIES -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script> -->

<div id="menu_stories">
    <div class="swiper">

        <div class="swiper-wrapper">

            <!-- loop through wordpress posts with tag "water-story" -->

            <?php
            // Define the query parameters
            $args = array(
                'post_type' => 'post',
                // Change to your custom post type if applicable
                'posts_per_page' => -1,
                // To get all posts with the tag
                'tag' => 'water-story',
                // The tag slug
            );

            // Create a new query
            $query = new WP_Query($args);

            // Loop through the posts
            if ($query->have_posts()):
                while ($query->have_posts()):
                    $query->the_post();
                    ?>

                    <div class="swiper-slide padding-wrapper">
                        <a href="<?php the_permalink(); ?>">
                            <div class="water-story">
                                <!-- <div class="story-shadow"></div> -->
                                <div class="water-story-image"
                                    style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"></div>

                                <div class="water-story-text align-bottom">
                                    <!-- if the post has a custom field "short_title" -->
                                    <?php if (get_field('short_title')): ?>
                                        <p class="slide-title">
                                            <?php echo get_field('short_title'); ?>
                                        </p>
                                        <!-- otherwise -->
                                    <?php else: ?>
                                        <p class="slide-title">
                                            <?php the_title(); ?>
                                        </p>
                                    <?php endif; ?>

                                    <p class="slide-author">
                                        <?php echo get_field('author'); ?>
                                    </p>

                                    <!-- <p class="slide-date"><?php echo get_the_date(); ?></p> -->

                                </div>
                            </div>
                        </a>
                    </div>

                    <?php
                endwhile;
            endif;

            // Reset the query
            wp_reset_query();
            ?>


        </div>
        <!-- If we need pagination -->
        <!-- <div class="swiper-pagination"></div> -->

        <!-- If we need navigation buttons -->
        <!-- <div class="swiper-button-prev"><i class="fa-solid fa-hand-point-left"></i></div> -->
        <!-- <div class="swiper-button-next"><i class="fa-solid fa-hand-point-right"></i></div> -->

        <!-- If we need scrollbar -->
        <!-- <div class="swiper-scrollbar"></div> -->
    </div>
</div>


<!-- ABOUT WATER INTELLIGENCE PROJET -->
<?php
$post_id = 181;
$queried_post = get_post($post_id);
?>
<section class="wip image-with-text" id="menu_wip">

    <!-- div with background image of featured image in post -->
    <div class="test-image" style="background-image: url('<?php echo get_the_post_thumbnail_url($post_id); ?>');">

        <div class="image-overlay-text notfull">
            <h1 class="clickable-title">
                <!-- link to post -->
                <a href="<?php echo get_permalink($post_id); ?>">
                    <?php echo $queried_post->post_title; ?>
                </a>

            </h1>
            <div class="blurb">
                <!-- echo excerpt -->
                <?php echo $queried_post->post_excerpt; ?>
            </div>

            <?php wp_reset_query(); ?>

        </div>
    </div>
</section>


<!-- PDF DOWNLOADS -->
<?php

// get image URLS
$pdf1_thumbnail_url = wp_get_attachment_url(272);
$pdf2_thumbnail_url = wp_get_attachment_url(273);

// get URL to attachment 263
$pdf1_url = wp_get_attachment_url(263);

?>


<section class="pdf flex notfull" id="menu_reports">
    <div class="pdf-link box3d">
        <!-- <a href=""> -->
        <div class="pdf-link-image" style="background-image:url(<?php echo $pdf2_thumbnail_url; ?>)"></div>
        <!-- </a> -->
        <p>Water Justice & Technology Volume 2 (coming soon)</p>
    </div>
    <div class="pdf-link box3d">
        <a href="<?php echo $pdf1_url; ?>" target="_blank">
            <div class="pdf-link-image" style="background-image:url(<?php echo $pdf1_thumbnail_url; ?>)"></div>
        </a>
        <p>Water Justice & Technology Volume 1 PDF</p>
    </div>
</section>


<!-- TABLE OF CONTENTS -->

<section class="notfull toc" id="toc" style="scroll-padding-top:40px">
    <h1>Table of Contents</h1>
    <div class="toc-text">

        <ul>

            <?php
            // Define the query parameters
            $args = array(
                'post_type' => 'post',
                // Change to your custom post type if applicable
                'posts_per_page' => -1,
                // To get all posts with the tag
                'tag' => 'toc',
                // should have table of contents tag
                'order' => 'ASC',
            );

            // Create a new query
            $query = new WP_Query($args);

            // Loop through the posts
            if ($query->have_posts()):
                while ($query->have_posts()):
                    $query->the_post();

                    $toc_title = get_the_title();
                    // if the post has a custom field "short_title"
                    if (get_field('short_title')) {
                        $toc_title = get_field('short_title');
                    }
                    ?>

                    <!-- make li for each post -->
                    <!-- if it does not have tag section-header -->
                    <?php if (has_tag('water-story', $post)):
                        echo '<ul>';

                    endif; ?>
                    <li>

                        <a href="#go-<?php echo get_the_ID(); ?>" class="scroll-link image-hover toc-link"
                            data-image="<?php echo get_the_post_thumbnail_url(); ?>">
                            <?php echo $toc_title; ?>
                        </a>


                        <!-- <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> -->
                    </li>
                    <?php if (has_tag('water-story', $post)):
                        echo '</ul>';
                    endif; ?>

                    <?php
                endwhile;
            endif;


            ?>
        </ul>
    </div>
</section>


<!-- ALL TEXTS -->
<section class="alltexts">

    <?php
    function display_article($post_id)
    {
        $post = get_post($post_id);

        if ($post) {

            // if post has tag "section-header"            
            if (has_tag('section-header', $post)) {
                echo '<div id="go-' . esc_attr($post->ID) . '" class="text">';

                $img_url = get_the_post_thumbnail_url();
                if ($img_url) {
                    echo '<div class="section-header image-with-text" style="background-image:url(' . $img_url . '">';

                    echo '<div class="image-overlay-text notfull">';

                    // if the post has content
                    if ($post->post_content) {
                        echo '<h1>' . esc_html(get_the_title($post));
                        display_photo_attribution(false);
                        echo '</h1>';
                        echo '<div class="blurb">' . apply_filters('the_content', $post->post_content) . '</div>';
                    } else {
                        echo '<h1 style="margin-bottom:0px">' . esc_html(get_the_title($post)) . '</h1>';
                        display_photo_attribution(false);
                    }


                    echo '</div>';
                    echo '</div>';
                }
            } else {

                echo '<div id="go-' . esc_attr($post->ID) . '" class="text notfull">';
                // if there is a thumbnail
                $img_url = get_the_post_thumbnail_url();
                if ($img_url) {
                    echo '<div class="text-image image-with-text" style="background-image:url(' . $img_url . '">';
                    echo '<div class="image-overlay-text notfull">';
                    // echo '<h1 style="margin-bottom:0px">' . esc_html(get_the_title($post)) . '</h1>';
                    display_photo_attribution(false);
                    echo '</div>';
                    echo '</div>';
                }

                // link to post
                echo '<div class="center">';
                echo '<h1 class="clickable-title">' . '<a href="' . get_permalink($post) . '">' . esc_html(get_the_title($post)) . '</a></h1>';
                echo '</a>';
                display_author();
                echo '</div>';
                echo '<div class="article">' . apply_filters('the_content', $post->post_content) . '</div>';
                echo '</div>';
            }
        }
    }

    function display_posts_by_category($category_slug)
    {

        $query = new WP_Query(
            array(
                'post_type' => 'post',
                'posts_per_page' => -1,
                'category_name' => $category_slug,
                // oldest first
                'order' => 'ASC',
            )
        );



        if ($query->have_posts()):
            while ($query->have_posts()):
                $query->the_post();
                display_article(get_the_ID());
            endwhile;
        endif;

        // Reset the query
        wp_reset_query();
    }

    ?>

    <!-- I've placed the section images/headers in the categories themselves, as in "Water Cities" section is category section-water_cities, but also has the tag section-header, so that I can style it differently. The order is determined by publishing date (oldest first) -->

    <!-- introduction -->
    <?php
    $category_slug = 'section-introduction'; // Replace with the actual category slug
    display_posts_by_category($category_slug);
    ?>

    <!-- section: New Gold Rush -->
    <?php
    $category_slug = 'section-new_gold_rush'; // Replace with the actual category slug
    display_posts_by_category($category_slug);
    ?>

    <!-- section: Water Cities -->

    <?php
    $category_slug = 'section-water_cities'; // Replace with the actual category slug
    display_posts_by_category($category_slug);
    ?>

    <!-- section: Rivers and Aquifers -->
    <?php
    $category_slug = 'section-rivers_aquifers'; // Replace with the actual category slug
    display_posts_by_category($category_slug);
    ?>

    <!-- section: Disaster Tech -->
    <?php
    $category_slug = 'section-disaster_tech'; // Replace with the actual category slug
    display_posts_by_category($category_slug);
    ?>

    <!-- Citation section -->
    <?php
    $category_slug = 'section-end'; // Replace with the actual category slug
    display_posts_by_category($category_slug);
    ?>

</section>

<?php get_footer(); // Include the footer template 
?>