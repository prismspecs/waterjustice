<?php
/*
Template Name: Reports
*/
get_header(); // Include the header template
?>

<!-- TOP IMAGE -->
<div class="single-page">
    <div class="nav-darkener" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">

    </div>

    <h1 class="single-page-title">
        <?php the_title(); ?>
    </h1>


    <!-- PDF DOWNLOADS -->
    <?php

    // get image URLS
    $pdf1_thumbnail_url = wp_get_attachment_url(272);
    $pdf2_thumbnail_url = wp_get_attachment_url(273);

    ?>


    <section class="pdf flex notfull" id="menu_reports">
        <div class="pdf-link box3d">
            <a id="toggle-edition-2" href="#section2-toc">
                <div class="pdf-link-image" style="background-image:url(<?php echo $pdf2_thumbnail_url; ?>)"></div>
            </a>
            <p>Water Justice & Technology<br>Edition 2:<br>Relief Remix</p>
        </div>
        <div class="pdf-link box3d">
            <a href="https://waterjustice-tech.org/WJT-edition1.pdf" target="_blank">
                <div class="pdf-link-image" style="background-image:url(<?php echo $pdf1_thumbnail_url; ?>)"></div>
            </a>
            <p>Water Justice & Technology<br>Edition 1 PDF</p>
        </div>
    </section>

    <script>

        // Toggle the visibility of the TOC section 2
        document.getElementById('toggle-edition-2').addEventListener('click', function () {
            document.getElementById('section2-toc').classList.toggle('hidden');
            
        });

    </script>

    <!-- Report 2 - TABLE OF CONTENTS -->

    <section class="notfull toc hidden" id="section2-toc" style="scroll-padding-top:40px">
        <h2>Table of Contents</h2>
        <div class="toc-text">
            <ul>
                <?php
                // Define the query parameters
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => -1,     // Get all posts with the tag
                    'tag' => 'report-2',  // Should have 'toc' tag
                    'order' => 'ASC',
                );

                // Create a new query
                $query = new WP_Query($args);

                // Initialize variables
                $sections = array();
                $current_section = null;

                // Loop through the posts and group them into sections
                if ($query->have_posts()):
                    while ($query->have_posts()):
                        $query->the_post();

                        $toc_title = get_the_title();
                        // If the post has a custom field "short_title"
                        if (get_field('short_title')) {
                            $toc_title = get_field('short_title');
                        }

                        if (!has_tag('water-story', $post)) {
                            // This is a section title
                            $current_section = $toc_title;
                            if (!isset($sections[$current_section])) {
                                $sections[$current_section] = array(
                                    'title' => $toc_title,
                                    'thumbnail_url' => get_the_post_thumbnail_url(),
                                    'posts' => array(),
                                );
                            }
                        } else {
                            // This is a child post
                            if ($current_section !== null) {
                                $sections[$current_section]['posts'][] = array(
                                    'title' => $toc_title,
                                    'permalink' => get_the_permalink(),
                                    'thumbnail_url' => get_the_post_thumbnail_url(),
                                );
                            }
                        }
                    endwhile;
                endif;

                // Output the sections with child posts
                if (!empty($sections)):
                    foreach ($sections as $section) {
                        if (!empty($section['posts'])) {
                            // Output the section title
                            ?>
                            <li>
                                <a href="javascript:void(0);" class="image-hover toc-link toc-section-title"
                                    data-image="<?php echo $section['thumbnail_url']; ?>">
                                    <?php echo $section['title']; ?>
                                </a>
                                <ul>
                                    <?php
                                    // Output the child posts
                                    foreach ($section['posts'] as $post_item):
                                        ?>
                                        <li>
                                            <a href="<?php echo $post_item['permalink']; ?>" class="image-hover toc-link"
                                                data-image="<?php echo $post_item['thumbnail_url']; ?>">
                                                <?php echo $post_item['title']; ?>
                                            </a>
                                        </li>
                                        <?php
                                    endforeach;
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                    }
                endif;

                // Reset Post Data
                wp_reset_postdata();
                ?>
            </ul>
        </div>
    </section>


    <div class="notfull">
        <a class="back-link" href="../"><i class="fa fa-arrow-left" aria-hidden="true" style="font-size:1rem;"></i>
            back</a>
    </div>

</div>
<?php get_footer(); ?>