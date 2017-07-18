<?php
/*
Template Name: Form Craft
*/
?>

<?php get_header(); ?>

<div class="ui container cd-margem">

  <div style="width: 60%; display: inline-block;">
  
    <?php
    if ( have_posts() ) : while ( have_posts() ) : the_post();
      the_content();
    endwhile; endif;
    ?>
  
  </div>
  
<img src="http://cd.intranet.sp.senac.br/wp-content/uploads/2016/12/prazo-eventos5.png" width="380" alt="" style="float: right; width: 36%;"> 

</div>

<?php get_footer(); ?>