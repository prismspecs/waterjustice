<?php
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup()
{
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'navigation-widgets'));
    add_theme_support('medium_large'); 
    // add_theme_support('woocommerce');
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'blankslate')));
}

add_post_type_support('page', 'excerpt');

add_action('wp_enqueue_scripts', 'blankslate_enqueue');
function blankslate_enqueue()
{
    wp_enqueue_style('swiper-style', "https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css");
    wp_enqueue_style('blankslate-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
    // enqueue swiper.js from CDN

    wp_enqueue_script('swiper-script', "https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js");
    wp_enqueue_script('main-script', get_template_directory_uri() . '/js/main.js');
    wp_enqueue_script('index-filter-script', get_template_directory_uri() . '/js/index-filter.js', array(), null, true);
    wp_enqueue_script('font-awesome', "https://kit.fontawesome.com/7317466e62.js");
    // wp_enqueue_style('load-fa', 'https://use.fontawesome.com/releases/v6.0.0/css/all.css');
}

function display_photo_attribution($do_description, $image_id = null)
{
    if (!$image_id) {
        // Use get_queried_object_id() to get the current post ID
        $post_id = get_queried_object_id();
        $image_id = get_post_thumbnail_id($post_id);
    }

    // If no image ID is found, exit the function
    if (!$image_id) {
        return;
    }

    // Now retrieve the image metadata
    $thumbnail_post = get_post($image_id);
    $thumbnail_title = $thumbnail_post->post_title;
    $thumbnail_caption = $thumbnail_post->post_excerpt;
    $thumbnail_description = $thumbnail_post->post_content;
    $thumbnail_creator = get_post_meta($image_id, 'creator', true);

    // If it has either a creator or description, display it
    if ($thumbnail_creator || $thumbnail_description) {
        echo '<p class="photo-attribution">';
    }

    if ($thumbnail_creator) {
        // Remove any trailing whitespace
        $thumbnail_creator = trim($thumbnail_creator);
        echo esc_html($thumbnail_creator);

        // If there is a description and $do_description is true
        if ($thumbnail_description && $do_description) {
            echo ', ' . esc_html($thumbnail_description);
        }
    }

    // If there is a description but no creator
    if (!$thumbnail_creator && $thumbnail_description) {
        $thumbnail_description = trim($thumbnail_description);
        echo esc_html($thumbnail_description);
    }

    if ($thumbnail_creator || $thumbnail_description) {
        echo '</p>';
    }
}


function display_author()
{

    $the_author = get_field('author_selection');

    // if no author is selected return
    if (!$the_author) {
        return;
    }

    // the_author is a post object, so get its title
    $the_author_name = $the_author->post_title;
    // and post id
    $the_author_id = $the_author->ID;


    // if ID is 299, random chance for swapping author names
    if ($the_author_id == 299) {
        // random chance of 50%
        if (rand(0, 1) == 0) {
            $the_author_name = 'Theodora Dryer and Amrah Salomón';
        } else {
            $the_author_name = 'Amrah Salomón and Theodora Dryer';
        }

    }

    echo '<div class="author">by ';
    echo '<span class="author-hover" data-author-id="' . $the_author_id . '">' . $the_author_name . '</span></div>';

}

// custom field for attachments
function add_custom_attachment_field($form_fields, $post)
{
    $custom_value = get_post_meta($post->ID, 'creator', true);

    // Add your custom field
    $form_fields['custom_attachment_field'] = array(
        'label' => __('Creator'),
        'input' => 'text',
        'value' => esc_attr($custom_value),
    );

    return $form_fields;
}
add_filter('attachment_fields_to_edit', 'add_custom_attachment_field', 10, 2);


function save_custom_attachment_field($attachment_id)
{
    if (isset($_REQUEST['attachments'][$attachment_id]['custom_attachment_field'])) {
        $custom_value = $_REQUEST['attachments'][$attachment_id]['custom_attachment_field'];
        update_post_meta($attachment_id, 'creator', $custom_value);
    }
}
add_action('edit_attachment', 'save_custom_attachment_field');



// add custom post type for author bios
function create_posttype_authors()
{
    register_post_type(
        'authors',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('Authors'),
                'singular_name' => __('Author')
            ),
            'public' => true,
            'has_archive' => false,
            'show_in_rest' => true,
            'rewrite' => array('slug' => 'author'),
        )
    );
}
// Hooking up our function to theme setup
add_action('init', 'create_posttype_authors');


