<!doctype html>
<html lang="pt-br">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title class="title-contador"><?php if(is_home()) { echo bloginfo("name"); echo " | "; echo bloginfo("description"); } else { echo wp_title(" | ", false, right); echo bloginfo("name"); } ?></title>
<!--<link rel="shortcut icon" href="front_assets/images/icon.ico">-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

  <!--[if lt IE 9]>
  <div style="margin:0 auto; padding:20px; background-color: #00CCFF; text-align:center; font-family: Arial, Verdana; line-height:1.5; color:#2D2D2D; font-size:18px;">
    <p><img src="http://www.sp.senac.br/msg/gd4/ie-branco.png" width="110" height="108" alt=""/></p>
    <p style="font-size:24px;"><strong>ATENÇÃO!</strong></p>
    <p>
      Você está utilizando uma versão desatualizada do Internet Explorer. <br />
      <strong>O site não será exibido corretamente.</strong> Por favor, atualize seu navegador.<br />
      <br />
    </p>
    <a href="http://windows.microsoft.com/ie" target="_blank" style="padding:20px; background-color:#2D2D2D; text-decoration:none; color:#FFFFFF;"><strong>Baixar a versão mais recente</strong></a>
    <br />
    <br />
  </div>
  <![endif]-->

<!-- SIDEBAR FILTROS -->

<div class="ui wide sidebar vertical menu tarefas">
  <div class="ui hidden divider"></div>
  <h3 style="margin-left: 40px;">Filtros</h3>
  <?php
    if ( is_page( 946 ) ) {
      // echo 'Filtros Minhas Tarefas' . '<br>';
      echo do_shortcode( '[searchandfilter id="2817"]' );
    };
    if ( is_page( 951 ) ) {
      // echo 'Filtros Minhas Solicitacoes' . '<br>';
      echo do_shortcode( '[searchandfilter id="12379"]' );
    };
    if ( is_post_type_archive('tarefa') ) {
      // echo 'Filtros Todas as Tarefas' . '<br>';
      echo do_shortcode( '[searchandfilter id="4806"]' );
    };
  ?>
  <a data-tooltip="Voltar" class="ui icon cd-filtro button tarefas" style="margin: 20px 0 0 40px;">
	<i class="arrow left icon"></i>
  </a>
</div>

<!-- PUSHER SIDEBAR -->

<div class="pusher">

<!-- HEADER -->

<div class="ui inverted vertical segment" id="cd-header">
  <div class="ui two column grid container stackable" style="margin:2em 0">
    <div class="middle aligned column">
      <a href="<?php bloginfo("url");?>">
        <h1 class="ui header inverted">Comunicação Digital
          <div class="sub header inverted">Gerência de Comunicação e Relações Institucionais</div>
        </h1>
      </a>
    </div>
    <div class="right aligned column">
      <img src="<?php bloginfo('template_url'); ?>/images/logo-senac-branco.png" width="130">
    </div>
  </div>
</div>

<!-- MENU -->

