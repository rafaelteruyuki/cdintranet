<?php acf_form_head(); ?>

<?php get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/themes/comunicacao-digital/css/form-tarefa.css">

<style media="screen">
.acf-field--post-title {
  display: none;
}
.acf-field-5a26a3dc14060 {
  display: none;
}
</style>

<?php if( current_user_can('edit_pages') ) : ?>

  <!-- MENU EDICAO DESIGNERS -->

  <div class="ui attached stackable menu" style="border: 1px solid rgba(0, 0, 0, 0.1); background:rgba(0,0,0,.05)">
    <div class="ui container">
        <div class="right menu">
       	 <a class="item active" data-tab="first"><i class="file text icon"></i>Tarefa</a>
         <a class="item" data-tab="second" style="border-right:1px solid rgba(0, 0, 0, 0.1)"><i class="edit icon"></i>Editar</a>
        </div>
    </div>
  </div>

<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>

<?php include ( locate_template('template-parts/var-eventos-rede.php') ); ?>

<!-- ***********
  PRIMEIRA TAB
*************-->

<div class="ui tab active" data-tab="first">

<div class="ui hidden divider"></div>

<div class="ui grid container cd-margem">

  <!-- DADOS GERAIS -->

  <div class="four wide column" style="border-right: 1px solid rgba(34,36,38,.15); padding-right: 2rem;">

    <?php $img_evento_rede = get_the_post_thumbnail($evento_rede->ID, 'full', ['style' => 'width:100%; height:auto', 'class' => 'ui bordered image']); echo $img_evento_rede ?>

    <h4 class="ui header">
      Data limite para envio das atividades
      <div class="sub header"><?php the_field('data_limite'); ?>
        <span style="color:red;">(
        <?php
        $x = get_field('data_limite');
        $date = strtotime("$x +2 hour");
        $remaining = $date - time();

        $days_remaining = floor($remaining / 86400);
        $hours_remaining = floor(($remaining % 86400) / 3600);
        echo "Faltam $days_remaining dias e $hours_remaining horas";

        ?>
        )</span>
      </div>

    </h4>
    <h4 class="ui header">
      Unidades participantes
      <div class="sub header">ANA, BAR, BIR, CAS, LIM, MAR, SJR, SCI</div>
    </h4>
    <h4 class="ui header">
      Observações
      <div class="sub header">Atenção! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque et dolor a ipsum ullamcorper efficitur. Nam porta augue at ligula pulvinar, eu feugiat felis porta. Nulla pulvinar mauris ut sem laoreet, ac ultrices turpis posuere.</div>
    </h4>
    <h4 class="ui header">
      Peças de divulgação
    </h4>
    <a href="#" class="ui green button" style="margin-bottom:5px;">E-mail</a>
    <a href="#" class="ui green button" style="margin-bottom:5px;">Banners</a>
    <h4 class="ui header">
      Criado em
      <div class="sub header"><?php echo get_the_date('d/m/y') . ' - às ' . get_the_date('G:i'); ?> <br>por <?php echo get_the_author_meta('display_name'); ?></div>
    </h4>
    <h4 class="ui header">
      Última atualização
      <div class="sub header">
        <?php the_modified_date('d/m/y'); echo ' - às '; the_modified_time('G:i');?>
        <?php if ( get_post_meta(get_post()->ID, '_edit_last') ) { echo '<br>por '; the_modified_author(); } ?>
      </div>
    </h4>

  </div>

  <!-- /DADOS GERAIS -->

  <!-- INTERAÇÕES -->

  <div class="twelve wide column" style="padding-left: 2rem;">

      <h1 class="ui header">
        <div class="sub header">Evento em rede</div>
        <?php the_title(); ?>
      </h1>
      <a href="#" class="ui button cd-atividade-btn">Adicionar atividade</a>
      <!-- ATIVIDADE MODAL -->
      <div class="ui mini modal cd-atividade">
        <i class="close icon"></i>
        <div class="header">
          Nova atividade
        </div>
        <div class="content">
          <?php

          	$alteracoes = array(

            'post_id'		    	=> 'new_post', // Create a new post
            'post_title'			=> true,
            'field_groups'    => array(13842),
            'return' 			    => '%post_url%',
            'new_post'			  => array(
                                'post_type'		=> 'atividades',
                                'post_status'	=> 'publish'
            ),
            'label_placement' => 'top',
            'submit_value'    => 'Enviar',
            'updated_message' => 'Salvo!',
            'html_updated_message'	=> '<div id="message" class="updated"><p>%s</p></div>',
            'html_submit_button'	=> '<input type="submit" class="ui primary large fluid button" value="%s" />',
            'uploader' => 'basic',
          	);

          ?>

          <?php acf_form( $alteracoes ); ?>

        </div>
        <div class="actions">
          <div class="ui cd-cancel-btn button">Cancelar</div>
        </div>
      </div>
      <div class="ui hidden divider"></div>
      <table class="ui sortable selectable small celled table">
        <thead>
          <tr class="center aligned">
            <th class="collapsing">Unidade</th>
            <th class="left aligned ">Título</th>
            <th class="collapsing">Início</th>
            <th class="collapsing">Final</th>
            <th class="collapsing">Status</th>
          </tr>
        </thead>
        <tbody>

      <?php

      $args = array(
        'post_type' => 'atividades',
        'meta_key' => 'evento_em_rede',
        'meta_value' => $evento_rede->ID,
      );

      $the_query = new WP_Query( $args );

      if ( $the_query->have_posts() ) { while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

        <tr>
          <td><?php the_field('unidade') ?></td>
          <td><a href="<?php the_permalink();?>"><?php the_field('tipo_de_atividade') ?> | <?php the_title(); ?></a></td>
          <td><?php the_field('data_e_hora_inicial') ?></td>
          <td><?php the_field('data_e_hora_final') ?></td>
          <td>Publicado</td>
        </tr>

      <?php endwhile; wp_reset_postdata(); } ?>

      </tbody>
    </table>

  </div>

  <!-- /INTERAÇÕES -->

