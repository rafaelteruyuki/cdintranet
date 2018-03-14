<?php
/*
Template Name: Exportar Tarefas
*/
?>

<?php get_header(); ?>

<h2 class="ui horizontal divider header" style="margin: 3em 0em 1em;">
  <i class="list layout icon"></i>
  <?php the_title(); ?>
</h2>

<?php if ( current_user_can('portal') || current_user_can('administrator') ) : ?>

<style media="screen">

.content{display: none;}

#bg-preloader{
  position: fixed;
  z-index: 100;
  width: 100%;
  height: 100%;
  background-color: #2185d0;
  top: 0px;
  left: 0px;
}
#preloader {
  position: fixed;
  top: 50%;
  left: 50%;
  width: 500px;
  height: 200px;
  margin-top: -100px;
  margin-left: -250px;
  z-index: 101;
  text-align: center;
}
</style>

<script type="text/javascript">
$(function() {
  $('#preloader').fadeOut(500, function() {
    $(this).remove();
  });
  $('#bg-preloader').fadeOut(500, function() {
    $(this).remove();
  });
})
</script>

<div id="bg-preloader">
  <div id="preloader">
    <img src="<?php bloginfo('template_url'); ?>/images/45.svg"><br><br>
    <p style="color:#FFF";>Exportando...</p>
  </div>
</div>

<div class="ui center aligned container cd-margem">
  <a class="ui green labeled icon huge button export">
    <i class="download icon"></i>
    Baixar planilha
  </a>
</div>

<?php

global $current_user;

include ( locate_template('template-parts/cd-feed.php') );

$args = array(
  'post_type'              => 'tarefa',
  'posts_per_page'         => -1,
  'order'                  => 'DESC',
  // 'orderby'                => 'modified',
  // 'author'                 => $feed_rc,
  // 'meta_query'             => array( $feed_cd ),
  // 'meta_query'             => array(
  //   array(
  //     'key'		=> 'publicacao_pecas',
  //     'value'		=> '"publicacao"',
  //     'compare' => 'LIKE'
  //   ),
  // ),
);

$query = new WP_Query( $args );

?>

<div class="cd-margem content" id=table_wrapper>

  <?php if ( $query->have_posts() ) : ?>

	<!-- TABELA TAREFAS -->

  <table border="1">

      <thead>
        <tr>
          <th>Unidade</th>
          <th>Finalidade</th>
          <th>Modalidade do Curso</th>
          <th>Publicação / Peças</th>
          <th>Nº atividades</th>
          <th>Título</th>
          <th>Área</th>
          <th>Sub-área</th>
          <th>Data da solicitação</th>
          <th>Data início evento / curso</th>
          <th>Previsão publicação</th>
          <th>Previsão peças</th>
          <th>Tipo de criação</th>
          <th>Designer 1</th>
          <th>Designer 2</th>
          <th>Portal 1</th>
          <th>Portal 2</th>
          <th>Status</th>
          <th>Link</th>
        </tr>
      </thead>

      <tbody>

		  <?php while ( $query->have_posts() ) : $query->the_post();?>

      <?php
        $field = get_field_object('publicacao_pecas');
        $opcoes = $field['value'];
        $i=0;
      ?>

      <?php include ( locate_template('template-parts/var-tarefas.php') ); ?>

      <tr>
        <td><?php if ( get_field('unidade') ) { the_field('unidade'); } ?></td>
        <td><?php if ($finalidade) { echo $finalidade['label']; } ?></td>
        <td><?php if ($modalidade) { echo $modalidade['label']; } ?></td>
        <td><?php if( $opcoes ) : foreach( $opcoes as $opcao ): ?><?php $i++; if ($i >= 2) { echo ', ';}; echo $field['choices'][ $opcao ]; ?><?php endforeach; endif; ?></td>
        <td><?php if ( get_field('numero_de_atividades') ) { the_field('numero_de_atividades'); } ?></td>
        <td><?php the_title(); ?></td>
        <td><?php if( $area = get_field('area_divulgacao_tarefa') ) { echo $area['label']; } ?></td>
        <td><?php if( get_field('subarea_tarefa') ) { the_field('subarea_tarefa'); } ?></td>
        <td><?php $data = get_the_date('d/m/y'); echo $data; ?></td>
        <td><?php if ( get_field('data_de_inicio_do_evento') ) { the_field('data_de_inicio_do_evento'); } elseif ( get_field('data_de_inicio_do_curso') ) { the_field('data_de_inicio_do_curso'); } ?></td>
        <td><?php if ( $publicacao && in_array('publicacao', $publicacao) ) the_field('previsao_de_publicacao'); else echo 'Sem publicação'; ?></td>
        <td><?php if ( get_field('previsao_conclusao') ) { the_field('previsao_conclusao'); } ?></td>
        <td><?php if ( get_field('tipo_de_criacao') ) { the_field('tipo_de_criacao'); } ?></td>
        <td><?php if ($responsavel1) : echo $responsavel1['display_name']; endif; ?></td>
        <td><?php if ($responsavel2) : echo $responsavel2['display_name']; endif; ?></td>
        <td><?php if ($responsavel3) : echo $responsavel3['display_name']; endif; ?></td>
        <td><?php if ($responsavel4) : echo $responsavel4['display_name']; endif; ?></td>
        <td><?php echo $status['label'] ?></td>
        <td><a href="<?php the_permalink(); ?>">Link</a></td>
      </tr>

		  <?php endwhile; ?>

    </tbody>
  </table>

  <?php endif; ?>

</div>

  <?php else : ?>

<div class="ui container cd-margem">
  <div class="ui hidden divider"></div>
  <h3 class="ui center aligned icon header">
    <a><i class="yellow warning sign in icon"></i></a>
    Você não tem permissão para visualizar essa página.
  </h3>
  <div class="ui hidden divider"></div>
</div>

<?php endif; ?>

<script type="text/javascript" src="<?php bloginfo('template_url')?>/js/export-to-excel.js"></script>

<?php get_footer(); ?>
