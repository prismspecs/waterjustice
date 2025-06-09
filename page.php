<?php get_header(); ?>

<!-- TOP IMAGE -->
<div class="single-page">
    <div class="nav-darkener" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');">

    </div>

    <h1 class="single-page-title">
        <?php the_title(); ?>
    </h1>


    <!-- insert content -->
    <div class="content notfull">
        <?php the_content(); ?>
    </div>



    <div class="notfull">
        <a class="back-link" href="../#toc"><i class="fa fa-arrow-left" aria-hidden="true" style="font-size:1rem;"></i>
            back</a>
    </div>

</div>
<?php get_footer(); ?>