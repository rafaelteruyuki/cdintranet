<?php
/*
Template Name: Catálogo de Peças
*/
?>

<?php get_header(); ?>

<!-- Busca Catálogo -->

<div class="ui basic segment">
  <div class="ui center aligned container">
    <h2 class="ui center aligned header" style="margin:2em 0;">
      <i class="grid layout icon"></i><?php the_title(); ?>
    </h2>
    <form class="ui form" method="get" action="<?php bloginfo('url') ?>" role="search">
      <div class="ui action left icon huge input fluid">
        <i class="search icon"></i>
        <input type="hidden" name="post_type" value="curso">
        <input id="campo-pesquisa" type="search" name="s" placeholder="Pesquisar...">
        <button type="submit" class="ui secondary huge button">Pesquisar</button>
      </div>
    </form>
  </div>
</div>

<div class="ui horizontal container divider cd-margem">Filtros</div>

<!-- Filtros Catálogo -->
<form class="ui form">
<div class="ui four column grid container stackable cd-margem">

    <div class="column">
    <div class="ui fluid labeled icon dropdown button">
      <input type="hidden" name="modalidade" value="0">
      <i class="filter icon"></i>
      <span class="text">Modalidade</span>
      <div class="menu">
        <div class="item" data-value="0">Modalidade</div>
        <?php
          $modalidadeField = get_field_object('field_57dc6b7aee452');
          foreach($modalidadeField['choices'] as $value=>$label):?>
            <div class="item" data-value="<?php echo $value ?>"><?php echo $label ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="ui fluid labeled icon dropdown button">
      <input type="hidden" name="area" value="0">
      <i class="filter icon"></i>
      <span class="text">Área</span>
      <div class="menu">
        <div class="item" data-value="0">Área</div>
        <?php
        $areaField = get_field_object('field_57dc5e9a84f9d');
        foreach ($areaField['choices'] as $value=>$label): ?>
          <div class="item" data-value="<?php echo $value ?>"><?php echo $label ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="ui fluid labeled icon dropdown button" id="menu-subarea">
      <input type="hidden" name="subarea" value="0">
      <i class="filter icon"></i>
      <span class="text">Subárea</span>
      <div class="menu">
        <div class="item" data-value="0">Subárea</div>
    </div>
    </div>
  </div>

  <div class="column">
  	<a class="ui fluid labeled icon secondary button" href="<?php bloginfo("url");?>">
      <i class="undo icon"></i>
      <span class="text">Limpar Filtros</span>
    </a>
  </div>

</div>

</form>

<!-- Novo filtro
<a data-tooltip="Filtros" class="ui icon cd-filtro button cursos">
	<i class="filter icon"></i>
</a>-->

<!-- CATALOGO DE PEÇAS -->
<div class="ui container cd-margem">

	<?php

    $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;

		$args = array(
			'post_type'		=> 'curso',
			'posts_per_page'	=> 32,
			'order'			=> 'DESC',
			'orderby'		=> 'date',
      'paged'	=>	$paged
		);
	?>

  <?php
  $wp_query = new WP_Query( $args );

  //use the query for paging
  $wp_query->query_vars[ 'paged' ] > 1 ? $current = $wp_query->query_vars[ 'paged' ] : $current = 1;

  //set the "paginate_links" array to do what we would like it it. Check the codex for examples http://codex.wordpress.org/Function_Reference/paginate_links
  $pagination = array(
      'base' => @add_query_arg( 'paged', '%#%' ),
      //'format' => '',
      'showall' => false,
      'end_size' => 4,
      'mid_size' => 4,
      'total' => $wp_query->max_num_pages,
      'current' => $current,
      'type' => 'plain'
  );

  //build the paging links
  if ( $wp_rewrite->using_permalinks() )
      $pagination[ 'base' ] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

  //more paging links
  if ( !empty( $wp_query->query_vars[ 's' ] ) )
      $pagination[ 'add_args' ] = array( 's' => get_query_var( 's' ) );

  ?>

 	<?php if ( $wp_query->have_posts() ) :?>

  <div id="cards-container" class="ui four link cards stackable">

    <?php while ( $wp_query->have_posts() ) : $wp_query->the_post();?>
    <!-- CARD -->
  	<?php get_template_part( 'template-parts/card' ); ?>
  	<?php endwhile; ?>

  </div>

  <!-- PAGINACAO -->
  <div class="ui center aligned container cd-margem">
    <?php echo '<div class="cd-paginacao">' . paginate_links($pagination) . '</div>'; ?>
  </div>

  <?php else: ?>
	<h3>Nenhum curso cadastrado com os filtros selecionados.</h3>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
