<?php get_header(); ?>

<!-- HERO -->
<section class="hero" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">

    <div class="single-image-text">
        <h1 class="single-title">
            <?php the_title(); ?>
        </h1>
        <!-- author -->
        <span class="author">
            <?php display_author(); ?>
        </span>
        </h1>

    </div>

</section>

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

        <div class="notfull">
            <a class="back-link" href="../#toc"><i class="fa fa-arrow-left" aria-hidden="true" style="font-size:1rem;"></i>
                back</a>
        </div>


    <?php endwhile; endif; ?>

<?php get_footer(); ?>