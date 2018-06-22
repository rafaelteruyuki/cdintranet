<?php
/*
Template Name: Minhas Tarefas
*/

get_header();

// VARIAVEIS TAREFAS
include ( locate_template('template-parts/var-tarefas.php') );

?>

<!-- <div class="urlnew"></div>
<div class="urlold"></div> -->

<script type="text/javascript">

setInterval(url_check, 2000);

var cd_url_old;
var filtros = ['_sfm_unidade', '_sfm_finalidade', '_sfm_area_divulgacao_tarefa', '_sfm_responsavel_1', '_sfm_responsavel_2', '_sfm_responsavel_portal', '_sfm_responsavel_portal_2','_sfm_status'];

function url_check() {

  var cd_url = location.href;

  if (cd_url != cd_url_old) {

    length = filtros.length;
      while(length--) {
        if (cd_url.indexOf(filtros[length])!=-1) {
          $('.cd-filter-on').addClass('green');
      }
    }

  };

  // $('.urlnew').html(cd_url);
  // $('.urlold').html(cd_url_old);

  cd_url_old = cd_url;

}

</script>

<?php if ( current_user_can('edit_pages') ) : ?>

<h2 class="ui horizontal divider header" style="margin: 3em 0em 2em;">
  <i class="list layout icon"></i>
  Minhas tarefas
</h2>

<div class="ui two column grid container stackable" style="width:95% !important;">

  <div class="middle aligned column" style="padding-left:0;">

   <!-- Busca Tarefas -->
    <form class="ui form" method="get" action="<?php bloginfo('url') ?>" role="search">
      <div class="ui icon large input">
        <input type="hidden" name="post_type" value="tarefa">
        <input type="search" name="s" placeholder="Pesquisar tarefas...">
        <i class="search icon"></i>
      </div>
    </form>

  </div>

  <?php
  // $count_naoiniciado = get_post_count_by_meta('status', 'naoiniciado', 'tarefa');
  // $count_cancelado = get_post_count_by_meta('status', 'cancelado', 'tarefa');
  // $count_incompleto = get_post_count_by_meta('status', 'incompleto', 'tarefa');
  // $count_aguardando = get_post_count_by_meta('status', 'aguardandoinformacao', 'tarefa');
  // $count_emproducao = get_post_count_by_meta('status', 'emproducao', 'tarefa');
  // $count_publicado = get_post_count_by_meta('status', 'publicado', 'tarefa');
  // $count_finalizado = get_post_count_by_meta('status', 'finalizado', 'tarefa');
  ?>

  <div class="middle aligned right aligned column" style="padding-right:0;">

  <!-- <a href="<?php // bloginfo('url')?>/index.php/tarefa/?_sfm_status=naoiniciado" class="ui circular label cd-popup" title="Não iniciados"><?// = $count_naoiniciado; ?></a>
  <a href="<?php // bloginfo('url')?>/index.php/tarefa/?_sfm_status=cancelado" class="ui grey circular label cd-popup" title="Cancelados"><?// = $count_cancelado; ?></a>
  <a href="<?php // bloginfo('url')?>/index.php/tarefa/?_sfm_status=incompleto" class="ui red circular label cd-popup" title="Incompletos"><?// = $count_incompleto; ?></a>
	<a href="<?php // bloginfo('url')?>/index.php/tarefa/?_sfm_status=aguardandoinformacao" class="ui orange circular label cd-popup" title="Aguardando informação"><?// = $count_aguardando; ?></a>
	<a href="<?php // bloginfo('url')?>/index.php/tarefa/?_sfm_status=emproducao" class="ui yellow circular label cd-popup" title="Em produção"><?// = $count_emproducao; ?></a>
  <a href="<?php // bloginfo('url')?>/index.php/tarefa/?_sfm_status=publicado" class="ui olive circular label cd-popup" title="Publicados"><?// = $count_publicado; ?></a>
	<a href="<?php // bloginfo('url')?>/index.php/tarefa/?_sfm_status=finalizado" class="ui green circular label cd-popup" title="Finalizados"><?// = $count_finalizado; ?></a>
  <a href="<?php // bloginfo('url')?>/index.php/tarefa" class="ui black circular label cd-popup" title="Todos"><?php // $count_posts = wp_count_posts('tarefa'); $published_posts = $count_posts->publish; echo $published_posts; ?></a> -->

    <div class="ui large buttons" style="margin: 0 10px">
      <a data-tooltip="Filtros" class="ui icon cd-filtro button tarefas cd-filter-on">
        <i class="filter icon"></i>
      </a>
      <a data-tooltip="Limpar" href="<?php bloginfo('url'); ?>/minhas-tarefas" class="ui icon button">
        <i class="undo icon"></i>
      </a>
    </div>

    <!-- TABS -->
    <!-- <div class="ui large buttons cd-tab">
      <a data-tooltip="Tarefas" class="ui icon button item active" data-tab="first">
        <i class="list layout icon"></i>
      </a>
      <a data-tooltip="Designers" class="ui icon button item" data-tab="second">
        <i class="dashboard icon"></i>
      </a>
    </div> -->

  </div>

