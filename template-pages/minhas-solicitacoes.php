<?php
/*
Template Name: Minhas Solicitações
*/
?>

<?php get_header(); ?>

<h2 class="ui horizontal divider header" style="margin: 3em 0em 1em;">
  <i class="list layout icon"></i>
  <?php the_title(); ?>
</h2>


<?php

$current_user = wp_get_current_user();

include ( locate_template('template-parts/cd-feed.php') );

$args_final = array(
    'post_type'		=> 'tarefa',
		'post__in' => $allTheIDs,
    'posts_per_page' => -1,
    'author'		=> $cd_author,
);

$wp_query = new WP_Query($args_final);

?>

<div class="ui container center aligned cd-margem" style="width:95%;">

  <?php if ( $wp_query->have_posts() && is_user_logged_in() ) : ?>

	<!-- TABELA TAREFAS -->

	<p><strong>Mostrando as solicitações de:<br></strong><?php echo $current_user->display_name ?></p><br>

  <table class="ui sortable selectable small celled table">
    <tbody>
		<?php get_template_part('template-parts/table-top'); ?>
		<?php while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
  	<?php get_template_part('template-parts/table-body'); ?>
		<?php endwhile; ?>
    </tbody>
  </table>

  <!-- pagination here -->
    <?php
      if (function_exists(custom_pagination)) {
        custom_pagination($custom_query->max_num_pages,"",$paged);
      }
    ?>

	<?php elseif (is_user_logged_in()) : ?>

    <h3 class="ui center aligned icon header">
      <i class="yellow info circle icon"></i>
      Não há solicitações registradas pelo usuário:
    </h3>
    <p><i class="user icon"></i><?php echo $current_user->display_name ?></p>

	<?php else : ?>

    <h3 class="ui center aligned icon header">
      <a href="<?php echo wp_login_url(get_permalink()); ?>"><i class="yellow sign in icon"></i></a>
      Você não está logado.
    </h3>
    <p>Faça <a href="<?php echo wp_login_url(get_permalink()); ?>"><strong>login</strong></a> para continuar.</p>

	<?php endif; ?>

</div>

<?php get_footer(); ?>