function enqueue_font_awesome()
{
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');


function register_swimming_quotes_block()
{
    error_log('register_swimming_quotes_block function called');

    // Enqueue the block's JavaScript
    wp_enqueue_script(
        'swimming-quotes-block-js',
        get_template_directory_uri() . '/blocks/swimming_quotes/block.js',
        array('wp-blocks', 'wp-element', 'wp-block-editor'), // Updated dependencies
        filemtime(get_template_directory() . '/blocks/swimming_quotes/block.js'),
        true
    );
    error_log('swimming-quotes-block-js enqueued');

    // Enqueue the block's CSS
    wp_enqueue_style(
        'swimming-quotes-block-css',
        get_template_directory_uri() . '/blocks/swimming_quotes/style.css',
        array(),
        filemtime(get_template_directory() . '/blocks/swimming_quotes/style.css')
    );
    // error_log('swimming-quotes-block-css enqueued');
    // error_log('Block JS Path: ' . get_template_directory_uri() . '/blocks/swimming_quotes/block.js');
    // error_log('Block CSS Path: ' . get_template_directory_uri() . '/blocks/swimming_quotes/style.css');
}
add_action('enqueue_block_editor_assets', 'register_swimming_quotes_block');

function swimming_quotes_block_assets()
{
    // Enqueue the JavaScript only on the frontend
    wp_enqueue_script(
        'swimming-quotes-frontend',
        get_template_directory_uri() . '/js/frontend-swimming-quotes.js',
        array(),
        null,
        true
    );

    // Enqueue the CSS for the frontend
    wp_enqueue_style(
        'swimming-quotes-frontend-style',
        get_template_directory_uri() . '/blocks/swimming_quotes/style.css',
        array(),
        null
    );
}

add_action('wp_enqueue_scripts', 'swimming_quotes_block_assets');


// Register Custom Post Type
function register_water_stories_post_type() {
    $labels = array(
        'name'                  => _x('Water Stories', 'Post Type General Name', 'textdomain'),
        'singular_name'         => _x('Water Story', 'Post Type Singular Name', 'textdomain'),
        'menu_name'             => __('Water Stories', 'textdomain'),
        'name_admin_bar'        => __('Water Story', 'textdomain'),
        'archives'              => __('Water Story Archives', 'textdomain'),
        'attributes'            => __('Water Story Attributes', 'textdomain'),
        'parent_item_colon'     => __('Parent Water Story:', 'textdomain'),
        'all_items'             => __('All Water Stories', 'textdomain'),
        'add_new_item'          => __('Add New Water Story', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'new_item'              => __('New Water Story', 'textdomain'),
        'edit_item'             => __('Edit Water Story', 'textdomain'),
        'update_item'           => __('Update Water Story', 'textdomain'),
        'view_item'             => __('View Water Story', 'textdomain'),
        'view_items'            => __('View Water Stories', 'textdomain'),
        'search_items'          => __('Search Water Story', 'textdomain'),
        'not_found'             => __('Not found', 'textdomain'),
        'not_found_in_trash'    => __('Not found in Trash', 'textdomain'),
        'featured_image'        => __('Featured Image', 'textdomain'),
        'set_featured_image'    => __('Set featured image', 'textdomain'),
        'remove_featured_image' => __('Remove featured image', 'textdomain'),
        'use_featured_image'    => __('Use as featured image', 'textdomain'),
        'insert_into_item'      => __('Insert into Water Story', 'textdomain'),
        'uploaded_to_this_item' => __('Uploaded to this Water Story', 'textdomain'),
        'items_list'            => __('Water Stories list', 'textdomain'),
        'items_list_navigation' => __('Water Stories list navigation', 'textdomain'),
        'filter_items_list'     => __('Filter Water Stories list', 'textdomain'),
    );
    $args = array(
        'label'                 => __('Water Story', 'textdomain'),
        'description'           => __('Stories related to water topics', 'textdomain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies'            => array('category', 'post_tag'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-site', // Change this for a different icon
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true, // Enables Gutenberg support
    );
    register_post_type('water_story', $args);
}
add_action('init', 'register_water_stories_post_type', 0);




add_action('wp_footer', 'blankslate_footer');
function blankslate_footer()
{
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const html = document.documentElement;
            const deviceAgent = navigator.userAgent.toLowerCase();
            
            // iOS detection
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                html.classList.add('ios', 'mobile');
            }
            
            // Android detection
            if (deviceAgent.match(/(Android)/)) {
                html.classList.add('android', 'mobile');
            }
            
            // Browser detection
            if (navigator.userAgent.search("MSIE") >= 0) {
                html.classList.add('ie');
            } else if (navigator.userAgent.search("Chrome") >= 0) {
                html.classList.add('chrome');
            } else if (navigator.userAgent.search("Firefox") >= 0) {
                html.classList.add('firefox');
            } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                html.classList.add('safari');
            } else if (navigator.userAgent.search("Opera") >= 0) {
                html.classList.add('opera');
            }
        });
    </script>
    <?php
}
add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep)
{
    $sep = esc_html('|');
    return $sep;
}
add_filter('the_title', 'blankslate_title');
function blankslate_title($title)
{
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}
function blankslate_schema_type()
{
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}
add_filter('nav_menu_link_attributes', 'blankslate_schema_url', 10);
function blankslate_schema_url($atts)
{
    $atts['itemprop'] = 'url';
    return $atts;
}
if (!function_exists('blankslate_wp_body_open')) {
    function blankslate_wp_body_open()
    {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'blankslate_skip_link', 5);
function blankslate_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
}
add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'blankslate_image_insert_override');
function blankslate_image_insert_override($sizes)
{
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}
add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
            'id' => 'primary-widget-area',
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => '</li>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
function blankslate_custom_pings($comment)
{
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <?php echo esc_url(comment_author_link()); ?>
    </li>
    <?php
}
add_filter('get_comments_number', 'blankslate_comment_count', 0);
function blankslate_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}






