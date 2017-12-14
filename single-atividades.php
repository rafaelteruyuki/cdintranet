<?php acf_form_head(); ?>

<?php get_header(); ?>

<link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/themes/comunicacao-digital/css/form-tarefa.css">


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

  <div class="ui inverted segment" style="background-color: aliceblue; margin: 0;">
	<div class="ui grid container cd-margem">
	  <h1 class="ui header">
      <div class="sub header"><?php $evento_rede = get_field('evento_em_rede'); echo $evento_rede->post_title ?></div>
	    <?php the_title(); ?>
	  </h1>
	</div>
</div>
<div class="ui hidden divider"></div>

<?php // $img_evento_rede = get_the_post_thumbnail($evento_rede->ID, 'full', ['class' => 'ui large bordered image']); echo $img_evento_rede ?>

<div class="ui grid container cd-margem">

  <!-- DADOS GERAIS -->

  <div class="four wide column" style="border-right: 1px solid rgba(34,36,38,.15);">

    <h4 class="ui header">
      Unidade
      <div class="sub header"><?php the_field('unidade') ?></div>
    </h4>
    <h4 class="ui header">
      Tipo de atividade
      <div class="sub header">Tipo de atividade</div>
    </h4>
    <h4 class="ui header">
      Data e hora inicial
      <div class="sub header">Data e hora inicial</div>
    </h4>
    <h4 class="ui header">
      Data e hora final
      <div class="sub header">Data e hora final</div>
    </h4>
    <h4 class="ui header">
      Descrição da atividade
      <div class="sub header">Descrição da atividade</div>
    </h4>
    <h4 class="ui header">
      Local de realização
      <div class="sub header">Local de realização</div>
    </h4>
    <h4 class="ui header">
      Público
      <div class="sub header">Público</div>
    </h4>
    <h4 class="ui header">
      Status
      <div class="sub header"><?= $status['label'] ?></div>
    </h4>
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
    <h4 class="ui header">
      Excluir atividade?<br>
      <div class="ui red button cd-delete-btn" style="margin-top:10px;">
        Excluir
      </div>
    </h4>
    <!-- DELETE POST MODAL -->
    <div class="ui mini modal cd-delete">
      <i class="close icon"></i>
      <div class="header">
        Excluir atividade
      </div>
      <div class="content">
        <p>Tem certeza que deseja excluir essa atividade?</p>
      </div>
      <div class="actions">
        <div class="ui cd-cancel-btn button">Cancelar</div>
        <a href="<?php echo get_delete_post_link(); ?>" class="ui negative button">Excluir</a>
      </div>
    </div>

  </div>

  <!-- /DADOS GERAIS -->

  <!-- INTERAÇÕES -->

  <div class="twelve wide column" style="padding-left: 2rem;">

      <!-- BARRA PORCENTAGEM -->
      <div class="label" style="margin-bottom: 10px;"><i class="power <?= $corStatus ?> icon"></i><strong>Status: <?= $status['label'] ?></strong></div>
      <div class="ui small indicating progress" data-percent="<?= $percent ?>" id="example1" style="margin:0;">
        <div class="bar"></div>
      </div>

      <!-- INTERACOES -->
      <h3 class="ui dividing header"><i class="purple comments icon"></i><?php num_comentarios();?></h3><br>
      <?php comments_template(); ?>

  </div>

  <!-- /INTERAÇÕES -->

</div>

</div>

<!-- ***********
  SEGUNDA TAB
*************-->

<div class="ui tab" data-tab="second">

  <?php

  $alteracoes = array(
  'post_title'      => false,
  'field_groups'    => array (13842),
  // 'fields'    => array ('field_5a26a3438987c'),
  'return' 			    => '%post_url%',
  'uploader' => 'basic',
  'submit_value'    => 'Enviar',
  'html_submit_button'	=> '<input type="submit" class="ui primary large fluid button" value="%s" />',
  //'updated_message' => 'Salvo!'
  );

  ?>

  <div class="ui vertical basic segment" style="background:rgba(0,0,0,.05);">
    <div class="ui center aligned container" style="margin-top: 20px;">
      <strong>Atividade criada em: </strong><?= get_the_date('d/m/Y') . ', às ' . get_the_date('G:i'); ?>
    </div>
    <div class="ui grid container stackable">

      <div class="ten wide column cd-box cd-esconder">

        <div class="ui hidden divider"></div>
        <?php acf_form( $alteracoes ); ?>
        <div class="ui hidden divider"></div>

      </div>

    </div>
  </div>

</div>

<?php endwhile; ?>


<?php get_footer(); ?>
