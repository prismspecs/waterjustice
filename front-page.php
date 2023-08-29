<?php
/*
Template Name: Front Page
*/

get_header(); // Include the header template
?>

<!-- HERO -->
<section class="hero">
    <div class="hero-caption">
        <p>Photo by Artist Names</p>
    </div>
</section>


<!-- QUOTE -->
<section class="flex">
    <div class="quote">
        <p>“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.”</p>
        <p class="author">- Author Name</p>
    </div>
</section>



<!-- PDF DOWNLOADS -->
<section class="flex notfull">
    <div class="pdf-link box3d">
        <i class="fa-solid fa-file-pdf"></i>
        <p>Download the 2nd edition PDF</p>
    </div>
    <div class="pdf-link box3d">
        <i class="fa-solid fa-file-pdf"></i>
        <p>Download PDF #1</p>
    </div>
</section>




<!-- WATER STORIES -->  
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script> -->

<div class="swiper">
        
    <div class="swiper-wrapper">

        <!-- loop through wordpress posts with tag "water-story" -->

        <?php
        // Define the query parameters
        $args = array(
            'post_type' => 'post',         // Change to your custom post type if applicable
            'posts_per_page' => -1,       // To get all posts with the tag
            'tag' => 'water-story',       // The tag slug
        );

        // Create a new query
        $query = new WP_Query($args);

        // Loop through the posts
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
        ?>

                <div class="swiper-slide padding-wrapper">
                    <a href="<?php the_permalink(); ?>">
                        <div class="water-story">
                            <div class="story-shadow"></div>
                                <div class="water-story-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"></div>

                                <div class="water-story-text align-bottom">
                                    <p class="slide-title"><?php the_title(); ?></p>

                                    <p class="slide-author"><?php echo get_the_author(); ?></p>

                                    <p class="slide-date"><?php echo get_the_date(); ?></p>
                                    
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
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"><i class="fa-solid fa-hand-point-left"></i></div>
    <div class="swiper-button-next"><i class="fa-solid fa-hand-point-right"></i></div>

    <!-- If we need scrollbar -->
    <!-- <div class="swiper-scrollbar"></div> -->
</div>



<!-- ABOUT WATER INTELLIGENCE PROJET -->
<section class="notfull wip">
    <div class="test-image"></div>
    <div class="wip-text">
        <h2>Water Intelligence Project</h2>
        <p class="blurb">The Water Intelligence Project (WIP) is a collaborative research project that aims to understand the social, political, and economic dynamics of water in the United States. The project is a collaboration between the University of California, Berkeley, the University of California, Davis, and the University of California, Santa Cruz. The project is funded by the National Science Foundation and the National Institutes of Health.</p>
    </div>
</section>


<!-- TABLE OF CONTENTS -->

<section class="notfull toc">
    <div class="toc-text">
        <h2>Table of Contents</h2>
        <ul>

            <?php
            // Define the query parameters
            $args = array(
                'post_type' => 'post',         // Change to your custom post type if applicable
                'posts_per_page' => -1,       // To get all posts with the tag
                // 'tag' => 'toc',       // should have table of contents tag
            );

            // Create a new query
            $query = new WP_Query($args);

            // Loop through the posts
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
            ?>

                    <!-- make li for each post -->
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>

            <?php
                endwhile;
            endif;

            // Reset the query
            wp_reset_query();
            ?>
        </ul>
    </div>
</section>


<?php get_footer(); // Include the footer template 
?>