<?php
/*
Template Name: Catálogo de Peças Tabela
*/
?>

<?php get_header(); ?>

<!-- Busca Catálogo -->

<div class="ui vertical basic segment cd-margem">
  <div class="ui center aligned grid container">
    <div class="column">
      <form class="ui form" method="post" action="https://semantic-ui.clients.ubivox.com/handlers/post/">
        <div class="ui action left icon huge input fluid">
          <i class="search icon"></i>
          <input type="text" placeholder="Pesquisar...">
          <div class="ui secondary huge button">Pesquisar</div>
        </div>
      </form>
    </div>
  </div>
</div>



<div class="ui container cd-margem">
  <table class="ui sortable selectable fixed celled small very padded table">
    <tbody>
      <thead>
      <tr>
        <th>Imagem</th>
        <th>Modalidade</th>
        <th>Título</th>
        <th>Área</th>
        <th>Sub-área</th>
        <th>Visualizar</th>
      </tr>
      </thead>

<!-- loop -->
<!-- Lista de parametros para chamar custom post type -->
	<?php
		$args = array(
			'post_type'		=> 'curso',
			'show_posts'	=> -1,
			'order'			=> 'DESC',
			'orderby'		=> 'date'
		);  
	?>
	<!-- chamo os parametros da variavel args -->
	<?php $query = new WP_Query($args); ?>

	<!-- verifico se tenho posts, se tiver, exibo eles -->
 	<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

      <tr>
        <td><?php the_post_thumbnail('thumbnail'); ?></td>
        <td><?php the_field('modalidade'); ?></td>
        <td><?php the_title(); ?></td>
        <td><?php the_field('area'); ?></td>
        <td><?php the_field('subarea'); ?></td>
        <td class="center aligned"><a href="<?php the_permalink(); ?>"><i class="large green unhide icon"></i></a></td>
      </tr>
      
	<?php endwhile; else: ?>
		<h3>Não possui nenhum curso cadastrado.</h3>
	<?php endif; ?>
	<!-- fim loop -->

    </tbody>
  </table>
</div>

<?php get_footer(); ?>