add_filter('wp_nav_menu_objects', 'my_add_water_stories_categories', 10, 2);

function my_add_water_stories_categories($sorted_menu_items, $args) {
    // Check the menu location; adjust "main-menu" if needed.
    if ($args->theme_location !== 'main-menu') {
        return $sorted_menu_items;
    }

    // Find the "Water Stories" menu item by title
    $water_stories_item_id = null;
    foreach ($sorted_menu_items as $item) {
        if ($item->title === 'Water Stories') {
            $water_stories_item_id = $item->ID;
            break;
        }
    }

    // If no "Water Stories" item found, do nothing
    if (!$water_stories_item_id) {
        return $sorted_menu_items;
    }

    // Example IDs for top-level categories (adjust as needed)
    $category_ids = array(82, 37, 58, 78);

    // Fetch the categories
    $categories = get_terms([
        'taxonomy' => 'category',
        'include'  => $category_ids,
        'hide_empty' => false,
        'orderby'    => 'name',
    ]);

    if (empty($categories) || is_wp_error($categories)) {
        return $sorted_menu_items;
    }

    // Figure out the highest existing menu item ID so we avoid collisions
    $existing_ids = wp_list_pluck($sorted_menu_items, 'ID');
    $max_id = $existing_ids ? max($existing_ids) : 1000;

    // Build up our new menu items from categories
    $new_menu_items = [];
    foreach ($categories as $cat) {
        $new_menu_items = array_merge(
            $new_menu_items,
            my_generate_category_menu_items($cat, $water_stories_item_id, $max_id)
        );
    }

    // Merge the new items with the existing menu array
    return array_merge($sorted_menu_items, $new_menu_items);
}

/**
 * Recursively generate menu items for a category and its children.
 */
function my_generate_category_menu_items($category, $parent_id, &$max_id) {
    $menu_items = [];

    // Find child categories
    $child_categories = get_terms([
        'taxonomy' => 'category',
        'parent'   => $category->term_id,
        'hide_empty' => false,
    ]);

    // Increment the global running ID count for each new menu item
    $menu_item_id = ++$max_id;
    $has_children = (!empty($child_categories) && !is_wp_error($child_categories));

    // Assign classes if this category has children
    $classes = $has_children ? ['menu-item-has-children'] : [];

    // Build the menu item object for this category
    $menu_item = (object) [
        'ID'               => $menu_item_id,
        'db_id'            => $menu_item_id,   // often good to set db_id = ID
        'menu_item_parent' => $parent_id,
        'title'            => $category->name,
        'url'              => get_term_link($category),
        'classes'          => $classes,
        'type'             => 'taxonomy',      // not strictly required, but helpful
        'object'           => 'category',
        'object_id'        => $category->term_id,
        // ... plus any other fields you need
    ];

    // Add this item to the list
    $menu_items[] = $menu_item;

    // Recurse for all child categories, making *this* menu item the parent
    foreach ($child_categories as $child_category) {
        $menu_items = array_merge(
            $menu_items,
            my_generate_category_menu_items($child_category, $menu_item_id, $max_id)
        );
    }

    return $menu_items;
}

function generate_water_stories_index_list($category) {
    $child_categories = get_terms([
        'taxonomy' => 'category',
        'parent'   => $category->term_id,
        'hide_empty' => false,
    ]);

    $has_children = !empty($child_categories) && !is_wp_error($child_categories);
    $li_class = $has_children ? 'class="has-children"' : 'class="is-filterable"';

    $html = '<li ' . $li_class . '>';
    $html .= '<a href="#" data-category-slug="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</a>';

    if ($has_children) {
        $html .= '<ul class="sub-menu">';
        foreach ($child_categories as $child_category) {
            $html .= generate_water_stories_index_list($child_category);
        }
        $html .= '</ul>';
    }

    $html .= '</li>';
    return $html;
}

