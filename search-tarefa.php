
<?php get_header(); ?>

<!-- *** SEARCH TAREFA *** -->

<h2 class="ui horizontal divider header" style="margin: 3em 0em 2em;">
  <i class="list layout icon"></i>
  Tarefas
</h2>

<div class="ui two column grid container stackable" style="width:95% !important;">

  <div class="top aligned column" style="padding-left:0;">

   <!-- Busca Tarefas -->
    <form class="ui form" method="get" action="<?php bloginfo('url') ?>" role="search">
      <div class="ui icon large input">
        <input type="hidden" name="post_type" value="tarefa">
        <input type="search" name="s" placeholder="Pesquisar tarefas..." value="<?php echo get_search_query() ?>">
        <i class="search icon"></i>
      </div>
    </form>
    <h2><?php printf(esc_html__('Resultados da pesquisa por: %s', ''), '<span><em>'.get_search_query().'</em></span>' ); ?></h2>

  </div>

</div>

<div class="ui container center aligned cd-margem" style="width:95%;">

  <?php if(have_posts()) : ?>

	<!-- TABELA TAREFAS -->

  <table class="ui sortable selectable small celled table">
    <tbody>
		<?php get_template_part('template-parts/table-top'); ?>
		<?php while(have_posts()) : the_post(); ?>
  	<?php get_template_part('template-parts/table-body'); ?>
		<?php endwhile; ?>
    </tbody>
  </table>

	<?php else : ?>

    <h3 class="ui center aligned header cd-margem">Não foram encontrados resultados para a sua busca.</h3>

	<?php endif; ?>

</div>

<!-- VOLTAR -->
<?php get_template_part( 'template-parts/voltar' ); ?>

<?php get_footer(); ?>