</div>

<!-- PRIMEIRA TAB -->



<div class="ui tab active" data-tab="first">

<div class="ui container center aligned cd-margem" style="width:95%;" id="filtro-tarefas"><!-- Colocar o ID no plugin -->

  <?php

    // CD-FEED
    include ( locate_template('template-parts/cd-feed.php') );

    $args['search_filter_id'] = 2817;

  $wp_query = new WP_Query( $args );

  if ( $wp_query->have_posts() ) : ?>

	<!-- TABELA TAREFAS -->

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

	<?php else : ?>
	<h3 class="ui center aligned header cd-margem">Não há tarefas para o filtro selecionado.</h3>
<?php endif; wp_reset_postdata(); ?>

</div>

</div><!-- FIM PRIMEIRA TAB -->

<!-- SEGUNDA TAB -->

<div class="ui tab" data-tab="second">

<div class="ui container cd-margem" style="width:95% !important;">

  <table class="ui very basic table center aligned large">
    <thead>
      <tr>
        <th class="left aligned">Designer</th>
        <th>Não Iniciadas</th>
        <th style="color:#f2711c;">Aguardando</th>
        <th style="color:#fbbd08;">Em Produção</th>
        <th style="color:#21ba45;">Finalizadas</th>
      </tr>
    </thead>
    <tbody>

<?php
$user_query = new WP_User_Query( array( 'role' => 'designer' ) );
?>

<?php
  if (!empty($user_query->results)): foreach ( $user_query->results as $user ):

    $naoiniciado = 0;
    $aguardandoinformacao = 0;
    $emproducao = 0;
    $finalizado = 0;


    $args = array(
      'post_type'		  => 'tarefa',
			'show_posts'	  => -1,
			'order'		    	=> 'DESC',
			'orderby'	    	=> 'date',
			'meta_key'  		=> 'responsavel_1',
			'meta_value'  	=> $user->ID
      );

  $userTask = new WP_Query($args);
  if ( $userTask->have_posts() ):
    while ( $userTask->have_posts() ) : $userTask->the_post();
      $status = get_field('status');
      switch ($status['value']) {
					case "naoiniciado":
							$naoiniciado++;
							break;
          case "aguardandoinformacao":
							$aguardandoinformacao++;
							break;
          case "emproducao":
							$emproducao++;
							break;
          case "finalizado":
							$finalizado++;
							break;
			}
    endwhile;
  endif
    ?>
      <tr>
        <td class="left aligned">
            <h4 class="ui image header">
            <span class="ui mini rounded image"><?php echo get_avatar( $user->ID, 32 ); ?></span>
            <div class="content"><?= $user->display_name ?></div>
            </h4>
        </td>
        <td class="naoiniciado"><?= $naoiniciado ?></td>
        <td class="aguardandoinformacao"><?= $aguardandoinformacao ?></td>
        <td class="emproducao"><?= $emproducao ?></td>
        <td class="finalizado"><?= $finalizado ?></td>
      </tr>
<?php
	endforeach;
  endif;
?>
    </tbody>
  </table>

</div>

</div>

<script>

function somaTotal(classe){
  var tagsValue = $('.' + classe);
  var value = 0;
  tagsValue.each(function(){
    value += parseInt($(this).text());
  });

  return value;
}

$('#totalNaoIniciado').text(somaTotal('naoiniciado'));
$('#totalAguardando').text(somaTotal('aguardandoinformacao'));
$('#totalEmProducao').text(somaTotal('emproducao'));
$('#totalConcluido').text(somaTotal('finalizado'));

</script>

<?php else : ?>

  <h2 class="ui horizontal divider header" style="margin: 3em 0em 2em;">
    <i class="list layout icon"></i>
    Minhas tarefas
  </h2>

  <div class="ui container center aligned cd-margem">

    <h3 class="ui center aligned icon header">
      <a href="<?php echo wp_login_url(get_permalink()); ?>"><i class="yellow sign in icon"></i></a>
      Você não tem permissão para acessar essa página.
    </h3>
    <p>Faça <a href="<?php echo wp_login_url(get_permalink()); ?>"><strong>login</strong></a> com um usuário específico para continuar.</p>

  </div>

<?php endif; ?>

<?php get_footer(); ?>