</div>

</div>

<!-- ***********
  SEGUNDA TAB
*************-->

<!-- <div class="ui tab" data-tab="second"> -->

  <?php

  	// $alteracoes = array(
    // 'post_title'      => false,
  	// 'field_groups'    => array (13842),
    // // 'fields'    => array ('field_5a26a3438987c'),
  	// 'return' 			    => '%post_url%',
  	// 'uploader' => 'basic',
  	// 'submit_value'    => 'Enviar',
  	// 'html_submit_button'	=> '<input type="submit" class="ui primary large fluid button" value="%s" />',
  	// //'updated_message' => 'Salvo!'
  	// );

  ?>

  <!-- <div class="ui vertical basic segment" style="background:rgba(0,0,0,.05);">
    <div class="ui grid container stackable">
      <div class="ten wide column cd-box cd-esconder">
        <div class="ui hidden divider"></div>
        <?php // acf_form( $alteracoes ); ?>
        <div class="ui hidden divider"></div>
      </div>
    </div>
  </div> -->

<!-- </div> -->

<?php endwhile; ?>

<script type="text/javascript">

$('.acf-field-5a26a5fb86c04 .acf-input').append( $('#acf-_post_title') ); //Inserir título WP em lugar específico do Form front-end

// (function hideRow () {
//
//   var unidade = '.acf-field[data-name="unidade"]';
//   var user_id = '.acf-field[data-name="user_id"]';
//   var alteracoes = '.acf-field[data-name="alteracoes"]';
//   var data_inicial = '.acf-field[data-name="data_e_hora_inicial"]';
//   var data_final = '.acf-field[data-name="data_e_hora_final"]';
//   var titulo = '.acf-field[data-name="titulo_da_atividade"]';
//   var current_user_id = <?php // echo get_current_user_id(); ?>;
//
//   // Rows collapsed
//   // $('.acf-row').not('.acf-table .acf-table .acf-row').addClass('-collapsed');
//
//   // Rows open
//   $('.acf-row').removeClass('-collapsed');
//
//   // Esconde os controles
//   $('.acf-row-handle.remove').hide();
//   $('.acf-row-handle.order').hide();
//
//   // Esconde o user ID e Alterações
//   $(user_id).hide();
//   $(alteracoes).hide();
//
  // Insere estilo dos botões e ao clicar, some
  $('.acf-actions a').removeClass('button-primary').addClass('ui');
//
//   // Número total de rows
//   var rowsNum = $('.acf-row' + ' ' + unidade).length - 1;
//
//   for (x=0 ; x<rowsNum ; x++) {
//
//     var row = '.acf-row[data-id=' + x + ']';
//     var user_row = $(row + ' ' + user_id + ' input').val(); // Row correspondente ao usuário que a criou
//
//     // Se o usuário logado não for o mesmo que a criou, esconde
//     if (current_user_id != user_row) {
//
//       $(row).hide();
//
//     } else {
//
//       // Esconde os demais campos e deixa visível apenas Alteração
//       var rowPublished = $(row + ' td.acf-fields.-left .acf-field');
//       rowPublished.not(row + ' td.acf-fields.-left ' + alteracoes + ', .acf-table .acf-table td.acf-fields.-left .acf-field').hide();
//
//       //$('.acf-row[data-id=' + x + '] .acf-field-5a1f019ed3d7f .acf-input').append( $('.acf-row[data-id=' + x + '] .acf-field-5a1da2b4b028a input').val() + ' <a class="ui primary button btn-alterar" data-alterar="' + x + '" style="float:right;">Solicitar alteração</a>');
//       // Muda o título e descrição da row
//       $(row + ' ' + alteracoes + ' > .acf-label label').html( $(row + ' ' + titulo + ' input').val() );
//       $(row + ' ' + alteracoes + ' > .acf-label .description').html(
//         'Início: ' + $(row + ' ' + data_inicial + ' input.input').val() + '<br>' +
//         'Final: ' +  $(row + ' ' + data_final + ' input.input').val()
//       );
//
//       // Mostra Alterações apenas nas rows já criadas
//       $(row + ' ' + alteracoes).show();
//
//     }
//
//   }
//
//   // Criar função que registra o current user ID no repeater!!!
//
// })();


// $('.btn-alterar').click(function() {
//   var d = $(this).data('alterar');
//   $('.acf-row[data-id=' + d + ']').removeClass('-collapsed');
// });

</script>

<?php get_footer(); ?>