function display_water_stories_index() {
    $category_ids = array(82, 37, 58, 78); // Same as in the nav menu

    $categories = get_terms([
        'taxonomy' => 'category',
        'include'  => $category_ids,
        'hide_empty' => false,
        'orderby'    => 'name',
    ]);

    if (empty($categories) || is_wp_error($categories)) {
        return;
    }

    echo '<ul class="index-menu-list">';
    // Give the 'All' button the 'is-filterable' class
    echo '<li class="is-filterable"><a href="#" data-category-slug="all">All</a></li>';
    foreach ($categories as $cat) {
        echo generate_water_stories_index_list($cat);
    }
    echo '</ul>';
}

/**
 * Expose ACF 'short_title' field in the REST API for the 'water_story' post type.
 */
function register_acf_rest_fields() {
    register_rest_field(
        'water_story',
        'short_title',
        array(
            'get_callback'    => function( $post ) {
                if ( function_exists( 'get_field' ) ) {
                    return get_field( 'short_title', $post['id'] );
                }
                return null;
            },
            'update_callback' => null,
            'schema'          => null,
        )
    );

    register_rest_field(
        'water_story',
        'author_name',
        array(
            'get_callback'    => function( $post ) {
                if ( function_exists( 'get_field' ) ) {
                    $author_post = get_field( 'author_selection', $post['id'] );
                    if ( $author_post ) {
                        return $author_post->post_title;
                    }
                }
                return null;
            },
            'update_callback' => null,
            'schema'          => null,
        )
    );
}
add_action( 'rest_api_init', 'register_acf_rest_fields' );

/**
 * A one-time script to migrate all standard posts to the 'water_story' custom post type.
 *
 * This script is triggered by visiting the site with the '?migrate_posts=true' query string.
 * It will only run for users with 'manage_options' capabilities (administrators).
 * It copies the post title, content, status, author, excerpt, date, featured image,
 * categories, and tags. It will skip any posts that appear to have been migrated already
 * by checking for an existing 'water_story' with the same title.
 */
function migrate_posts_to_water_stories() {
    // Check if the trigger query parameter is present and the user is an admin
    if (isset($_GET['migrate_posts']) && $_GET['migrate_posts'] === 'true' && current_user_can('manage_options')) {

        // Query all standard posts
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => -1,
            'post_status'    => 'any', // Get all posts regardless of status
        );
        $posts_to_migrate = new WP_Query($args);

        $migrated_count = 0;
        $skipped_count = 0;

        if ($posts_to_migrate->have_posts()) {
            while ($posts_to_migrate->have_posts()) {
                $posts_to_migrate->the_post();
                $original_post_id = get_the_ID();
                $original_post_title = get_the_title();

                // Check if a water story with the same title already exists to prevent duplicates
                $existing_water_story = get_page_by_title($original_post_title, OBJECT, 'water_story');

                if ($existing_water_story) {
                    $skipped_count++;
                    continue; // Skip if it already exists
                }

                // Prepare the new post data
                $new_post_data = array(
                    'post_title'   => $original_post_title,
                    'post_content' => get_the_content(),
                    'post_status'  => get_post_status(),
                    'post_author'  => get_the_author_meta('ID'),
                    'post_excerpt' => get_the_excerpt(),
                    'post_type'    => 'water_story',
                    'post_date'    => get_the_date('Y-m-d H:i:s'),
                );

                // Insert the new post
                $new_post_id = wp_insert_post($new_post_data);

                if ($new_post_id && !is_wp_error($new_post_id)) {
                    $migrated_count++;

                    // Copy the featured image
                    $thumbnail_id = get_post_thumbnail_id($original_post_id);
                    if ($thumbnail_id) {
                        set_post_thumbnail($new_post_id, $thumbnail_id);
                    }

                    // Copy taxonomies (categories and tags)
                    $taxonomies = get_object_taxonomies(get_post_type($original_post_id));
                    foreach ($taxonomies as $taxonomy) {
                        $terms = wp_get_object_terms($original_post_id, $taxonomy, array('fields' => 'slugs'));
                        if (!empty($terms) && !is_wp_error($terms)) {
                            wp_set_object_terms($new_post_id, $terms, $taxonomy, false);
                        }
                    }
                }
            }
            wp_reset_postdata();
        }

        // Display a summary message and stop execution
        wp_die(sprintf(
            '<h1>Post Migration Complete</h1><p>Successfully copied <strong>%d</strong> posts to "Water Stories".</p><p>Skipped <strong>%d</strong> posts because a "Water Story" with the same title already existed.</p><p><a href="%s">Return to the homepage.</a></p>',
            $migrated_count,
            $skipped_count,
            esc_url(home_url('/'))
        ));
    }
}
add_action('init', 'migrate_posts_to_water_stories');
