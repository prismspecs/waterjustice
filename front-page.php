<?php
/*
Template Name: Front Page
*/
get_header(); // Include the header template
?>

<?php

// get ACF image_overlay_text
$image_overlay_text_1 = get_field('image_overlay_text_1');
$image_overlay_text_2 = get_field('image_overlay_text_2');
$image_secondary_text = get_field('image_overlay_secondary_text');
$image_overlay_text_url = get_field('image_overlay_text_url');

$image_id = get_field('hero_image');
$image_url = wp_get_attachment_url($image_id);

?>

<!-- HERO -->

<section class="hero" style="background-image:url(<?php echo $image_url; ?>)">
    <div class="hero-text">
        <!-- link all this if $image_overlay_text_url exists -->
        <?php if ($image_overlay_text_url): ?>
            <a href="<?php echo $image_overlay_text_url; ?>">
            <?php endif; ?>
            <h1><?php echo $image_overlay_text_1; ?></h1>
            <!-- if there is a 2nd overlay test -->
            <?php if ($image_overlay_text_2): ?>
                <h1><?php echo $image_overlay_text_2; ?></h1>
            <?php endif; ?>
            <!-- if there is a secondary text -->
            <?php if ($image_secondary_text): ?>
                <?php echo $image_secondary_text; ?>
            <?php endif; ?>
            <?php if ($image_overlay_text_url): ?>
            </a>
        <?php endif; ?>

    </div>
    <div class="hero-caption">
        <?php display_photo_attribution(false, $image_id); ?>
    </div>
</section>


<!-- QUOTE -->
<!-- <section class="flex">
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
</section> -->


<!-- WATER STORIES CAROUSEL SWIPER -->

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

                    // skip if it has the tag carousel-hide
                    if (has_tag('hide-carousel', $post)) {
                        continue;
                    }

                    $the_author = get_field('author_selection');
                    $the_author_name = $the_author->post_title;
                    $the_author_id = $the_author->ID;

                    ?>

                    <div class="swiper-slide padding-wrapper">
                        <a href="<?php the_permalink(); ?>">
                            <div class="water-story">
                                <!-- <div class="story-shadow"></div> -->
                                <div class="water-story-image" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'medium_large'); ?>');"></div>

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
                                        <?php echo $the_author_name; ?>
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



<!-- ABOUT WATER SEDIMENTATION -->
<?php
$post_id = 547;
$queried_post = get_post($post_id);
?>
<section class="spread image-with-text" id="menu_sedimentation">

    <!-- div with background image of featured image in post -->
    <div class="inner-spread" style="background-image: url('<?php echo get_the_post_thumbnail_url($post_id); ?>');">

        <div class="notfull" style="text-shadow: 2px 2px 3px #000000;">
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


<!-- INDEX -->
<section class="index-section" id="menu_index">
    <div class="index-container">
        <div class="index-menu">
            <?php display_water_stories_index(); ?>
        </div>
        <div class="index-content">
            <!-- Filtered posts will be displayed here -->
        </div>
    </div>
</section>


<!-- ABOUT WATER INTELLIGENCE PROJECT -->
<?php
$post_id = 181;
$queried_post = get_post($post_id);
?>
<section class="spread image-with-text" id="menu_wip">

    <!-- div with background image of featured image in post -->
    <div class="inner-spread" style="background-image: url('<?php echo get_the_post_thumbnail_url($post_id); ?>');">

        <div class="notfull">
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



<!-- ALL TEXTS -->
<?php if (false): ?>
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
                    echo '<div class="date">' . get_the_date() . '</div>';
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

    <?php endif; ?>

</section>

<?php get_footer(); // Include the footer template 
?>