<div class="ui attached stackable inverted menu" style="border: 1px solid rgba(255, 255, 255, 0.1);">
  <div class="ui container" style="border-left:1px solid rgba(255, 255, 255, 0.1); border-right:1px solid rgba(255, 255, 255, 0.1)">

    <!-- <a href="<?php // bloginfo( 'url' ); ?>" class="item"><i class="grid layout icon"></i> Catálogo de Peças</a> -->
    <div class="ui dropdown item">
        <i class="grid layout icon"></i>Peças
        <i class="dropdown icon"></i>
        <div class="menu">
          <a href="<?php bloginfo( 'url' ); ?>" class="item"><i class="grid layout icon"></i>Catálogo</a>
          <a href="<?php bloginfo( 'url' ); ?>/wp-content/uploads/Campanhas_Email_Marketing.xlsx" class="item"><i class="linkify icon"></i>Tagueamento</a>
        </div>
    </div>
    <a href="<?php bloginfo( 'url' ); ?>/solicitacao/" class="item"><i class="edit icon"></i>Nova solicitação</a>
    <a href="<?php bloginfo( 'url' ); ?>/redes-sociais/" class="item"><i class="globe icon"></i> Redes Sociais</a>
    <a href="https://datastudio.google.com/u/0/reporting/0B9hh3lIugd49bnRLbTdSSmlrZTQ/page/2QpF" class="item" target="_blank"><i class="chart line icon"></i> Métricas</a>

    <div class="right menu">

      <?php global $current_user; ?>

      <!--BOTAO LOGIN-->
      <?php if ( !is_user_logged_in() ) : ?>
      <a href="<?php echo wp_login_url(get_permalink()); ?>" class="item cd-login"><i class="sign in icon"></i> Login</a>
      <?php endif; ?>

      <!--LOGIN-->
      <?php if ( is_user_logged_in() ) : ?>
        <div class="ui dropdown item cd-user-logado">
          <span class="ui mini rounded image"><?php echo get_avatar( $current_user->ID, 24 ); ?></span><?php echo $current_user->display_name ?>
          <i class="dropdown icon"></i>
          <div class="menu">

            <!-- ADMINISTRADOR -->
            <?php if ( current_user_can( 'administrator' ) ) : ?>
              <a href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php?post_type=curso" class="item"><i class="block layout icon"></i>Novo Curso</a>
              <a href="<?php bloginfo( 'url' ); ?>/minhas-tarefas/" class="item"><i class="list layout icon"></i>Minhas tarefas</a>
              <a href="<?php bloginfo( 'url' ); ?>/minhas-solicitacoes/" class="item"><i class="list layout icon"></i>Minhas solicitações</a>
              <a href="<?php bloginfo( 'url' ); ?>/tarefa/" class="item"><i class="list icon"></i>Todas as tarefas</a>
              <a class="item" id="calculadora-prazos"><i class="checked calendar icon"></i>Calculadora de prazos</a>
              <a href="<?php bloginfo( 'url' ); ?>/exportar-tarefas/" class="item"><i class="download icon"></i>Exportar tarefas</a>
            <?php endif; ?>

            <!-- DESIGNERS -->
            <?php if ( current_user_can( 'edit_dashboard' ) ) : ?>
              <a href="<?php bloginfo( 'url' ); ?>/wp-admin/post-new.php?post_type=curso" class="item"><i class="block layout icon"></i>Novo Curso</a>
              <a href="<?php bloginfo( 'url' ); ?>/minhas-tarefas/" class="item"><i class="list layout icon"></i>Minhas tarefas</a>
              <a href="<?php bloginfo( 'url' ); ?>/tarefa/" class="item"><i class="list icon"></i>Todas as tarefas</a>
              <a class="item" id="calculadora-prazos"><i class="checked calendar icon"></i>Calculadora de prazos</a>
            <?php endif; ?>

            <!-- PORTAL -->
            <?php if ( current_user_can( 'portal' ) ) : ?>
              <a href="<?php bloginfo( 'url' ); ?>/minhas-tarefas/" class="item"><i class="list layout icon"></i>Minhas tarefas</a>
              <a href="<?php bloginfo( 'url' ); ?>/tarefa/" class="item"><i class="list icon"></i>Todas as tarefas</a>
              <a class="item" id="calculadora-prazos"><i class="checked calendar icon"></i>Calculadora de prazos</a>
              <a href="<?php bloginfo( 'url' ); ?>/exportar-tarefas/" class="item"><i class="download icon"></i>Exportar tarefas</a>
            <?php endif; ?>

            <!-- REDES SOCIAIS -->
            <?php if ( current_user_can( 'redes_sociais' ) ) : ?>
              <a href="<?php bloginfo( 'url' ); ?>/minhas-solicitacoes/" class="item"><i class="list layout icon"></i>Minhas solicitações</a>
              <a href="<?php bloginfo( 'url' ); ?>/tarefa/" class="item"><i class="list icon"></i>Todas as tarefas</a>
              <a class="item" id="calculadora-prazos"><i class="checked calendar icon"></i>Calculadora de prazos</a>
            <?php endif; ?>

            <!-- SENAC -->
            <?php if ( current_user_can( 'senac' ) ) : ?>
              <a href="<?php bloginfo( 'url' ); ?>/minhas-solicitacoes/" class="item"><i class="list layout icon"></i>Minhas solicitações</a>
            <?php endif; ?>

            <!-- TODOS -->
            <a href="<?php bloginfo( 'url' ); ?>/meu-perfil/" class="item"><i class="user icon"></i>Meu perfil</a>
            <a href="<?php echo wp_logout_url( home_url() ); ?>" class="item"><i class="sign out icon"></i>Sair</a>

          </div>
        </div>
      <?php endif; ?>

      <!-- CD-FEED -->
      <?php if ( is_user_logged_in() ) : ?>
      <div class="ui scrolling dropdown item cd-user-logado">
        <i class="comment icon" style="margin:0;"></i>
        <div class="contador floating ui label"><i class="loading refresh icon" style="margin:0;"></i></div>
        <div class="menu" id="refresh">
          <?php get_template_part('comment','feed') ?>
        </div>
      </div>
      <?php endif; ?>

    </div>

  </div>
</div>

<div class="cd-push"></div>

<script type="text/javascript">

var cd_title = '<?php if(is_home()) { echo bloginfo("name"); echo " | "; echo bloginfo("description"); } else { echo wp_title(" | ", false, right); echo bloginfo("name"); } ?>';
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>"; //Define o endereço AJAX

// calculadora de prazos
$('#calculadora-prazos').click(function() {
  var url = '<?php bloginfo( 'url' ); ?>' + '/calculadora-de-prazos/';
  window.open(url, "", "width=550,height=500");
});

</script>
<script id="script-refresh" type='text/javascript' src='<?php echo get_template_directory_uri() ?>/js/feed-refresh.js?ver=6.3'></script>
