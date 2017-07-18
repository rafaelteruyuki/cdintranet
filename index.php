<?php get_header(); ?>

<!--Index.php-->

<?php while ( have_posts() ) : the_post() ?>
<?php the_content(); ?>
<?php endwhile; ?>

<?php get_footer(); ?>