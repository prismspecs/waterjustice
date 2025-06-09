<?php get_header(); ?>

<?php

// if post has front_page_video ACF
$front_page_video = get_field('front_page_video');

?>

<!-- HERO (regular)-->
<?php if (!$front_page_video): ?>

    <section class="hero" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">

        <div class="single-image-text">
            <h1 class="single-title">
                <?php the_title(); ?>
            </h1>
            <!-- author -->
            <span class="author">
                <?php display_author(); ?>
            </span>
            <!-- date -->
            <span class="date">
                <?php echo get_the_date(); ?>
            </span>

        </div>
    </section>
<?php endif; ?>

<!-- HERO (video) -->
<?php if ($front_page_video): ?>
    <section class="hero">
        <div class="single-image-text">
            <h1 class="single-title">
                <?php the_title(); ?>
            </h1>
            <!-- author -->
            <span class="author">
                <?php display_author(); ?>
            </span>
            <!-- date -->
            <span class="date">
                <?php echo get_the_date(); ?>
            </span>
        </div>
        <video class="hero-video
        " autoplay muted loop playsinline>
            <source src="<?php echo $front_page_video; ?>" type="video/mp4">
        </video>
    </section>
<?php endif; ?>

<div class="single-caption notfull">
    <?php display_photo_attribution(true); ?>
</div>

<!-- <?php if (have_posts()):
    while (have_posts()):
        the_post(); ?> -->
        <div class="text single-post notfull">
            <!-- <div class="center">
                <h2>
                    <?php the_title(); ?>
                </h2>

                <?php display_author(); ?>

            </div> -->

            <!-- insert content -->
            <div class="article">
                <?php the_content(); ?>
            </div>


        </div>

        <div class="notfull back-link-wrapper">
            <a class="back-link" href="../"><i class="fa fa-arrow-left" aria-hidden="true" style="font-size:1rem;"></i>
                back</a>
        </div>


    <?php endwhile; endif; ?>

<?php get_footer(); ?>