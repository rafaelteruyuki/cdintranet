
<?php get_header(); ?>

<!-- *** SEARCH CURSO *** -->

<div class="ui container">
  <form class="ui form cd-margem" method="get" action="<?php bloginfo('url') ?>" role="search">
    <div class="ui action left icon huge input fluid">
      <i class="search icon"></i>
      <input type="hidden" name="post_type" value="curso">
      <input id="campo-pesquisa" type="search" name="s" placeholder="Pesquisar..." value="<?php echo get_search_query(); ?>">
      <button type="submit" class="ui secondary huge button">Pesquisar</button>
    </div>
  </form>
  <h2><?php printf(esc_html__('Resultados da pesquisa por: %s', ''), '<span><em>'.get_search_query().'</em></span>' ); ?></h2>
</div>

<div class="ui container cd-margem">
<?php if(have_posts()) : ?>

	<div id="cards-container" class="ui four link cards stackable">

	<?php while(have_posts()) : the_post(); ?>
	<!-- CARD -->
	<?php get_template_part( 'template-parts/card' ); ?>
	<?php endwhile; ?>

	</div>

<?php else: ?>

<div class="ui container cd-margem">
	<h3>Não foi encontrado nenhum curso cadastrado.</h3>
</div>

<?php endif; ?>
</div>

<!-- VOLTAR -->
<?php get_template_part( 'template-parts/voltar' ); ?>
<?php get_footer(); ?>
